<?php

include_once("MyLanguage/Messages.php");


trait MyLanguage
{
    use MyLanguage_Messages;

    var $Language_Default="PT";
    var $Language="PT";
    var $LanguageKey="";

    var $Languages=array();

    var $MessagesFiles=array();
    var $Messages=array();

    //*
    //* function MyLanguage_Init, Parameter list: 
    //*
    //* Initilializes language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_Init()
    {
        $this->ApplicationObj()->Languages=array
        (
           "PT" => array
           (
              "Key" => "",
              "Name" => "PT",
              
              "Title" => "Português",
              "Title_UK" => "Portuguese",
              "Title_ES" => "Portuguese",
              "Icon" => "br.png",
           ),
           "UK" => array
           (
              "Key" => "UK",
              "Name" => "UK",
              "Title" => "Inglês",
              "Title_UK" => "English",
              "Title_PT" => "Ingles",
              "Icon" => "uk.png",
           ),
           "ES" => array
           (
              "Key" => "ES",
              "Name" => "ES",
              "Title" => "Espanhol",
              "Title_UK" => "Spanish",
              "Title_UK" => "Castilhano",
              "Icon" => "es.png",
           ),
        );

        $language=$this->MyLanguage_Detect();;
        $this->ApplicationObj()->Language=$language;
        $this->MakeCGI_Cookie_Set("Lang",$this->ApplicationObj()->Language);

        $this->ApplicationObj()->LanguageKey=
            $this->ApplicationObj()->Languages[ $this->ApplicationObj()->Language ][ "Key" ];

        $this->ApplicationObj()->LanguageKeys=
            $this->MyHash_HashesList_Values
            (
               $this->ApplicationObj()->Languages,
               "Key"
             );

        foreach (array_keys($this->ApplicationObj()->LanguageKeys) as $id)
        {
            if (!empty($this->ApplicationObj()->LanguageKeys[ $id ]))
            {
                $this->ApplicationObj()->LanguageKeys[ $id ]=
                    "_".
                    $this->ApplicationObj()->LanguageKeys[ $id ];
            }
        }

        if (!empty($key)) { $key="_".$key; }
    }

    //*
    //* function LanguageKey, Parameter list: 
    //*
    //* LanguageKey accessor.
    //*

    function LanguageKey()
    {
        return $this->ApplicationObj()->LanguageKey;
    }

    //*
    //* function LanguageKeys, Parameter list: 
    //*
    //* LanguageKeys accessor.
    //*

    function LanguageKeys()
    {
        return $this->ApplicationObj()->LanguageKeys;
    }

    
    //*
    //* function MyLanguage_Detect, Parameter list: 
    //*
    //* Detects language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_Detect()
    {
        $language=$this->CGI_GETOrCOOKIE("Lang");
        if (empty($language)) { $language=$this->ApplicationObj()->Language; }

        if (!empty($language)) { $this->MyLanguage_Set($language); }
        
        return $language;
    }

    //*
    //* function MyLanguage_Get , Parameter list: 
    //*
    //* Returns current langua as in  $this->ApplicationObj->Language.
    //*

    function MyLanguage_Get()
    {
        return $this->ApplicationObj->Language;
    }

    //*
    //* function MyLanguage_Keys, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_Keys()
    {
        return array_keys($this->ApplicationObj->Languages);
    }

    //*
    //* function Language, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_Set($language)
    {
        $this->ApplicationObj->Language=$language;
    }

    //*
    //* function MyLanguage_Key2Lang, Parameter list: 
    //*
    //* Returns language key, ie empty or _.$language.
    //*

    function MyLanguage_Key2Lang($language="")
    {
        if (empty($language)) { $language=$this->ApplicationObj()->Language; }
        
        $language=preg_replace('/^_/',"",$language);

        return $language;
    }
    
    //*
    //* function MyLanguage_GetLanguageKey, Parameter list: 
    //*
    //* Returns language key, ie empty or _.$language.
    //*

    function MyLanguage_GetLanguageKey($language="")
    {
        if (empty($language)) { $language=$this->ApplicationObj()->Language; }
        
        if (empty($this->ApplicationObj()->Languages[ $language ])) { return ""; }
        
        $key=$this->ApplicationObj()->Languages[ $language ][ "Key" ];

        if (!empty($key)) { $key="_".$key; }

        return $key;
    }

    //*
    //* function , Parameter list: 
    //*
    //* Returns languaged $key name.
    //*

    function MyLanguage_GetLanguagedKey($key,$language="")
    {
        return $key.$this->MyLanguage_GetLanguageKey($language);
    }

