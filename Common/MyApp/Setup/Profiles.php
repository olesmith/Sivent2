<?php

//include_once("Handle/Start.php");

trait MyApp_Setup_Profiles
{
    //*
    //* function MyApp_Setup_Profiles_File, Parameter list: 
    //*
    //* Returns name of Profile file for Application.
    //*

    function MyApp_Setup_Profiles_File()
    {
        return 
            $this->MyApp_Setup_Path().
            "/".
            $this->ProfilesFile;
    }


}

?>