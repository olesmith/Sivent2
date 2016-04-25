<?php

include_once("Setup/Profiles.php");
include_once("Setup/ConfigFiles.php");
include_once("Setup/Defs.php");
include_once("Setup/Data.php");
include_once("Setup/Read.php");

trait MyApp_Setup
{
    use MyApp_Setup_Profiles,
        MyApp_Setup_ConfigFiles,
        MyApp_Setup_Defs,
        MyApp_Setup_Data,
        MyApp_Setup_Read;



    //*
    //* function MyApp_Setup_Path, Parameter list:
    //*
    //* Returns SetupDataPath.
    //*

    function MyApp_Setup_Path()
    {
        return $this->SetupPath;
    }


    //*
    //* function MyApp_Setup_ParseFileName, Parameter list: $file,$module=""
    //*
    //* Substitutes $this->ModuleName for #ModuleName and
    //* $this->SetupPath for #Setup in $file.
    //*

    function MyApp_Setup_ParseFileName($file,$module="")
    {
        if (empty($module)) { $module=$this->ModuleName; }

        return preg_replace
        (
           '/#Module/',
           $module,
           preg_replace
           (
              '/#Setup/',
              $this->SetupPath,
              $file
           )
        );
    }

     //*
    //* function MyApp_Setup_Files2Hash, Parameter list: $paths,$files
    //*
    //* Substitutes $this->ModuleName for #ModuleName and
    //* $this->SetupPath for #Setup in $file.
    //*

    function MyApp_Setup_Files2Hash($paths,$files)
    {
        if (!is_array($paths)) { $paths=array($paths); }
        if (!is_array($files)) { $files=array($files); }

        $files=$this->ExistentPathsFiles($paths,$files);

        $hash=array();
        foreach ($files as $file)
        {
            $hash=$this->ReadPHPArray($file,$hash);
        }

        return $hash;
    }

    //*
    //* function MyApp_Setup_Hash2Object, Parameter list: $file,$module=""
    //*
    //* Set object ($this) values given setup hash
    //*

    function MyApp_Setup_Hash2Object($fid,$hash,$moduleobj=NULL,$tothis=TRUE)
    {
        $filedef=$this->SetupFileDefs[ $fid ];
        if ($filedef[ "Destination" ]!="")
        {
            $dest=$filedef[ "Destination" ];
            if ($tothis) { $this->$dest=$hash; }
            if ($moduleobj)
            {
                $moduleobj->$dest=$hash;
            }
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                if ($tothis) { $this->$key=$value; }
                if ($moduleobj)
                {
                    $moduleobj->$key=$value;
                }
            }
        }
    }
    

    //*
    //* Gather setup hash from actual object $this
    //*

    function MyApp_Setup_Object2Hash($fid)
    {
        $filedef=$this->SetupFileDefs[ $fid ];
        $dest=$this->SetupFileDefs[ $fid ][ "Destination" ];

        $ohash=array();

        if ($dest!="" && is_array($this->$dest))
        {
            $ohash=$this->$dest;
        }

        $hash=array();
        foreach ($this->SetupFileDefs[ $fid ][ "Keys" ] as $id => $key)
        {
            if ($dest!="")
            {
                $dest=$filedef[ "Destination" ];
                $hash[ $key ]=$ohash[ $key ];
            }
            else
            {
                $hash[ $key ]=$this->$key;
            }
        }

        return $hash;
    }


}


?>