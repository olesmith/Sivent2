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
        if (empty($tabindex) && !empty($this->ItemData[ $data ][ "TabIndex" ]))
        {
            $tabindex=$this->ItemData[ $data ][ "TabIndex" ];
        }

        $options=array();
        if (!empty($tabindex)) { $options[ "TABINDEX" ]=$tabindex; }

        if
            (
                $callmethod
                &&
                $fieldmethod=$this->MyMod_Data_Fields_Method($item,$data)
            )
        {
           $value=$this->$fieldmethod($data,$item,1,$rdata);
        }
        /* elseif ($this->ItemData[ $data ][ "Type" ]=="TEXT") ////Heim????? 08/01/2017 */
        /* { */
        /*     return ""; */
        /* } */
        elseif ($this->MyMod_Data_Field_Is_Color($data))
        {
            //Color fields
            $value=$this->MyMod_Data_Fields_Color_Field($data,$item,1,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Derived($data))
        {
            //Derived data
            $value=$item[ $data ];
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            //Enums
            $value=
                $this->MyMod_Data_Field_Enum_Edit
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
        elseif ($this->MyMod_Data_Field_Is_Text($data))
        {
            //TEXTAREAS: Text and Varchar
            $value=
                $this->MyMod_Data_Fields_Text_Edit
                (
                    $data,
                    $item,
                    $value,
                    $rtabindex,
                    $plural,
                    $options,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_Module($data))
        {
            //ID in another module table
            $value=
                $this->MyMod_Data_Fields_Module_Edit
                (
                    $data,
                    $item,
                    $value,
                    $rtabindex,
                    $plural,
                    $options,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_File($data))
        {
            //File fields
            $value=
                $this->MyMod_Data_Field_File_Edit
                (
                    $data,
                    $item,
                    $value,
                    $tabindex,
                    $plural,
                    $links,
                    $callmethod,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_Password($data))
        {
            $value=$this->MyMod_Data_Field_Password_Edit($data,$value,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=$this->MyMod_Data_Field_Date_Edit($rdata,$item,$value);
        }
        elseif ($this->ItemData[ $data ][ "IsHour" ])
        {
            $value=$this->MyMod_Data_Field_Hour_Edit($rdata,$item,$value);
        }
        else
        {
            $value=$this->MyMod_Data_Field_Input_Edit($data,$value,$rdata,$plural,$options);
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
           $value.=$this->MyMod_Data_Field_Comment($data,1);
        }

        if
            (
                !empty($this->ItemData[ $data ][ "CGIName" ])
                &&
                !$plural
            )
        {
            $regex="\sNAME='$data";
            if (preg_match('/'.$regex.'/',$value))
            {
                $value=preg_replace('/'.$regex.'/'," NAME='".$this->ItemData[ $data ][ "CGIName" ],$value);
            }
        }

        
        return $value;
    }
   //*
    //* Create default type field: input text.
    //*

    function MyMod_Data_Field_Input_Edit($data,$value,$rdata,$plural,$options)
    {
        $size=25;
        if ($this->ItemData[ $data ][ "Size" ])
        {
            $size=$this->ItemData[ $data ][ "Size" ];
        }
        
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
            
        return $this->MakeInput($rdata,$value,$size,$options);
    }
    

   //*
    //* Returns comment to add to field
    //*

    function MyMod_Data_Field_Comment($data,$edit=0)
    {
        if (
            !$this->NoFieldComments
            &&
            !isset($this->ItemData[ $data ][ "NoComment" ])
           )
        {
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"Comment");
            if ($comment!="")
            {
                return $comment;
            }
            
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"EditComment");
            if ($edit==1 && $comment!="")
            {
                return $comment;
            }
        }

        return "";
    }

}

?>