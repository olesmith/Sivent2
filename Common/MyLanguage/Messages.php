<?php

trait MyLanguage_Messages
{
    //*
    //* function MyLanguage_Messages_Files_Add, Parameter list: $files
    //*
    //* Adds message $files to $this->Messages;
    //*

    function MyLanguage_Messages_Files_Add($files)
    {
        foreach ($files as $file)
        {
            $this->MyLanguage_Messages_File_Add($file);   
        }
    }

    //*
    //* function MyLanguage_Messages_File_Add, Parameter list: $file
    //*
    //* Adds message $file to $this->Messages;
    //*

    function MyLanguage_Messages_File_Add($file)
    {
        if (empty($this->ApplicationObj()->MessagesFiles[ $file ]))
        {
            $this->ApplicationObj()->MessagesFiles[ $file ]=$file;

            foreach ($this->ReadPHPArray($file) as $key => $value)
            {
                $this->ApplicationObj()->Messages[ $key ]=$value;
            }
        }

        return $file;
    }


    //*
    //* function MyLanguage_GetMessage, Parameter list: $file,$key,$subkey="Name"
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

    function MyLanguage_GetMessage($key,$subkey="Name",$rkey="")
    {
        $langkey=$this->ApplicationObj()->MyLanguage_GetLanguageKey();

        if (!empty($this->ApplicationObj()->Messages[ $key ]))
        {
            if (
                  !empty($rkey)
                  &&
                  isset($this->ApplicationObj()->Messages[ $key ][ $rkey ][ $subkey.$langkey ])
               )
            {
                return $this->ApplicationObj()->Messages[ $key ][ $rkey ][ $subkey.$langkey ];
            }
            elseif (
                      isset($this->ApplicationObj()->Messages[ $key ][ $subkey.$langkey ])
                   )
            {
                return $this->ApplicationObj()->Messages[ $key ][ $subkey.$langkey ];
            }
            elseif (
                      isset($this->ApplicationObj()->Messages[ $key ][ $subkey ])
                   )
            {
                return $this->ApplicationObj()->Messages[ $key ][ $subkey ];
            }
        }

        //Still here, warn!
        $this->Warn("Unable to retrieve system message",$key,$subkey,$langkey,$rkey);
    }
}
?>