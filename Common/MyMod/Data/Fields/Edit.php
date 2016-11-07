<?php



trait MyMod_Data_Fields_Edit
{
    //*
    //* function MyMod_Data_Fields_Edit, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata=""
    //*
    //* Creates input field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Fields_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata="")
    {
        $sql=$this->ItemData($data,"Sql");
        if (empty($rdata))
        {
            $rdata=$data;
            if ($plural && !empty($item[ "ID" ]))
            {
                $rdata=$item[ "ID" ]."_".$data;
            }
        }
        
        //Save and then disable tabindex
        $rtabindex=$tabindex;
        //$tabindex="";
        if (empty($tabindex) && !empty($this->ItemData[ $data ][ "TabIndex" ]))
        {
            $tabindex=$this->ItemData[ $data ][ "TabIndex" ];
        }

        $options=array();
        if (!empty($tabindex)) { $options[ "TABINDEX" ]=$tabindex; }

        if ($callmethod && $fieldmethod=$this->MyMod_Data_Fields_Method($item,$data))
        {
           $value=$this->$fieldmethod($data,$item,1,$rdata);
        }
        elseif ($this->ItemData[ $data ][ "Type" ]=="TEXT")
        {
            return "";
        }
        elseif ($this->ItemData[ $data ][ "IsColor" ])
        {
           $value=$this->MyMod_Data_Fields_Color_Field($data,$item,1,$rdata);
        }
        elseif (!empty($this->ItemData[ $data ][ "Derived" ]))
        {
            $value=$item[ $data ];
        }
        elseif ($this->ItemData[ $data ][ "Sql" ]=="ENUM")
        {
            $value=$this->CreateDataSelectField
            (
               $data,
               $item,
               $value,
               0,
               $this->ItemData[ $data ][ "SelectCheckBoxes" ],
               "",
               $tabindex,
               $rdata,
               $options
            );
        }
        elseif (
                  $sql=="TEXT"
                  ||
                  (
                     !empty($this->ItemData[ $data ][ "Size" ])
                     &&
                     preg_match('/\d+x\d+/',$this->ItemData[ $data ][ "Size" ])
                  )
               )
        {
            $value=$this->MyMod_Data_Fields_Text_Edit($data,$item,$value,$rtabindex,$plural,$options,$rdata);
        }
       elseif ($this->MyMod_Data_Fields_Module_Class($data))
        {
            $value=$this->MyMod_Data_Fields_Module_Edit($data,$item,$value,$rtabindex,$plural,$options,$rdata);
        }
        elseif (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ]))
        {
            $value=
                $this->MakeFileField
                (
                   $rdata,
                   array
                   (
                    "SIZE" => $this->ItemData[ $data ][ "Size" ],
                    "Title" => $this->MyMod_Data_Fields_File_Extensions_Permitted_Text($data)
                   )
                ).
                $this->MyMod_Data_Fields_File_Decorator($data,$item,$plural,1);
        }
        elseif ($this->ItemData[ $data ][ "Password" ])
        {
            $value=$this->MakePasswordField($rdata,$value);
        }
        elseif ($this->ItemData[ $data ][ "IsDate" ])
        {
            $value=$this->CreateDateField($rdata,$item,$value);
        }
        elseif ($this->ItemData[ $data ][ "IsHour" ])
        {
            $value=$this->CreateHourSelectFields($rdata,$item,$value);
        }
        else
        {
            $size=25;
            if ($this->ItemData[ $data ][ "Size" ]) { $size=$this->ItemData[ $data ][ "Size" ]; }
            if ($plural && !empty($this->ItemData[ $data ][ "TableSize" ]))
            {
                $size=$this->ItemData[ $data ][ "TableSize" ];
            }

            if (!empty($this->ItemData[ $data ][ "Format" ]))
            {
                $value=sprintf($this->ItemData[ $data ][ "Format" ],$value);
            }

            if (!empty($this->ItemData[ $data ][ "AutoComplete" ]))
            {
                $options=array("AUTOCOMPLETE" => $this->ItemData[ $data ][ "AutoComplete" ]);
            }
            
            $value=$this->MakeInput($rdata,$value,$size,$options);
        }


        if (
              $this->CGI_POSTint($this->ModuleName."_TabMovesDown")==1
              &&
              !empty($rtabindex)
              &&
              !preg_match('/\sTABINDEX=/i',$value)
           )
        {
            $value=
                preg_replace
                (
                 '/<(INPUT|SELECT|TEXTAREA)\s+/i',
                 "<$1 TABINDEX='".$rtabindex."'",
                 $value
                );
        }

        if (!$plural)
        {
            $value.=$this->FieldComment($data,1);
        }

        if (!empty($this->ItemData[ $data ][ "CGIName" ]) && !$plural)
        {
            $regex="\sNAME='$data";
            if (preg_match('/'.$regex.'/',$value))
            {
                $value=preg_replace('/'.$regex.'/'," NAME='".$this->ItemData[ $data ][ "CGIName" ],$value);
            }
        }

        
        return $value;
    }


}

?>