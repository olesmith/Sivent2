<?php

trait MyApp_Logging
{
    //*
    //* function MyApp_Logging_Init, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Logging_Init()
    {
        if ($this->Logging)
        {
           $this->MyMod_SubModule_Load("Logs",TRUE,TRUE);
           $this->LogsObject()->LogEntry($this->AppName);
        }

    }

}

?>