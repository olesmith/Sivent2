<?php

include_once("Tables/Events.php");

class MyEventsTables extends MyEventsTablesEvents
{
    //*
    //* function EventsTable, Parameter list: $candname=FALSE
    //*
    //* Generates events table matrix.
    //*

    function EventsTable($candname=FALSE)
    {
        return 
            $this->ItemsTableDataGroup
            (
               "",
               0,
               $this->ApplicationObj()->EventGroup,
               $this->ApplicationObj()->Events
            );
    }

    //*
    //* function EventsHtmlTable, Parameter list:
    //*
    //* Generates events table matrix.
    //*

    function EventsHtmlTable()
    {
        return 
            $this->Html_Table
            (
                "",
                $this->EventsTable()
            );
    }
    
    //*
    //* function ShowEvents, Parameter list:
    //*
    //* Generates events table matrix.
    //*

    function ReadEvents()
    {
        $this->ApplicationObj()->Events=$this->Sql_Select_Hashes(array(),array(),array("StartDate","ID"));
        $this->ApplicationObj()->Events=array_reverse($this->ApplicationObj()->Events);
    }
    
    //*
    //* function ShowEvents, Parameter list:
    //*
    //* Generates events table matrix.
    //*

    function ShowEvents()
    {
        $this->ReadEvents();
        echo
            $this->H(1,$this->MyLanguage_GetMessage("Events_Table_Title")).
            $this->EventsHtmlTable(),
            "";
    }
}

?>