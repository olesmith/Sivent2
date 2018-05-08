<?php

include_once("Fields/Time.php");
include_once("Fields/File.php");
include_once("Fields/Select.php");
include_once("Fields/Password.php");
include_once("Fields/Input.php");
include_once("Fields/Show.php");
include_once("Fields/Field.php");

class Fields extends FieldFields
{
    //*
    //* Variables of Fields class:
    //*


    //*
    //*
    //* Returns true if $data is an Sql INT type.
    //*

    function DataIsIntType($data)
    {
        if (
              isset($this->ItemData[ $data ])
              &&
              !empty($this->ItemData[ $data ][ "Sql" ])
              &&
              $this->ItemData[ $data ][ "Sql" ]=="INT"
           )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    //*
    //* function MakePRNField, Parameter list: $data,$item,$edit=1
    //*
    //* 
    //*

    function MakePRNField($data,$item,$edit=1)
    {
        $prn="";
        if (isset($item[ $data ]))
        {
            $prn=$item[ $data ];
            if (preg_match('/^(\d\d\d)\.?(\d\d\d)\.?(\d\d\d)-?(\d\d)$/',$item[ $data ],$matches))
            {
                $prn=$matches[1].".".$matches[2].".".$matches[3]."-".$matches[4];
            }
        }

        if ($edit==0)
        {
            return $prn;
        }
        else
        {
            return $this->MakeInput($data,$prn,15);
        }
    }

    



     //*
    //*
    //* function SystemLink, Parameter list: $url,$text,$title="",$dest="",$options=array()
    //*
    //* Generate link within the system, preserving internal URL parameters.
    //*

    function SystemLink($url,$text,$title="",$dest="",$options=array())
    {
        $rurl=$this->CGI_Script_Query_Hash();
        foreach ($url as $key => $value)
        {
            $rurl[ $key ]=$value;
        }

        if (!empty($dest))
        {
            $options[  "TARGET" ]=$dest;
        }

        return $this->Href
        (
           "?".$this->CGI_Hash2Query($rurl),
           $text,
           $title,
           $options[  "TARGET" ],
           "",
           FALSE,
           $options
         );
    }
}

?>