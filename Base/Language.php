<?php

class Language extends Dir
{
    //*
    //* function GetLanguage, Parameter list: 
    //*
    //* Returns language as set by Language.
    //* If unset, calls DetectLanguage and
    //* returns value obtained.
    //*

    function GetLanguage()
    {
        if ($this->Language==FALSE)
        {
            //$this->DetectLanguage();
        }

        return $this->Language;
    }


    //*
    //* function GetLanguageKeys, Parameter list: 
    //*
    //* Returns list of avaliable language keys -
    //* used to retrieved languaged data.
    //*

    function GetLanguageKeys()
    {
        $langs=array_keys($this->Languages);
        $rlangs=array();
        foreach ($langs as $id => $lang)
        {
            if ($lang==$this->DefaultLanguage) { $lang=""; }
            if ($lang!="") { $lang="_".$lang; }
            array_push($rlangs,$lang);
        }

        return $rlangs;
    }


    //*
    //* function GetRealNameKey, Parameter list: $hash,$key="Name"
    //*
    //* Retrives key $key in $hash, as appropriate language,
    //* Deprecated, should be migrated to use GetMessage!
    //*

    function GetRealNameKey($hash,$key="Name")
    {
        $language=$this->ApplicationObj()->GetLanguage();

        $val="";
        if (
            $language!=""
            &&
            isset($hash[ $key."_".$language ])
            &&
            $hash[ $key."_".$language ]!=""
           )
        {
            $val=$hash[ $key."_".$language ];
        }
        elseif (
                isset($hash[ $key ])
                &&
                $hash[ $key ]!=""
               )
        {
            $val=$hash[ $key ];
        }

        return $val;
        
    }

    //*
    //* function GetMessage, Parameter list: $file,$key,$subkey="Name"
    //*
    //* Retrieves message $key => $subkey from file $file.
    //* Files are read in full as needed, maintaining result in memory
    //* to be used by future calls to GetMessage.
    //* Read message files, are store in $this->Messages hash:
    //* 
    //*   $this->Messages[ $file ][ $key ][ $subkey ]
    //*
    //* $subkey is subject to language iteration.
    //*

    function GetMessage($file,$key,$subkey="Name")
    {
        return $this->MyLanguage_GetMessage($key,$subkey);
    }


    //*
    //* function GetLangDataValue, Parameter list: $item,$field
    //*
    //* Reads language defs.
    //*

    function GetLangDataValue($item,$field)
    {
        return $this->GetRealNameKey($item,$field);
    }
    //*
    //* function GetLangDataTitle, Parameter list: $field
    //*
    //* Reads language defs.
    //*

    function GetLangDataTitle($field)
    {
        return $this->GetRealNameKey($this->ItemData[ $field ],"Title");
    }

}

?>