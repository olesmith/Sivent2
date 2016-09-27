<?php

class SelectFields extends FileFields
{
    //*
    //* Variables of Fields class:
    //*


    //*
    //* Creates input field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function CreateDataSelectField($data,$item,$value="",$ignoredefault=0,$checkbox=FALSE,$fieldtitle="",$tabindex=0,$rdata="",$options=array())
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $options=array();
        if (!empty($tabindex) ) { $options[ "TABINDEX" ]=$tabindex; }

        if (!empty($this->ItemData[ $data ][ "SqlClass" ]))
        {
            return $this->CreateSubItemSelectField($data,$item,$value,$ignoredefault);
        }

        if ($value=="" && isset($item[ $data ])) { $value=$item[ $data ]; }

        //Put select items in alphabetic order
        $sorteds=array();  //names
        $rvalues=array();  //numbers
        $values=array();
        if (
            is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) &&
            $this->ItemData[ $data ][ "ValuesDependencyVar" ]!=""
           )
        {
            $val=$item[ $this->ItemData[ $data ][ "ValuesDependencyVar" ] ];
            if ($val!="" && $val>0)
            {
                $values=$this->GetDependentEnumValues($data,$item,FALSE);
            }
        }
        else
        {
            $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values");
            if (!is_array($values) || count($values)==0)
            {
                if (!empty($this->ItemData[ $data ][ "SqlClass" ]))
                {
                    $values=array();
                    $this->ReadSubItemValues($data,$item);
                }
                else
                {
                    $this->Debug=1;
                    $this->AddMsg("ENUM data $data has no values set");
                    $values=array();
                }
            }
        }

        $n=$this->ItemData[ $data ][ "SelectOffset" ];
        $keys=array_keys($values);
        if (count($keys)>0)
        {
            //Values is array, we need only the keys
            if (is_array($values[ $keys[0] ]))
            {
                $values=$keys;
            }
        }

        foreach ($values as $val)
        {
            $sorteds[ $val ]=$n;
            array_push($rvalues,$val);

            $n++;
        }

        if (!$this->ItemData[ $data ][ "NoSort" ] && !$this->ItemData[ $data ][ "NoSelectSort" ])
        {
            sort($rvalues,SORT_STRING);
        }

        $values=array();
        $names=array();
        if ($checkbox==FALSE)
        {
            if (empty($this->ItemData[ $data ][ "NoSearchEmpty" ]))
            {
                $values=array(0);
                $names=array($this->GetEnumEmptyName($data));
            }
        }
        elseif ($checkbox==2)
        {
            $values=array();
            $names=array();
        }

        foreach ($rvalues as $val)
        {
            array_push($values,$sorteds[ $val ]+1);

            if ($this->ItemData[ $data ][ "MaxLength" ]>0)
            {
                $val=substr($val,0,$this->ItemData[ $data ][ "MaxLength" ]);
            }

            array_push($names,$val);
            $n++;
        }

        if ($value==0 &&  $ignoredefault==0 &&  $this->ItemData[ $data ][ "Default" ])
        {
            $value=$this->ItemData[ $data ][ "Default" ];
        }

        if ($checkbox==1)
        {
            $options[ "ALIGN" ]='left';
            $value=
                $this->MakeCheckBoxSetTable($rdata,$values,$names,$value,3,$options);
        }
        elseif ($checkbox==2)
        {
             $options[ "ALIGN" ]='left';
             $value=$this->MakeRadioSet($rdata,$values,$names,$value,$tabindex);
        }
        elseif ($checkbox==3)
        {
            $options[ "ALIGN" ]='left';
            $options[ "TABINDEX" ]=$tabindex;
            
            $value=$this->MakeCheckBox($rdata,1,$value-1,FALSE,$options);
        }
        else
        {
            $value=$this->MakeSelectField
            (
               $rdata,
               $values,
               $names,
               $value,
               array(),
               array(),
               $fieldtitle,
               0,
               FALSE,
               FALSE,
               NULL,
               $options
            );
        }

        return $value;
   }

    //*
    //* function SqlClassObj, Parameter list: $data
    //*
    //* Returns object associated with $data.
    //*

    function SqlClassObj($data)
    {
        $accessor=$this->ItemData[ $data ][ "SqlClass" ]."Obj";
        return $this->ApplicationObj->$accessor();
    }

    //*
    //* function ApplySqlObjectDataNames, Parameter list: &$item,$datas
    //*
    //* Loops of $datas, for SqlObject $data fields, substituting $item[ $data ]
    //* with name value from $sqlobj->Name($item[ $data ]) call.
    //*

    function ApplySqlObjectDataNames(&$item,$datas)
    {
        foreach ($datas as $data)
        {
           if (!empty($item[ $data ]))
            {
                if ($this->MyMod_Data_Field_Is_Sql($data))
                {
                    $item[ $data ]=$this->SqlClassObj($data)->Name(array("ID" => $item[ $data ]));
                }
                elseif ($this->MyMod_Data_Field_Is_Enum($data))
                {
                    $this->ApplyEnum($data,$item);
                }
            }
            else
            {
                $item[ $data ]="";
            }
        }
    }

    //*
    //* function MakeSelectShowField, Parameter list: $data,$datas,$namer,$item,$titler="",$empty=""
    //*
    //* Returns show field entry.
    //*

    function MakeSelectShowField($data,$datas,$namer,$item,$titler="",$empty="")
    {
        if (empty($item[ $data ])) { return ""; }

        $ritem=$this->SelectUniqueHash
        (
           "",
           array("ID" => $item[ $data ]),
           FALSE,
           $datas
        );

        $this->ApplySqlObjectDataNames($ritem,$datas);

        $name="";
        if (method_exists($this,$namer))
        {
            $name=$this->$namer($namer);
        }
        else
        {
            $name=$this->Filter($namer,$ritem);
        }

        $title="";
        if (method_exists($this,$titler))
        {
            $titler=$this->$titler();
        }
        else
        {
            $title=$this->Filter($titler,$ritem);
        }

        if (!empty($title))
        {
            $name=$this->Span($name,array("TITLE" => $title));
        }

        return $name;
    }

    //*
    //* function MakeSelectFieldWithItems, Parameter list: $edit,$data,$items,$datas,$namer,$item,$rdata="",$titler=""
    //*
    //* Create a select field, inlcuding only items satisfying $where.
    //* Reads $datas and filters $namer.
    //*

    function MakeSelectFieldWithItems($edit,$data,$items,$datas,$namer,$item,$rdata="",$titler="",$empty="")
    {
        if ($edit==0)
        {
            return $this->MakeSelectShowField($data,$datas,$namer,$item,$titler,$empty);
        }

        $values=array();
        $names=array();
        $titles=array();

        $value=0;
        if(!empty($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        else { $empty=""; }

        $values=array(0);
        $names=array($empty);
        if (!empty($titler)) { $titles=array(""); }


        $title="";
        foreach ($items as $ritem)
        {
            if (!empty($ritem[ "__Disabled__" ]))
            {
                array_push($values,"disabled");
            }
            else
            {
                array_push($values,$ritem[ "ID" ]);
            }

            $this->ApplySqlObjectDataNames($ritem,$datas);

            array_push($names,$this->Filter($namer,$ritem));
            if (!empty($titler))
            {
                array_push($titles,$this->Filter($titler,$ritem));
                if ($ritem[ "ID" ]==$value) { $title=$this->Filter($titler,$ritem); }
            }
            elseif ($ritem[ "ID" ]==$value)
            {
                $title=$this->Filter($namer,$ritem);
            }
        }

        

        if (empty($rdata)) { $rdata=$data; }

        return $this->MakeSelectField
        (
           $rdata,
           $values,
           $names,
           $value,
           array(),
           $titles,
           $title
        );
    }

    //*
    //* function MakeSelectFieldWithWhere, Parameter list: $edit,$data,$where,$datas,$namer,$sortby,$item,$rdata="",$titler="",$empty=""
    //*
    //* Create a select field, inlcuding only items satisfying $where.
    //* Reads $datas and filters $namer.
    //*

    function MakeSelectFieldWithWhere($edit,$data,$where,$datas,$namer,$sortby,$item,$rdata="",$titler="",$empty="")
    {
        if ($edit==0)
        {
            return $this->MakeSelectShowField($data,$datas,$namer,$item);
        }

        $key=$data."_".$this->Hash2SqlWhere($where);
        if (empty($this->TmpItem[ $key ]))
        {
            $this->TmpItem[ $key ]=$this->SelectHashesFromTable
            (
               "",
               $where,
               $datas,
               FALSE,
               $sortby
            );
        }

        return
            $this->MakeSelectFieldWithItems
            (
               $edit,
               $data,
               $this->TmpItem[ $key ],
               $datas,
               $namer,
               $item,
               $rdata,
               $titler,
               $empty
            );
    }

}

?>