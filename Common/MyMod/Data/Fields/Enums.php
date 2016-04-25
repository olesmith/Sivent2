<?php

trait MyMod_Data_Fields_Enums
{
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
            if (!empty($this->ItemData[ $data ][ "EmptyName" ]))
            {
                $value=$this->ItemData[ $data ][ "EmptyName" ];
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

            if (!empty($this->ItemData[ $data ][ "EmptyName" ]))
            {
                if (empty($value))
                {
                    $value=$this->ItemData[ $data ][ "EmptyName" ];
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

    function MyMod_Data_Fields_Enums_ApplyAll($item=array(),$latex=FALSE)
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($item)) { return $item; }

        if (empty($this->DatasRead)) { $this->DatasRead=array_keys($item); }

        $this->ItemData("ID");

        foreach ($this->DatasRead as $no => $data)
        {
            if (
                  $this->MyMod_Data_Field_Is_Enum($data)
                  ||
                  $this->MyMod_Data_Field_Is_Derived($data)
                  ||
                  $this->MyMod_Data_Field_Is_Sql($data)
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
                      isset($this->ItemData[ $data ]["IsDate" ])
                      &&
                      $this->ItemData[ $data ][ "IsDate" ]
                   )
            {
                $value="";
                if (!empty($item[ $data ])) { $value=$item[ $data ]; }
                $item[ $data ]=$this->CreateDateShowField($data,$item,$value);
            }
        }

        return $item;
    }    
}

?>