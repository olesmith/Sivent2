<?php


trait MyMod_Item_Read
{
    //*
    //* Reads item from db.
    //*

    function MyMod_Item_Read($id,$datas=array(),$noderiveds=FALSE,$updatesitemhashes=TRUE,$postprocess=TRUE)
    {
        if (count($datas)==0)
        {
            $datas=array_keys($this->ItemData);
        }

        if (
              $this->ItemNamer!=""
              &&
              !preg_grep('/^'.$this->ItemNamer.'$/',$datas)
              &&
              !empty($this->ItemData[ $this->ItemNamer ])
            )
        {
            array_push($datas,$this->ItemNamer);
        }

        //Skip derived data from list of data to read
        $datas=$this->NonDerivedData($datas);
        $rdatas=array();
        foreach ($datas as $data)
        {
            /* if ($this->DBFieldExists($this->SqlTableName(),$data)) */
            if (!empty($this->ItemData[ $data ]))
            {
                array_push($rdatas,$data);
            }
        }

        //Check if all data has been read and store in $this->ItemHashes[ $id ].
        //If so, just return this array.
        if (!is_array($id) && isset($this->ItemHashes[ $id ]))
        {
            $ok=TRUE;
            foreach ($rdatas as $data)
            {
                if (!isset($this->ItemHashes[ $id ][ $data ]))
                {
                    $ok=FALSE;
                    break;
                }
            }

            if ($ok)
            {
                return $this->ItemHashes[ $id ];
            }
        }

        if (empty($id)) { $id=$this->GetCGIVarValue("ID"); }

        $where=$id;
        if (!is_array($where))
        {
            $where=$this->GetRealWhereClause(array($this->IDWhereVar => $id));
        }

        $this->ItemHash=$this->SelectUniqueHash($this->SqlTableName(),$where,FALSE,$rdatas);

        if (is_array($id) && !empty($this->ItemHash[ "ID" ]))
        {
            $id=$this->ItemHash[ "ID" ];
        }

        if (empty($this->ItemHash))
        {
            $this->AddMsg
            (
               $this->ModuleName.": Unable to read item ID: ".$id."in ".
               $this->SqlTableName()
            );

            return array();
        }

        $this->DatasRead=$datas;
        if (!$noderiveds)
        {
            $this->ItemHash=$this->MyMod_Item_Derived_Data_Read($this->ItemHash,$datas);
        }

        foreach ($datas as $n => $data)
        {
            if (isset($this->ItemData[ "Default" ]))
            {
                if ($this->ItemHash[ $data ]=="")
                {
                    $this->ItemHash[ $data ]=$this->ItemData[ "Default" ];
                    $this->MySqlSetItemValue
                    (
                       $this->SqlTableName(),
                       "ID",$this->ItemHash[ "ID" ],
                       $data,$this->ItemData[ "Default" ]
                    );
                }
            }
        }

        if ($postprocess)
        {
            $this->ItemHash=$this->MyMod_Item_PostProcess($this->ItemHash);
        }

        //Store Items read
        if ($updatesitemhashes)
        {
            $this->ItemHashes[ $id ]=$this->ItemHash;
        }

        return $this->ItemHash;
    }

    //*
    //* function MyMod_Item_Derived_Data_Read, Parameter list: $item
    //*
    //* Reads derived item data:
    //*
    //* 'Real' derived data. We distinguish between dependent
    //* and independent data; for ex. FirstNames and LastName
    //* may be considered independent, and FullName=FirstNames.LastName
    //* as dependent.
    //* SqlTable: Deprecated, but goes to other table to read the data; actual 
    //* data value is the ID in this table.
    //* SqlObject: OO way to automatically reads values in other table.
    //* Objects may be shared between data, and subitems are read as needed.
    //* Note, that the subitem is READ ONLY.
    //*

    function MyMod_Item_Derived_Data_Read($item,$datas=array())
    {
        if (count($datas)==0)
        {
            $datas=$this->DatasRead;
        }
        if (count($datas)==0)
        {
            $datas=$this->ItemDerivers;
        }

        if (!is_array($datas))
        {
            return $item;
        }

        foreach ($datas as $did => $data)
        {
            if (!preg_grep('/^'.$data.'$/',$this->ItemDerivers))
            {
                continue;
            }

            $derivedid=0;
            if (isset($item[ $data ])) { $derivedid=$item[ $data ]; }

            if (isset($this->ItemData[ $data ][ "SqlClass" ]))
            {
                $item=$this->SubItem2Item($item,$data);
            }
            else
            {
                $derivedtable=$this->ItemData[ $data ][ "SqlTable" ];

                //Used to prepend to all key of data read
                //this way we may read multiple data in other table
                $prefix=$data."_";
                if (isset($this->ItemData[ $data ][ "SqlDataPrefix" ]))
                {
                    $prefix=$this->ItemData[ $data ][ "SqlDataPrefix" ];
                }


                //Next, test if data has a registered method to generate the select ids and names
                //Day set SqlDisableds too 
                if (isset($this->ItemData[ $data ][ "SqlSelectGenMethod" ]))
                {
                    $method=$this->ItemData[ $data ][ "SqlSelectGenMethod" ];
                    if (method_exists($this,$method))
                    {
                        $this->$method($data,$item);
                    }
                }

                if ($derivedid>0)
                {
                    $deriveditem=$this->SelectUniqueHash($derivedtable,"ID='".$derivedid."'",1);

                    if (!is_array($deriveditem))
                    {
                        $name=$this->MyMod_Item_Name_Get($item);
                        
                        $this->AddMsg
                       (
                        $this->ModuleName.", ID ".$item[ "ID" ].", ".$name.": ".
                        "Error lendo ($data) '".
                        $this->ItemData[ $data ][ "Name" ]."' ID=".
                        $derivedid." em tabela ".$derivedtable
                       );

                        if ($this->LoginType=="Admin")
                        {
                            $url=
                                $this->ScriptPath()."/".
                                $this->ScriptName()."?".
                                $this->LoginQueryString."&Action=Edit&ID=".$item[ "ID" ];

                            $this->AddMsg
                            (
                               $this->Href
                               (
                                  $url,
                                  "; Editar ".$this->ItemName,"Corrigir ".$this->ItemName,"_item"
                               ),
                               2
                            );
                        }
                    }

                    $deriveddata=$this->ItemData[ $data ][ "SqlDerivedData" ];
                    foreach ($deriveddata as  $id => $ddata)
                    {
                        $item[ $prefix.$ddata ]=$deriveditem[ $ddata ];
                    }
                }
                else
                {
                    $deriveddata=$this->ItemData[ $data ][ "SqlDerivedData" ];
                    if (is_array($deriveddata))
                    {
                        foreach ($deriveddata as $ddata)
                        {
                            $item[ $prefix.$ddata ]="";
                        }
                    }
                }
            }
        }

        return $item;
    }

}

?>