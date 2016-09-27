<?php

include_once("Messages/Files.php");
include_once("Messages/Edit.php");

trait MyApp_Messages
{
    use
        MyApp_Messages_Files,
        MyApp_Messages_Edit;

    
    //*
    //* function MyApp_Messages_Init, Parameter list: 
    //*
    //* Reads application messaage files.
    //*

    function MyApp_Messages_Init()
    {
        $this->MyLanguage_Init();
        $this->MyLanguage_Messages_Files_Add($this->MessageFiles);
        $this->MyApp_Messages_Files_Read();
    }
}

?>