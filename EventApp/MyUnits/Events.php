<?php


class MyUnitsEvents extends MyUnitsMailsTypes
{
    //*
    //* function Event_IDs_Get, Parameter list: 
    //*
    //* Returns Event IDs for current Unit.
    //*

    function Event_IDs_Get()
    {
        return $this->EventsObj()->Sql_Select_Unique_Col_Values("ID",array("Unit" => $this->Unit("ID")));
    }
}

?>