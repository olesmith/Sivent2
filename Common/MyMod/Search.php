<?php

include_once("Search/Field.php");
include_once("Search/Vars.php");
include_once("Search/Hiddens.php");
include_once("Search/CGI.php");
include_once("Search/Rows.php");
include_once("Search/Options.php");
include_once("Search/Table.php");
include_once("Search/HTML.php");
include_once("Search/Form.php");
include_once("Search/Wheres.php");


trait MyMod_Search
{
    var $MyMod_Search_Table_Two_Col=False;
    
    var $MyMod_Search_Table_Written=FALSE;
    var $MyMod_Search_Post_Text="";
    var $MyMod_Search_Extra_Method=NULL;
    var $MyMod_Search_Table_Module=NULL;
    var $MyMod_Search_Vars_Add_2_List=FALSE;
    
    var $MyMod_Search_Messages="Search.php";
    var $MyMod_Search_Res_Vars=array();

    use
        MyMod_Search_Field,
        MyMod_Search_Vars,
        MyMod_Search_Hiddens,
        MyMod_Search_CGI,
        MyMod_Search_Rows,
        MyMod_Search_Options,
        MyMod_Search_Table,
        MyMod_Search_HTML,
        MyMod_Search_Form,
        MyMod_Search_Wheres;

     //*
    //* function MyMod_Search_Items, Parameter list: $datas
    //*
    //* Does the actual searching. Will only search over 
    //* non-int (INT/ENUM ) values, as these should
    //* be included by the where clause.
    //*

    function MyMod_Search_Items($searchvars=array(),$novals=0,$postvars=TRUE)
    {
        if ($postvars && empty($searchvars))
        {
            $searchvars=$this->MyMod_Search_Vars_Post_Where();
        }

        $ritems=array();
        foreach ($this->ItemHashes as $id => $item)
        {
            $include=1;
            foreach ($searchvars as $data => $value)
            {
                if ($include==0 || empty($value)) { continue; }

                $value=preg_replace('/\//',"\/",$value);
                $value=preg_replace('/_/'," ",$value);
                if (preg_match('/\S/',$value))
                {
                    if ($novals!=0)
                    {
                        $itemvalue=$this->GetEnumValue($data,$item);
                    }
                    else
                    {
                        $itemvalue=$item[ $data ];
                    }

                    if (
                        isset($this->ItemData[ $data ])
                        &&
                        $this->ItemData[ $data ][ "SqlObject" ]
                       )
                    {
                        $value=$this->MyMod_Search_CGI_Text_Value($data);

                        $value=$this->MyMod_Search_CGI_Value_Trim($value);
                        if (!$this->MatchSubItemValue($data,$item[ $data ],$value))
                        {
                            $include=0;
                        }
                    }
                    else
                    {
                        $itemvalue=$this->MyMod_Search_CGI_Value_Trim($itemvalue);
                        $svalue=$this->MyMod_Search_CGI_Value_Trim
                        (
                           //html_entity_decode($value,ENT_COMPAT,'UTF-8')
                           $value
                        );

                        if ($novals!=0)
                        {
                            if (!preg_match('/^'.$svalue.'$/',$itemvalue))
                            {
                                $include=0;
                            }             
                        }
                        elseif (!preg_match('/'.$svalue.'/',$itemvalue))
                        {
                            $include=0;
                        }
                    }
                }
            }

            if ($include==1)
            {
                $ritems[ $id ]=$item;
            }
        }

        $this->ItemHashes=$ritems;
    }


}

?>