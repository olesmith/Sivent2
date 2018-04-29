<?php

trait MyMod_Data_Fields_Enums
{
    //*
    //* function MyMod_Data_Field_Enum_Edit, Parameter list: $data,$item,$value,$tabindex,$plural,$links,$callmethod,$rdata 
    //*
    //* Creates input field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Enum_Edit($data,$item,$value,$tabindex,$plural,$links,$callmethod,$rdata,$ignoredefault=False)
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $options=array();
        if (!empty($tabindex) ) { $options[ "TABINDEX" ]=$tabindex; }

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
        
        $checkbox=False;
        if (!empty($this->ItemData[ $data ][ "SelectCheckBoxes" ]))
        {
            $checkbox=$this->ItemData[ $data ][ "SelectCheckBoxes" ];
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
               $fieldtitle="",
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
    //* function MyMod_Data_Fields_Enums_Value, Parameter list: $data,$item,$latex=FALSE
    //*
    //* Used $this->ItemData[ $data ][ "Values" ] to obtain
    //* enum value of $data in $item.
    //* Implements also a ValuesMatrix, so that dependent of another
    //* ENUM entry, the actual values may change. Ex:
    //* Bibliography Area and Subarea.
    //* Substitutes enum nos with text values in $item, for. One enum.
    //* If $latex is true and $this->ItemData[ $data ] has 
    //* "Values_Latex" key, these are used instead of the the "Values" key.
    //* Also tests if $data"_Orig" key is set in $item.
    //* If it is, this means that Enums value has been substituted in
    //* $item, and so, the value to regenerate should be $data"_Orig" and
    //* not $data. Routines that substitutes enums, should set $data"_Orig".
    //*
    //* Data may be of type ENUM, SqlTable/Object  and Derived.
    //*
    //* Returns enum value.
    //*

    function MyMod_Data_Fields_Enums_Value($data,&$item,$latex=FALSE)
    {
        $type=$this->ItemData($data,"Sql");

        $value="";        
        if (!isset($item[ $data ]))
        {
            $empty=$this->GetEnumEmptyName($data);;
            if (!empty($empty))
            {
                $value=$empty;
            }

            return $value;
        }

        if ($this->LatexMode()) { $latex=TRUE; }


        $value=$item[ $data ];
        if ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $values=array();
            if (
                  !empty($this->ItemData[ $data ][ "ValuesMatrix" ]) 
                  &&
                  is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) 
                  &&
                  !empty($this->ItemData[ $data ][ "ValuesDependencyVar" ])
               )
            {
                $values=$this->GetDependentEnumValues($data,$item,$latex);
            }
            elseif ($latex && isset($this->ItemData[ $data ][ "Values_Latex" ]))
            {
                $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values_Latex");
            }
            else
            {
                $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values");
            }

            if (!isset($item[ $data."_Orig" ]) || $item[ $data."_Orig" ]=="")
            {
                if ($value && isset($values[ $value-1 ]))
                {
                    $value=$values[ $value-1 ];
                }
            }
            else
            {
                $value=$item[ $data ];
            }

            $empty=$this->GetEnumEmptyName($data);
            if (!empty($empty))
            {
                if (empty($value))
                {
                    $value=$empty;
                }
            } 
        }
        elseif ($this->MyMod_Data_Field_Is_Derived($data))
        {
            if ($this->ItemData[ $data ][ "SqlDerivedNamer" ]!="")
            {
                $ddata=$data."_".$this->ItemData[ $data ][ "SqlDerivedNamer" ];
                $value=$item[ $ddata ];
            }
            elseif ($this->ItemData[ $data ][ "Derived" ]!="" &&
                    preg_match('/#/',$this->ItemData[ $data ][ "DerivedFilter" ]))
            {
                $filter=$this->ItemData[ $data ][ "DerivedFilter" ];
                $value=$this->Filter($filter,$item);
            }
        }
        elseif ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $subitem=
                $this->MyMod_Data_2Module($data)->Sql_Select_Hash
                (
                   array("ID" => $item[ $data ]),
                   $this->MyMod_Data_2ModuleKey($data,"SqlDerivedData")
                );
            
            if (empty($subitem)) { $subitem=array(); }

            
            $value=$this->Filter
            (
               $this->MyMod_Data_2ModuleKey($data,"SqlFilter"),
               $subitem
            );

            foreach ($subitem as $rkey => $rvalue)
            {
                $item[ $data."__".$rkey ]=$rvalue;
            }
        }


        return $value;
    }
    
    //*
    //* function MyMod_Data_Fields_Enums_ApplyAll, Parameter list: $edit,$item,$data,$plural=FALSE,$tabindex="",$rdata=""
    //*
    //* Applies ENUM and SQL fields on $item.
    //*

    function MyMod_Data_Fields_Enums_ApplyAll($item=array(),$latex=FALSE,$datas=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($item)) { return $item; }
        if (empty($datas)) { $datas=$this->DatasRead; }

        if (empty($datas)) { $datas=array_keys($item); }

        $this->ItemData("ID");
        foreach ($datas as $no => $data)
        {
            if (
                  $this->MyMod_Data_Field_Is_Sql($data)
               )
            {
                if (!isset($item[ $data."_Orig" ]) || $item[ $data."_Orig" ]=="")
                {
                    $value="";
                    if (isset($item[ $data ])) { $value=$item[ $data ]; }
                    
                    if (!empty($item[ $data ]))
                    {
                        $subitem=$this->MyMod_Data_Fields_Module_SubItem_Get($data,$item);
                        if (is_array($subitem) && !empty($subitem))
                        {
                            foreach ($subitem as $key => $val)
                            {
                                $item[ $data."_".$key ]=$val;
                            }
                            
                            $item[ $data."__ID" ]=$item[ $data."_ID" ];
                        }
                    }
                    
                    $item[ $data ]=$this->MyMod_Data_Fields_Enums_Value($data,$item,$latex);
                    $item[ $data."_Orig" ]=$value;
                }
            }
            elseif (
                  $this->MyMod_Data_Field_Is_Enum($data)
                  ||
                  $this->MyMod_Data_Field_Is_Derived($data)
               )
            {
                if (!isset($item[ $data."_Orig" ]) || $item[ $data."_Orig" ]=="")
                {
                    $value="";
                    if (isset($item[ $data ])) { $value=$item[ $data ]; }
                    $item[ $data ]=$this->MyMod_Data_Fields_Enums_Value($data,$item,$latex);
                    $item[ $data."_Orig" ]=$value;
                }
                elseif (preg_match('/^[AMC]Time$/',$data) && preg_match('/^\d+$/',$item[ $data ]))
                {
                    $item[ $data ]=$this->TimeStamp2Text($item[ $data ]);
                }
            }
            elseif (
                      $this->MyMod_Data_Field_Is_Date($data)
                   )
            {
                $value="";
                if (!empty($item[ $data ])) { $value=$item[ $data ]; }
                $item[ $data ]=$this->CreateDateShowField($data,$item,$value);
            }
             elseif (
                      $this->MyMod_Data_Field_Is_Time($data)
                   )
            {
                $value="";
                if (!empty($item[ $data ])) { $value=$item[ $data ]; }
                
                $item[ $data ]=$this->TimeStamp2Text($value);
            }
       }

        return $item;
    }    
}

?>