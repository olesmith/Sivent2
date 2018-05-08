<?php

trait MyApp_Handle_Help
{    
    //*
    //* function MyApp_Handle_Help, Parameter list:
    //*
    //* Returns True if help is enabled.
    //*

    function MyApp_Handle_Help_Has()
    {
        return True;
    }
    
    //*
    //* function MyApp_Handle_Help, Parameter list:
    //*
    //* Creates Help Screen
    //*

    function MyApp_Handle_Help()
    {
        $this->MyApp_Interface_Head();
        
        echo
            $this->H(1,"Tópicos de Ajuda").
            $this->MyApp_Handle_Help_Show();
    }

    //*
    //* function MyApp_Handle_Help_Profile_Paths, Parameter list: 
    //*
    //* List of paths to help files, according to profile.
    //*

    function MyApp_Handle_Help_Profile_Paths()
    {
        $basepath="System/Help";

        $paths=
            array
            (
                $basepath,
                join("/",$basepath,$this->Profile()),
            );

        $rpaths=array();
        foreach ($paths as $path)
        {
            if (is_dir($path))
            {
                array_push($rpaths,path);
            }
        }

        return $rpaths;
    }

    //*
    //* function MyApp_Handle_Help_Show, Parameter list: 
    //*
    //* Displays application help. browsing System/Help subtree.
    //*

    function MyApp_Handle_Help_Show()
    {
        $paths=$this->MyApp_Handle_Help_Profile_Paths();

        var_dump($paths);

        return "";
    }

}

?>