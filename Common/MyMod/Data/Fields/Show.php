<?php


trait MyMod_Data_Fields_Show
{
    //*
    //* function MyMod_Data_Fields_Info, Parameter list: $data
    //*
    //* Generates data Info field, returns .
    //*

    function MyMod_Data_Field_Info($data)
    {
        $value=$this->ItemData[ $data ][ "Info" ];

        if (preg_match('/^http(s)?:\/\//',$value))
        {
            $value=$this->A($value,$value);
        }

        return $value;
    }
    
    //*
    //* function MyMod_Data_Fields_Show, Parameter list: $data,$item,$plural=FALSE,$iconify=TRUE,$callmethod=TRUE
    //*
    //* Generates data show field.
    //*

    function MyMod_Data_Fields_Show($data,$item,$plural=FALSE,$iconify=TRUE,$callmethod=TRUE)
    {
        $this->ItemData($data);

        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        if (empty($this->ItemData[ $data ]))
        {
            $this->DoDie("No such ItemData defined",$this->ModuleName,$data,$this->ItemData);
        }
        
        if (
            preg_match('/^(VAR)?CHAR/',$this->ItemData[ $data ][ "Sql" ])
            &&
            $this->ItemData[ $data ][ "TrimCase" ]
           )
        {
            $value=$this->TrimCase($value);
            $item[ $data ]=$value;
        }

        $access=$this->MyMod_Data_Access($data,$item);
        if ($access<1)
        {
            return "forbidden";
        }

        if (!empty($this->ItemData[ $data ][ "ConditionalShow" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "ConditionalShow" ];

            $res=$this->$fieldmethod($data,$item,$plural);

            if (!empty($res)) { return $res; }
        }


        $fieldmethod="";
        if (!empty($this->ItemData[ $data ][ "FieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "FieldMethod" ];
        }
        if (!empty($this->ItemData[ $data ][ "ShowFieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "ShowFieldMethod" ];
        }

        if ($callmethod && !empty($fieldmethod))
        {
            if (!method_exists($this,$fieldmethod))
            {
                die("No such field method: ".$fieldmethod);
            }

            return $this->$fieldmethod($data,$item,0);
        }
        elseif (!empty($this->ItemData[ $data ][ "Info" ]))
        {
            return $this->MyMod_Data_Field_Info($data);
        }
        elseif (
                  $this->ItemData[ $data ][ "Sql" ]=="TEXT"
                  ||
                  (
                     !empty($this->ItemData[ $data ][ "Size" ])
                     &&
                     preg_match('/\d+x\d+/',$this->ItemData[ $data ][ "Size" ])
                  )
               )
        {
            $value=$this->MyMod_Data_Fields_Text_Show($data,$item,$value);
        }
        /* elseif ( */
        /*           !empty($this->ItemData[ $data ][ "Type" ]) */
        /*           && */
        /*           $this->ItemData[ $data ][ "Type" ]=="TEXT" */
        /*        ) */
        /* { */
        /*     return "text"; */
        /* } */
        elseif (
                  $this->ItemData[ $data ][ "Sql" ]=="TEXT"
                  ||
                  (
                     !empty($this->ItemData[ $data ][ "Size" ])
                     &&
                     preg_match('/\d+x\d+/',$this->ItemData[ $data ][ "Size" ])
                  )
               )
        {
            $value=$this->MyMod_Data_Field_Show_Text($data,$value);
            $value=preg_replace('/\n/',"<BR>",$value);
        }
        elseif (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ]))
        {
            $value="";
            if (isset($item[ $data ])) { $value=$item[ $data ]; }

            $rvalue=$this->FileFieldDecorator($data,$item,$plural,0);
            $value=$rvalue;
        }
        elseif ($this->ItemData[ $data ][ "Password" ])
        {
            $value=$this->ShowPasswordField($data,$value);
        }
        elseif (!empty($this->ItemData[ $data ][ "TimeType" ]))
        {
            $value="-";
            if (!empty($item[ $data ]))
            {
                $value=$this->TimeStamp2Text($item[ $data ]);
            }
        }
        elseif (
                  $iconify
                  &&
                  !empty($this->ItemData[ $data ][ "Iconify" ])
                  &&
                  $this->ItemData[ $data ][ "Iconify" ]
                  &&
                  !$this->LatexMode()
               )
        {
            if ($this->ItemData[ $data ][ "Iconify" ]==2)
            {
                $value=$item[ $data ];
                if (!empty($this->ItemData[ $data ][ "IconifyText" ]))
                {
                    if (!empty($item[ $data ]))
                    {
                        $value=$this->Filter($this->ItemData[ $data ][ "IconifyText" ],$item);
                    }
                }

                $value="<A HREF='".$item[ $data ]."'>".$value."</A>";
            }
            elseif ($this->ItemData[ $data ][ "Iconify" ])
            {
                $file=$item[ "ID" ]."_".$data.".png";
                $value=$this->IconText
                (
                   $file,
                   $item[ $data ],
                   $this->ItemData[ $data ][ "IconColors" ],
                   $this->ItemData[ $data ][ "BkIconColors" ]
                );
            }
            else
            {
                $file=$this->ItemData[ $data ][ "Iconify" ];
                $extrapath_pathcorrection=$this->ExtraPathPathCorrection();
                if ($extrapath_pathcorrection!="")
                {
                    $file=$extrapath_pathcorrection."/".$file;
                }

                $value="<IMG SRC='".$file."' BORDER='0' ALT='img'";
                if ($this->ItemData[ $data ][ "Width" ]!="")
                {
                    $value.=" WIDTH='".$this->ItemData[ $data ][ "Width" ]."'";
                }
                if ($this->ItemData[ $data ][ "Height" ]!="")
                {
                    $value.=" HEIGHT='".$this->ItemData[ $data ][ "Height" ]."'";
                }

                $value.=">";
                $value="<A HREF='".$item[ $data ]."'>".$value."</A>";
            }
        }
        elseif (
                isset($this->ItemData[ $data ][ "Filter" ])
                ||
                isset($this->ItemData[ $data ][ $this->Profile."Filter" ])
               )
        {
            $value="";
            if (isset($this->ItemData[ $data ][ $this->Profile."Filter" ]))
            {
                $value=$this->ItemData[ $data ][ $this->Profile."Filter" ];
            }
            elseif (isset($this->ItemData[ $data ][ "Filter" ]))
            {
                $value=$this->ItemData[ $data ][ "Filter" ];
            }

            if ($value!="" && method_exists($this,$value))
            {
                $value=$this->$value($data,$item);
            }

            $value=$this->Filter($value,$item);
            $value=$this->FilterObject($value);
        }
        elseif ($this->MyMod_Data_Fields_Module_Class($data))
        {
            $value=$this->MyMod_Data_Fields_Module_Show($data,$item,$value,$plural);
        }
        elseif ($this->ItemData[ $data ][ "Sql" ]=="ENUM")
        {
            $value=$this->GetEnumValue($data,$item);

            if (
                  !$this->LatexMode()
                  &&
                  isset($item[ $data ])
                  &&
                  $item[ $data ]>0
                  &&
                  !empty($this->ItemData[ $data ][ "ValueColors" ])
               )
            {
                $color=$this->ItemData[ $data ][ "ValueColors" ][ $item[ $data ]-1 ];
                $value=$this->TextColor($color,$value);
            }
        }
        elseif (!empty($this->ItemData[ $data ][ "IsDate" ]))
        {
            $value=$this->CreateDateShowField($data,$item,$value);
        }
        elseif (!empty($this->ItemData[ $data ][ "IsHour" ]))
        {
            $value=$this->CreateHourShowField($data,$item,$value);
        }
        else
        {
            if (isset($item[ $data ]) && $item[ $data ]) { $value=$item[ $data ]; }
            else
            {
                if (
                  preg_match('/^(\S+)_(.+)/',$data,$matches) &&
                  !empty($this->ItemData[ $matches[1] ][ "SqlObject" ])
                )
                {
                    $basedata=$matches[1];

                    $object=$this->ItemData[ $basedata ][ "SqlObject" ];
                    $keys=preg_grep('/^'.$basedata.'_/',array_keys($item));

                    $ritem=array();
                    foreach ($keys as $kid => $key)
                    {
                        $rkey=preg_replace('/^'.$basedata.'_/',"",$key);
                        $ritem[ $rkey ]=$item[ $key ];
                    }

                    $value=$this->$object->MakeShowField($matches[2],$ritem,$plural,$iconify);
                }
                else
                {
                    $value=$this->GetEnumValue($data,$item);
                    if (!$this->LatexMode() && !empty($this->ItemData[ $data ][ "ValueColors" ]))
                    {
                        $color=$this->ItemData[ $data ][ "ValueColors" ][ $item[ $data ]-1 ];
                        $value=$this->TextColor($color,$value);
                    }
                }
            }
        }


        if (!empty($this->ItemData[ $data ][ "Format" ]))
        {
            $value=sprintf($this->ItemData[ $data ][ "Format" ],$value);
        }

        if (!$plural)
        {
            $value.=$this->FieldComment($data);
        }

        if (preg_match('/^0\s?$/',$value)) { $value=""; }

        return $value;
    }

    //*
    //* function MyMod_Data_Fields_Show_Text, Parameter list: $data,$value
    //*
    //* Generates show text field. Split for HTML/Latex.
    //*

    function MyMod_Data_Field_Show_Text($data,$value)
    {
        if ($this->LatexMode())
        {
            return $this->MyMod_Data_Field_Show_Text_Latex($data,$value);
        }
        else
        {
            return $this->MyMod_Data_Field_Show_Text_HTML($data,$value);
        }
    }
    
    //*
    //* function MyMod_Data_Fields_Show_Text_HTML, Parameter list: $data,$value
    //*
    //* Generates latex preprocessed show filed contents.
    //*

    function MyMod_Data_Field_Show_Text_HTML($data,$value)
    {
            $size=$this->ItemData[ $data ][ "Size" ];
            $size=preg_split('/\s*x\s*/',$size);

            $width=50;
            if ($size[0]) { $width=$size[0]; }
            $value=preg_replace("/(\s*\n\s*)+/","<BR>\n",$value);

            $values=preg_split('/\s+/',$value);
            $rvalues=array();

            $rvalue="";
            foreach ($values as $svalue)
            {
                if (strlen($rvalue.$svalue)<$width)
                {
                    $rvalue.=" ".$svalue;
                }
                else
                {
                    array_push($rvalues,$rvalue);
                    $rvalue=$svalue;
                }
            }

            if (preg_match('/\S/',$rvalue)) { array_push($rvalues,$rvalue); }

            $value=join($this->BR(),$rvalues);
        return $value;
    }

    //*
    //* function MyMod_Data_Fields_Show_Text_Latex, Parameter list: $data,$value
    //*
    //* Generates latex preprocessed show filed contents.
    //*

    function MyMod_Data_Field_Show_Text_Latex($data,$value)
    {
        return $value;
    }
}

?>