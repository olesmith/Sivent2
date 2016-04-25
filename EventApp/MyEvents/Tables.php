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
}

?>