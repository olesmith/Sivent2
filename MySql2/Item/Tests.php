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
               "Outdated attempt: ".$item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item)
            );

            $msg=
                "Mudou depois que este formulário carregou,<BR>".
                "atualização insegura omitido<BR>Recarregar cliqando aqui: ".
                $this->MyActions_Entry("Edit",$this->ItemHash,1);

            $this->AddMsg($this->MyMod_Item_Name_Get($item).": ".$msg);
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
        return $this->MyMod_Data_Fields_Test($data,$item,$plural,$prepost);
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