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
    //* function MyApp_Setup_Read, Parameter list: 
    //*
    //* Returns App global data.
    //*

    function MyApp_Setup_Read()
    {
        $hash=$this->ReadPHPArray
        (
           $this->MyApp_Setup_FileName("Globals.php")
        );

        $this->MyHash_Args2Object($hash);
        $this->MyApp_Setup_LoadFile("Html.php","HtmlSetupHash");
        $this->MyApp_Setup_LoadFile("Company.php","CompanyHash");
    }
}

?>