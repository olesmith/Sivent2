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
            $this->ItemHash=$this->ReadItemDerivedData($this->ItemHash,$datas);
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
            $this->ItemHash=$this->PostProcessItem($this->ItemHash);
        }

        //Store Items read
        if ($updatesitemhashes)
        {
            $this->ItemHashes[ $id ]=$this->ItemHash;
        }

        return $this->ItemHash;
    }

}

?>