    //*
    //* function MyLanguage_HashTakeNameKeys, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_HashTakeNameKeys(&$hash,$keys=array())
    {
        if (empty($keys)) { $keys=array("Name","PName","ShortName","Title","Values"); }

        $lkey=$this->MyLanguage_GetLanguageKey();
        if (!empty($lkey))
        {
            foreach (array_keys($hash) as $data)
            {
                foreach ($keys as $key)
                {
                    $rkey=$key.$lkey;
                    if (!empty($hash[ $data ][ $rkey ]))
                    {
                         $hash[ $data ][ $key ]=$hash[ $data ][ $rkey ];                        
                    }                    
                }
            }
        }
    }


    //*
    //* function MyLanguage_HashTakeItemNames, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_HashTakeItemNames(&$hash,$keys=array())
    { 
        if (empty($keys)) { $keys=array("Name","PName","ShortName","Title"); }

        foreach (array_keys($hash) as $data)
        {
            $this->MyLanguage_HashEntryTakeItemNames($data,$hash[ $data ],$keys);
        }
    }



    //*
    //* function MyLanguage_HashEntryTakeItemNames, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_HashEntryTakeItemNames($data,&$hash,$keys)
    {
        foreach ($keys as $key)
        {
            if (isset($hash[ $key ]))
            {
                $this->MyLanguage_HashEntryKeyTakeItemNames($key,$hash[ $key ]);
            }
        }
    }


    //*
    //* function MyLanguage_HashEntryKeyTakeItemNames, Parameter list: 
    //*
    //* Returns language from CGI (GET or COOKIE) and sets language cookie.
    //*

    function MyLanguage_HashEntryKeyTakeItemNames($key,&$value)
    {
        if (!empty($value))
        {
            foreach (array("ItemsName","ItemName") as $type)
            {
                foreach (array("_UK","") as $langkey)
                {
                    $acc=$type.$langkey;
                    if (isset($this->$acc))
                    {
                        $rvalue=$this->$acc;

                        $value=preg_replace
                        (
                           '/#'.$acc.'/',
                           $rvalue,
                           $value
                        );
                    }
                }
            }
        }
    }
    
    //*
    //* function MyLanguage_ItemData_Get, Parameter list: 
    //*
    //* Reads $file as php array, foreach entry (data) read, adds
    //* language specific keys, heriting name, title, shortname and default settings.
    //*

    function MyLanguage_ItemData_Get($file)
    {
        $itemdata=array();
        
        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $itemdata[ $lang ]=array();
        }
        
        foreach ($this->ReadPHPArray($file) as $data => $def)
        {
            foreach ($this->MyLanguage_Keys() as $lang)
            {
                $langkey=$this->MyLanguage_GetLanguageKey($lang);
                
                $itemdata[ $lang ][ $data.$langkey ]=$def;
                foreach (array("Name","Title","ShortName","Default") as $key)
                {
                    $itemdata[ $lang ][ $data.$langkey ][ $key ]=$def[ $key ];
                    if (!empty($def[ $key.$langkey ]))
                    {
                        $itemdata[ $lang ][ $data.$langkey ][ $key ]=$def[ $key.$langkey ];
                    }
               }
            }
        }

        return $itemdata;
    }
    
    //*
    //* function MyLanguage_ItemData_Groups_Get, Parameter list: $itemdata,$file
    //*
    //* Reads $file as php array groups defs hash. Adds languaged groups.
    //* Should probably only be one group. One group for each language created.
    //*

    function MyLanguage_ItemData_Groups_Get($itemdata,$file)
    {
        $itemgroups=array();
        foreach ($this->ReadPHPArray($file) as $group => $def)
        {
            foreach (array_keys($itemdata) as $lang)
            {
                $langkey=$this->MyLanguage_GetLanguageKey($lang);
                $datas=array_keys($itemdata[ $lang ]);
                
                $itemgroups[ $group.$langkey ]=$def;
                if (empty($def[ "Data".$langkey ]))
                {
                    $def[ "Data".$langkey ]=$def[ "Data" ];
                }
                
                $itemgroups[ $group.$langkey ][ "Data" ]=array_merge($def[ "Data".$langkey ],$datas);
                
                $itemgroups[ $group.$langkey ][ "Language" ]=$lang;
                $itemgroups[ $group.$langkey ][ "Language_Key" ]=$langkey;
                
                foreach (array("Name","Title") as $key)
                {
                    $value=$def[ $key ];
                    if (!empty($def[ $key.$langkey ])) { $value=$def[ $key.$langkey ]; }
                    
                    $itemgroups[ $group.$langkey ][ $key ]=$value; //$def[ $key.$langkey ];
                }
            }
        }

        return $itemgroups;
    }
    

}
?>