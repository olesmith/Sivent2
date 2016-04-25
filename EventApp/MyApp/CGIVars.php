<?php

class MyEventAppCGIVars extends Application
{
    //*
    //* function ReadUnitOpenEvents, Parameter list:
    //*
    //* SiPOS CGI vars setup.
    //* 
    //*

    function ReadUnitOpenEvents()
    {
        $this->EventsObj()->Sql_Table_Structure_Update();
        $this->EventsObj()->ReadOpenEvents();
    }

    

    
    //*
    //* function SAdE_CGIVars_Unit, Parameter list:
    //*
    //* EventApp CGI vars Unit setup.
    //* 
    //*

    function EventApp_CGIVars_Unit()
    {
        return array
        (
           //Read Event
           "Event" => array
           (
               "GlobalKey" => "Event",
               "Compulsory" => FALSE,
               "CompulsoryAdmin" => FALSE,

               "SqlObject" => "EventsObj",
               "InitSqlTable" => FALSE,

               /* "PostMethod" => "School2CompanyHash", */
               /* "PostReads" => array */
               /* ( */
               /*    "Periods" => array */
               /*    ( */
               /*       "ReadMethod" => "ReadUnitSchoolPeriods", */

               /*       "SqlObject" => "PeriodsObj", */
               /*       "InitSqlTable" => TRUE, */
               /*    ), */
               /*  ), */

               "From" => array
               (
                  "GET" => "Event",
                  "POST" => "Event",
                  "COOKIE" => "Event",
                  "Login" => "",
                  "Default" => "",
               ),

               /* "CGIVars" => $this->SAdE_CGIVars_Period(), */
            ),
         );
    }
}
?>