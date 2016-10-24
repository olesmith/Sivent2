<?php

trait MyApp_Messages_Files
{
    //*
    //* function MyApp_Messages_Dir_Files_Get, Parameter list: $path
    //*
    //* Detects the list of message files in $path.
    //*

    function MyApp_Messages_Dir_Files_Get(&$path)
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

        $files=array();
        if ($rpath)
        {
            $files=$this->Dir_Files($rpath,'\.php$');
        }

        $path=$rpath;

        return $files;
    }
    
    //*
    //* function MyApp_Messages_Files_Get, Parameter list: $paths=array()
    //*
    //* Detects the lisat of message files.
    //*

    function MyApp_Messages_Files_Get($paths=array())
    {
        if (empty($paths)) { $paths=$this->MessageDirs; }

        $files=array();
        foreach ($paths as $path)
        {
            $files=
                array_merge
                (
                   $files,
                   $this->MyApp_Messages_Dir_Files_Get($path)
                );
        }

        return $files;
    }
    //*
    //* function MyApp_Messages_Files_Read, Parameter list: $paths=array()
    //*
    //* Initiatilizes application language subsystem.
    //*

    function MyApp_Messages_Files_Read($paths=array())
    {
        $this->MyLanguage_Messages_Files_Add
        (
           $this->MyApp_Messages_Files_Get($paths)
        );
    }
}

?>