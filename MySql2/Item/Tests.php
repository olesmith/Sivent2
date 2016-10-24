<?php

include_once("Tests/Item.php");

class ItemTests extends ItemTestsItem
{
   //*
    //* function ItemCompulsoriesUndefined, Parameter list: $item=array(),$datas=array()
    //*
    //* Tests item according to whether all compulsory fields are defined.
    //* Returns lista of undefined data, empty list of all defined.
    //*


    function ItemCompulsoriesUndefined($item=array(),$datas=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($datas)) { $datas=array_keys($this->ItemData); }

        $rdatas=array();
        foreach ($datas as $data)
        {
            if ($this->ItemData[ $data ][ "Compulsory" ])
            {
                if (empty($item[ $data ]))
                {
                    $res=FALSE;
                    array_push($rdatas,$data);
                }
            }
        }

        return $rdatas;
    }



    //*
    //* Tests whether $item[ $data ] is unique.
    //*

    function ItemDataIsUnique($item,$data)
    {
        if (!empty($item[ $data ]) && empty($this->ItemData[ $data ][ "Derived" ]))
        {
            $nitems=$this->MySqlNEntries("",array($data => $item[ $data ]));
            if ($nitems>1)
            {
                if (!array($this->HtmlStatus))
                {
                    $this->HtmlStatus=array($this->HtmlStatus);
                }

                $msg=
                    $this->ItemName.": Campo ".$this->ItemData[ $data ][ "Name" ].
                    " não é único: ".$item[ $data ];

                array_push($this->HtmlStatus,$msg);
                return FALSE; 
            }
        }

        return TRUE;
    }


   //*
   //* Tests if data declared uniques ("Unique" => 1) is really unique.
   //* First detects the list of data that needs to be unique.
   //* Then queiries the DB if any of these values in $item
   //* are already present.
   //* Returns the TRUE, if everything OK, FALSE it nonunique.
   //*

    function ItemIsUnique($item)
    {
        foreach ($this->ItemData as $data => $value)
        {
            if (empty($this->ItemData[ $data ][ "Unique" ])) { continue; }
            if (empty($item[ $data ])) { continue; }

            $nitems=$this->MySqlNEntries("",array($data => $item[ $data ]));
            if ($nitems>0)
            {

                $this->ApplicationObj->AddHtmlStatusMessage
                (
                   "Campo ".
                   $this->ItemData[ $data ][ "Name" ].
                   " não é único - ".
                   $this->ItemName
                );

               return FALSE; // return right away, minimizing mysql talks
            }
        }

        if (!empty($this->UniqueSqlWhere))
        {
            $nitems=$this->MySqlNEntries("",$this->UniqueSqlWhere);

            if ($nitems>0)
            {
                if (!array($this->HtmlStatus))
                {
                    $this->HtmlStatus=array($this->HtmlStatus);
                }

                $msg=$this->ItemName." ".$this->MyLanguage_GetMessage("IsNotUnique");

                array_push($this->HtmlStatus,$msg);
                return FALSE; 
            }
            
        }

        return TRUE;
    }

 
    //*
    //* Tests item mtime, in rel a form mtime.
    //*

    function TestItemMTime($item,$formmtime=0)
    {
        return TRUE;
        if ($formmtime==0)
        {
            $formmtime=$this->GetPOST("__MTime__");
        }

        $itemmtime=$item[ "MTime" ];
        if ($formmtime<$itemmtime)
        {
            //If any MTime change, we should'nt update
            $this->ApplicationObj->LogMessage
            (
               "UpdateItem",
               "Outdated attempt: ".$item[ "ID" ].": ".$this->GetItemName($item)
            );

            $msg=
                "Mudou depois que este formulário carregou,<BR>".
                "atualização insegura omitido<BR>Recarregar cliqando aqui: ".
                $this->MyActions_Entry("Edit",$this->ItemHash,1);

            $this->AddMsg($this->GetItemName($item).": ".$msg);
            $this->HtmlStatus.=$msg."<BR>";

            $item[ "MTime" ]=$formmtime;

            return FALSE;
        }

        return TRUE;
    }

    //*
    //* Treats $newvalue, backspaces and stuff.
    //*

    function TreatNewValue($newvalue)
    {
        //replace's
        $newvalue=preg_replace("/'/","&#39;",$newvalue);

        //backslashes
        $newvalue=preg_replace('/\\\\/',"&#92;",$newvalue);
        //$newvalue=preg_replace("/&#92;&#92;/","&#92;",$newvalue);
        $newvalue=preg_replace('/\s+$/',"",$newvalue);

        return $newvalue;
    }


     //*
    //* Tests if item should be updated.
    //*

    function TestUpdateItem($data,&$item,$plural=FALSE,$prepost="")
    {
        $oldvalue="";
        if (isset($item[ $data ])) { $oldvalue=$item[ $data ]; }

        if (!empty($this->ItemData[ $data ][ "TimeType" ])) { return $oldvalue; }

        $access=$this->MyMod_Data_Access($data,$item);
        if ($access<2)
        {
            return $oldvalue;
        }

        $cginame=$data;
        if (!empty($this->ItemData[ $data ][ "CGIName" ]) && !$plural)
        {
            $cginame=$this->ItemData[ $data ][ "CGIName" ];
        }

        $rdata=$cginame;
        if ($plural) { $rdata=$item[ "ID" ]."_".$rdata; }
        elseif ($prepost) { $rdata=$prepost.$rdata; }

        $newvalue="";
        if ($this->ItemData[ $data ][ "IsDate" ])
        {
            $newvalue=$this->GetPOST($rdata);
        }
        elseif ($this->ItemData[ $data ][ "IsHour" ])
        {
            $newvalue=
                sprintf("%02d",$this->GetPOST($rdata."Hour")).
                sprintf("%02d",$this->GetPOST($rdata."Min"));
        }
        elseif ($this->ItemData[ $data ][ "Sql" ]=="REAL")
        {
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
                return 1;
            }
            else
            {
                return 2;
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

        if (!empty($this->ItemData[ $data ][ "Unique" ]))
        {
            $where=array($data => $newvalue);
            $nn=$this->Sql_Select_NEntries($where);
            if ($nn>0 && $newvalue!=$item[ $data ])
            {
                $newvalue=$oldvalue;
                
               $msg=
                    $this->GetItemName($item)." ".
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
                    $this->GetItemName($item)." ".
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
            if ($this->ItemData[ $data ][ "Compulsory" ])
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
            if ($this->ItemData[ $data ][ "MD5" ] && $newvalue!="")
            {
                $newvalue=md5($newvalue);
            }

            return $newvalue;
        }

        return $oldvalue;
    }

    //*
    //* function TestPRN, Parameter list: $item
    //*
    //* Verifies brazilian PRN, rejects if invalid.
    //*

    function TestPRN($prn)
    {
        $body = substr($prn,0,9);
        $dv = substr($prn,9,2);
        $d1 = 0;
        for ($i = 0; $i < 9; $i++)
        {
            $d1 += intval( substr ($body, $i, 1)) * (10 - $i);
        }

        $res=TRUE;
        if ($d1 == 0)
        {
            $res=FALSE;
        }

        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9)
        {
            $d1 = 0;
        }
        if (substr ($dv, 0, 1) != $d1)
        {
            $res=FALSE;
        }

        $d1 *= 2;
        for ($i = 0; $i < 9; $i++)
        {
            $d1 += intval(substr($body, $i, 1)) * (11 - $i);
        }
        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9)
        {
            $d1 = 0;
        }
        if (substr ($dv, 1, 1) != $d1)
        {
            $res=FALSE;
        }

        if (!$res)
        {
            $this->ApplicationObj()->AddHtmlStatusMessage("CPF ".$prn." Inválido!");
            echo $this->H(5,"CPF ".$prn." Inválido!");
        }

        return $res;
    }
}
?>