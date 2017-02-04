<?php


trait MyApp_Setup_Read
{
    //*
    //* function MyApp_Setup_FileName, Parameter list: $file
    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_FileName($file)
    {
        return $this->MyApp_Setup_Path()."/".$file;
    }

    //*
    //* function MyApp_Setup_LoadFile, Parameter list: $file,$destination
    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_LoadFile($file,$destination)
    {
        $this->$destination=$this->ReadPHPArray
        (
           $this->MyApp_Setup_FileName($file)
        );
    }

    //*
    //* function MyApp_Setup_Globals_File, Parameter list: 
    //*
    //* Returns App global data file name.
    //*

    function MyApp_Setup_Globals_File()
    {
        return $this->MyApp_Setup_FileName("Globals.php");
    }

    //*
    //* function MyApp_Setup_Globals_Read, Parameter list: 
    //*
    //* Returns App global data file name.
    //*

    function MyApp_Setup_Globals_Read()
    {
        return $this->ReadPHPArray
        (
           $this->MyApp_Setup_Globals_File()
        );
    }

    //*
    //* function MyApp_Setup_Globals_Load, Parameter list: 
    //*
    //* Returns App global data file name.
    //*

    function MyApp_Setup_Globals_Load()
    {
        $hash=$this->MyApp_Setup_Globals_Read();
        $this->MyHash_Args2Object($hash);
    }

    
    //*
    //* function MyApp_Setup_Read, Parameter list: 
    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_Read()
    {
        $this->MyApp_Setup_Globals_Load();

        $this->MyApp_Setup_LoadFile("Html.php","HtmlSetupHash");
        $this->MyApp_Setup_LoadFile("Company.php","CompanyHash");
    }
}

?>