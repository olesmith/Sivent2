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
                        $this->MyLanguage_Key2Lang($lang).
                        ")";
                }
            }
        }
    }
    
}

?>