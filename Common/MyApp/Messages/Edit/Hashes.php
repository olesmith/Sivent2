<?php


trait MyApp_Messages_Edit_Hashes
{
    
    //*
    //* function MyApp_Messages_Edit_Keys, Parameter list: 
    //*
    //* List of potential keys to edit/show/update in $hash.
    //*

    function MyApp_Messages_Edit_Keys()
    {
        return array("Name","Title");
    }

    
    //*
    //* function MyApp_Messages_Edit_Hash, Parameter list: $edit,$path,$file,$hashkey,&$hash,$keys=array()
    //*
    //* Handles message $hash editing. Generates rows and updates $hash.
    //*

    function MyApp_Messages_Edit_Hash($edit,$path,$file,$hashkey,&$hash,$keys=array())
    {
        if (empty($keys)) $keys=$this->MyApp_Messages_Edit_Keys();

        //var_dump($keys);
        
        $table=array();
        foreach ($keys as $key)
        {
           $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Messages_Edit_Hash_Key_Rows($edit,$path,$file,$hashkey,$hash,$key)
                );
        }

        for ($n=0;$n<count($table);$n++)
        {
            array_unshift($table[ $n ],$hashkey);
            $hashkey="";
        }
        
        return $table;
    }

    //*
    //* function MyApp_Messages_Edit_Hashes_Update, Parameter list: &$hashes,$keys=array()
    //*
    //* Rows for active message $file editing.
    //*

    function MyApp_Messages_Edit_Hashes_Update($file,&$hashes,$keys=array())
    {
        if (empty($keys)) $keys=$this->MyApp_Messages_Edit_Keys();
        
        $updateds=0;
        foreach (array_keys($hashes) as $hashkey)
        {
            $updateds+=$this->MyApp_Messages_Edit_Hash_Update($hashkey,$hashes[ $hashkey ],$keys);
        }

        if ($updateds>0)
        {
            $text="";

            if (empty($this->Files_Incomplete[ $file ]))
            {
                $text.="array\n(\n";
            }
            
            foreach ($hashes as $messsage => $hash)
            {
                $text.=
                    "   \"".$messsage."\" => array\n".
                    "   (\n";

                $keys=array_keys($hash);
                sort($keys);
                foreach ($keys as $key)
                {
                    $value=$hash[ $key ];
                    if (!is_array($value))
                    {
                        $text.=
                            "   ".
                            "   ".
                            "\"".$key."\" => \"".$value."\",\n".
                            "";
                    }
                    else
                    {
                        $text.=
                            "   ".
                            "   ".
                            "\"".$key."\" => array(\"".join("\",\"",$value)."\"),\n".
                            "";
                    }
                 }
                
                $text.=
                    "   ),\n";
            }
            
            if (empty($this->Files_Incomplete[ $file ]))
            {
                $text.=");\n";
            }
            

            $savfile=$file.".sav";
            if (!file_exists($savfile))
            {
                system("cp ".$file." ".$savfile);
            }
            $this->MyFile_Write($file,$text);
            
            var_dump($updateds." changes written to file ".$file);

            echo
                preg_replace
                (
                   '/\s/',
                   "&nbsp;&nbsp;",
                   preg_replace('/\n/',"<BR>",$text)
                );
        }

        return $updateds;
    }
    
    //*
    //* function MyApp_Messages_Edit_Hash_Update, Parameter list: $hashkey,&$hash,$keys=array()
    //*
    //* Rows for active message $file editing.
    //*

    function MyApp_Messages_Edit_Hash_Update($hashkey,&$hash,$keys=array())
    {
        if (empty($keys)) $keys=$this->MyApp_Messages_Edit_Keys();

        $defaultkey=$keys[0];
        $updateds=0;
        foreach ($keys as $key)
        {            
            $updateds+=$this->MyApp_Messages_Edit_Key_Update($defaultkey,$hashkey,$hash,$key);
        }

        return $updateds;
    }
}

?>