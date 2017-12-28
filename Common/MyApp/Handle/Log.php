<?php

trait MyApp_Handle_Log
{
    //*
    //* function MyApp_Handle_Log, Parameter list:
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_Log()
    {
        $this->MyApp_Interface_Head();        
        $this->LogsTable();
    }

}

?>