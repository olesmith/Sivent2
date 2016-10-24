<?php


trait MyApp_Messages_Edit_Keys
{
    //*
    //* function MyApp_Messages_Edit_Hash_Key_Rows, Parameter list: $edit,$path,$file,$hashkey,$hash,$key
    //*
    //* Handles message $hash editing. Generates rows and updates $hash.
    //*

    function MyApp_Messages_Edit_Hash_Key_Rows($edit,$path,$file,$hashkey,$hash,$key)
    {
        $table=array();
        foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
        {
           $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Messages_Edit_Hash_Key_Lang_Rows($edit,$path,$file,$hashkey,$hash,$key,$lkey)
                );
        }
        $key.=":";
        for ($n=0;$n<count($table);$n++)
        {
            array_unshift($table[ $n ],$key);
            $key="";
        }

        array_push($table,array("<HR>"));
        
        return $table;
    }

    //*
    //* function MyApp_Messages_Edit_Key_Update, Parameter list: $hashkey,&$hash,$key
    //*
    //* Updates $hash $key, for all languages
    //*

    function MyApp_Messages_Edit_Key_Update($defaultkey,$hashkey,&$hash,$key)
    {
        $updateds=0;
        foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
        {
            $updateds+=$this->MyApp_Messages_Edit_Key_Language_Update($hashkey,$hash,$key,$lkey);            
            if ($defaultkey!=$key)
            {
                foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
                {
                    if (empty($hash[ $key.$lkey ]))
                    {
                        if (!empty($hash[ $defaultkey.$lkey ]))
                        {
                            $hash[ $key.$lkey ]=$hash[ $defaultkey.$lkey ];
                            $updateds++;
                        }
                        elseif (!empty($hash[ $defaultkey ]))
                        {
                             $hash[ $key.$lkey ]=$hash[ $defaultkey ];
                             $updateds++;
                        }
                    }
                }
            }
            else
            {
                foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
                {
                    if (empty($hash[ $key.$lkey ]))
                    {
                        $hash[ $key.$lkey ]=$hash[ $key ];
                        $updateds++;
                    }
                }
            }
        }
        
        return $updateds;
     }
}

?>