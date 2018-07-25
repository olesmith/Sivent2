<?php


trait MyMod_Data_Language
{
    var $MyMod_Language_Data=array();
    
    //*
    //* Initializes languaged data. That makes sure all named keys are defined.
    //*

    function MyMod_Language_Datas_Init()
    {
        foreach ($this->MyMod_Language_Data as $data)
        {
            $this->MyMod_Language_Data_Init($data);
        }
    }
    
    //*
    //* Initializes languaged data. That makes sure all named keys are defined.
    //*

    function MyMod_Language_Data_Init($data)
    {
        foreach ($this->LanguageKeys() as $lang)
        {
            if (empty($lang)) { continue; }

            $this->MyMod_Language_Data_Language_Init($data,$lang);
        }
    }
    
   //*
    //* Initializes languaged data. That makes sure all named keys are defined.
    //*

    function MyMod_Language_Data_Language_Init($data,$lang)
    {
        if (empty($lang)) { return; }
                
        if (empty($this->ItemData[ $data.$lang ]))
        {
            $this->ItemData[ $data.$lang ]=$this->ItemData[ $data ];
        }
        $this->ItemData[ $data.$lang ][ "Compulsory" ]=FALSE;
        
        foreach (array("Name","Title","ShortName","PName") as $key)
        {
            foreach ($this->LanguageKeys() as $llang)
            {
                if (!empty($this->ItemData[ $data ][ $key.$llang ]))
                {
                    $this->ItemData[ $data.$lang ][ $key.$llang ].=
                        " (".
                        $this->MyLanguage_Key2Lang($llang).
                        ")";
                }
            }
        }
    }
    
    //*
    //* For data indicated as 'langauged', adds entries for all languagekeys.
    //*

    function MyMod_Languaged_Data_Get($data)
    {
        $langdatas=array();
        if (!empty($this->ItemData[ $data ][ "Languaged" ]))
        {
            foreach ($this->LanguageKeys() as $lang)
            {
                if (!empty($lang))
                {
                    array_push($langdatas,$data.$lang);
                }
            }
        }

        return $langdatas;
    }
    
    //*
    //* Item data that are perceived as Name keys.
    //*

    function MyMod_Languaged_Datas_Keys()
    {
        return array("Name","Title","ShortName");
    }

    
    //*
    //* For data indicated as 'langauged', adds entries for all languagekeys.
    //*

    function MyMod_Languaged_Datas_Add()
    {
        foreach (array_keys($this->ItemData) as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Languaged" ]))
            {
                $this->MyMod_Languaged_Data_Add($data);
            }
        }
    }
    
    //*
    //* Add Language $data.
    //*

    function MyMod_Languaged_Data_Add($data)
    {
        foreach ($this->MyMod_Languaged_Data_Get($data) as $langdata)
        {
            $this->MyMod_Languaged_Data_Language_Add($data,$langdata);
        }
    }

    
    //*
    //* Add $langdata.
    //*

    function MyMod_Languaged_Data_Language_Add($data,$langdata)
    {
        $lang=preg_split('/_/',$langdata);
        $lang=array_pop($lang);

        $langkeys=$this->LanguageKeys();
                    
        if (!empty($this->ItemData[ $langdata ])) { return; }
        
        $this->ItemData[ $langdata ]=$this->ItemData[ $data ];
        unset($this->ItemData[ $langdata ][ "Search" ]);
        unset($this->ItemData[ $langdata ][ "Languaged" ]);
        foreach ($this->MyMod_Languaged_Datas_Keys() as $key)
        {
            $this->MyMod_Languaged_Data_Language_Key_Add($data,$langdata,$key,$lang);
            $this->ItemData[ $langdata ][ "AddedBy" ]="Languaged";
        }
        
        #Add language for default language key, $data
        $lang=$this->MyLanguage_Name();
        foreach ($this->MyMod_Languaged_Datas_Keys() as $key)
        {
            $this->MyMod_Languaged_Data_Language_Key_Add($data,$data,$key,$lang);
        }
    }
    
    //*
    //* Add $langdata.
    //*

    function MyMod_Languaged_Data_Language_Key_Add($data,$langdata,$key,$lang)
    {
        foreach ($this->LanguageKeys() as $langkey)
        {
            if (!empty($this->ItemData[ $data ][ $key.$langkey ]))
            {
                $this->ItemData[ $langdata ][ $key.$langkey ]=
                    preg_replace
                    (
                        '/\s*\(\S\S\)\s*/',
                        "",
                        $this->ItemData[ $data ][ $key.$langkey ]
                    ).
                    " (".$lang.")";
            }
        }
    }
}

?>