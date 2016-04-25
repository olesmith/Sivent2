<?php

trait MyApp_Messages
{
    //*
    //* function MyApp_Messages_Init, Parameter list: 
    //*
    //* Reads application messaage files.
    //*

    function MyApp_Messages_Init()
    {
        $this->MyLanguage_Init();
        $this->MyLanguage_Messages_Files_Add($this->MessageFiles);
        $this->MyApp_Messages_ReadFiles();
    }

    //*
    //* function MyApp_Messages_ReadFiles, Parameter list: $paths=array()
    //*
    //* Initiatilizes application language subsystem.
    //*

    function MyApp_Messages_ReadFiles($paths=array())
    {
        if (empty($paths))
        {
            $paths=$this->MessageDirs;
        }

       foreach ($paths as $path)
        {
            $rpath=NULL;
            if (file_exists($path."/Messages"))
            {
                $rpath=$path."/Messages";
            }
            elseif (file_exists($path))
            {
                $rpath=$path;
            }

            if ($rpath)
            {
                $files=$this->Dir_Files($rpath,'\.php$');
                $this->MyLanguage_Messages_Files_Add($files);
            }
            else
            {
                //Should send some warning messages
            }
        }
    }
}

?>