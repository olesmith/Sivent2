<?php


trait MyMod_Data_Fields_Test
{
     //*
    //* Tests if item should be updated.
    //*

    function MyMod_Data_Fields_Test($data,&$item,$plural=FALSE,$prepost="")
    {
        $oldvalue="";
        if (isset($item[ $data ])) { $oldvalue=$item[ $data ]; }

        if ($this->MyMod_Data_Field_Is_Time($data)) { return $oldvalue; }

        $access=$this->MyMod_Data_Access($data,$item);
        if ($access<2)
        {
            return $oldvalue;
        }


        $rdata=$this->MyMod_Data_Field_CGIName($data,$plural,$prepost);

        $newvalue="";
        if ($this->MyMod_Data_Field_Is_Date($data))
        {
            $newvalue=$this->GetPOST($rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Hour($data))
        {
            $newvalue=
                sprintf("%02d",$this->GetPOST($rdata."Hour")).
                sprintf("%02d",$this->GetPOST($rdata."Min"));
        }
        elseif ($this->MyMod_Data_Field_Is_Real($data))
        {
            if (!isset($_POST[ $rdata ]))
            {
                return $oldvalue;
            }
            
            $newvalue=$this->GetPOST($rdata);
            $newvalue=preg_replace('/,/',".",$newvalue);
        }
        elseif (
              preg_match('/^ENUM$/',$this->ItemData[ $data ][ "Sql" ])
              &&
              $this->ItemData[ $data ][ "SelectCheckBoxes" ]==3)
        {
            if (!isset($_POST[ $rdata ]))
            {
                $newvalue=1;
            }
            else
            {
                $newvalue=2;
            }
        }
        else
        {
            if (!isset($_POST[ $rdata ]))
            {
                return $oldvalue;
            }

            $newvalue=$this->GetPOST($rdata);
        }

        if ($this->MyMod_Data_Field_Is_Unique($data))
        {
            $where=array($data => $newvalue);
            $nn=$this->Sql_Select_NEntries($where);
            if ($nn>0 && $newvalue!=$item[ $data ])
            {
                $newvalue=$oldvalue;
                
                $msg=
                    $this->MyMod_Item_Name_Get($item)." ".
                    $data.": ".$newvalue."': ".
                    $this->GetMessage($this->ItemDataMessages,"DataNotUniqued");
                $this->ApplicationObj()->AddHtmlStatusMessage($msg);
                
                $item[ $data."_Message" ]=$msg;
            }
        }
        
        if (
              preg_match('/^(Add|Copy)$/',$this->Action)
              &&
              $this->AddDefaults[ $data ]!=""
           )
        {
            $newvalue=$this->AddDefaults[ $data ];
        }

        if (isset($this->ItemData[ $data ][ "Regexp" ]))
        {
            if (
                  $newvalue!=""
                  &&
                  !preg_match('/'.$this->ItemData[ $data ][ "Regexp" ].'/',$newvalue)
               )
            {
                $item[ $data."_Message" ]=
                    $this->MyMod_Item_Name_Get($item)." ".
                    "'".$newvalue."': ".
                    $this->GetMessage($this->ItemDataMessages,"DataInvalid");

                if (isset($this->ItemData[ $data ][ "RegexpText" ]))
                {
                    $item[ $data."_Message" ].="<BR>".$this->ItemData[ $data ][ "RegexpText" ];
                }
                else
                {
                    $item[ $data."_Message" ].="<BR>".$this->ItemData[ $data ][ "Regexp" ];
                }


                if (is_array($this->HtmlStatus))
                {
                    array_push($this->HtmlStatus,$item[ $data."_Message" ]);
                }
                else
                {
                    $this->HtmlStatus.=$item[ $data."_Message" ]."<BR><BR>";
                }

                $newvalue=$item[ $data ];
            }
        }

        $newvalue=$this->TreatNewValue($newvalue);

        //Allow emptying, if not compulsory.
        if (empty($newvalue))
        {
            if ($this->MyMod_Data_Field_Is_Compulsory($data))
            {
                $this->ApplicationObj()->AddHtmlStatusMessage($newvalue." undef e ".$data." obrigatorio - ignorado!");
                $newvalue=$oldvalue;
            }
            else
            {
                if (preg_match('/INT/',$this->ItemData[ $data ][ "Sql" ]))
                {
                    $newvalue=0;
                }
                if (preg_match('/(VARCHAR|TEXT)/',$this->ItemData[ $data ][ "Sql" ]))
                {
                    $newvalue="";
                }

            }
        }

        if ($oldvalue!=$newvalue)
        {
            
            if ($this->MyMod_Data_Field_Is_Crypted($data) && $newvalue!="")
            {
                $newvalue=$this->MyMod_Data_Field_Crypt($data,$newvalue);
            }

            return $newvalue;
        }

        return $oldvalue;
    }
}

?>