<?php

include_once("Register/Schedule.php");
include_once("Register/Schedules.php");
include_once("Register/Search.php");
include_once("Register/Registers.php");

class Presences_Register extends Presences_Register_Registers
{
    //*
    //* function Presences_Schedule_Transfer_Data, Parameter list:
    //*
    //* Datas to transfer and update from Schedule ID.
    //*

    function Presences_Schedule_Transfer_Data()
    {
        array(); //("Date","Time","Place","Room","Submission");
    }
    
    //*
    //* function Presences_Schedule_Data, Parameter list:
    //*
    //* Returns schedule data to show,
    //*

    function Presences_Schedule_Data()
    {
        return array("Submission");
    }
    
    //*
    //* function Presences_Schedules_Data, Parameter list:
    //*
    //* Returns schedules data to show,
    //*

    function Presences_Schedules_Data()
    {
        return array("Date","Time","Place","Room");
    }
    
    //*
    //* function Presences_Inscriptions_Search_Data, Parameter list:
    //*
    //* Returns Inscriptions search form Search data.
    //*

    function Presences_Inscriptions_Search_Data()
    {
        return array("Name","Email","Code");
    }
    
    //*
    //* function Presences_Inscriptions_Read_Data, Parameter list:
    //*
    //* Returns Inscriptions search form Search Read data.
    //*

    function Presences_Inscriptions_Read_Data()
    {
        return array("ID","Friend","Name","Email","Code");
    }
    
    //*
    //* function Presences_Inscriptions_Show_Data, Parameter list:
    //*
    //* Returns Inscriptions search form Show data.
    //*

    function Presences_Inscriptions_Show_Data()
    {
        return array("Name","Email","Code");
    }

    
    //*
    //* function Presences_Friends_Data, Parameter list:
    //*
    //* Returns schedules data to show,
    //*

    function Presences_Friends_Data()
    {
        return array("No","Name","Email");
    }
    
    //*
    //* function Presences_Friends_Data, Parameter list:
    //*
    //* Returns schedules data to show,
    //*

    function Presences_Friend_Schedule_Data()
    {
        return array("Date","Time");
    }
    
    //*
    //* function Presences_Schedule_Register_Print_Link, Parameter list: $item=array()
    //*
    //* Creates link to printable version.
    //*

    function Presences_Schedule_Register_Print_Link()
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Latex" ]=1;

        return
            $this->BR().
            $this->Center
            (
                $this->Href
                (
                   "?".$this->CGI_Hash2URI($args),
                   $this->MyLanguage_GetMessage("Printable_Version")
                )
            ).
            $this->BR().
            "";
    }
    
    //*
    //* function Presences_Schedule_Register, Parameter list: $item=array()
    //*
    //* Handles registrations for schedule.
    //*

    function Presences_Schedule_Register()
    {
        $this->InscriptionsObj()->ItemData("ID");
        $this->SchedulesObj()->ItemData("ID");
        
        if ($this->CGI_GETOrPOSTint("Latex")==1)
        {
            $this->ApplicationObj()->LatexMode=TRUE;
        }

        $schedule=$this->Presences_Register_Schedule_Read();
        
        $schedules=$this->Presences_Register_Schedules_Read($schedule);
       
        if (!$this->ApplicationObj()->LatexMode)
        {
            echo $this->FrameIt
            (
                $this->Presences_Register_Schedule_Show().
                $this->Presences_Register_Schedules_Show($schedule).
                $this->Presences_Schedule_Register_Print_Link().
                $this->Presences_Register_Search($schedule).
                $this->Presences_Schedule_Registers_Show($schedule,$schedules).
                ""
            );
        }
        else
        {
            $latex=
                $this->GetLatexSkel("Head.tex").

                $this->Presences_Register_Schedules_Show($schedule).
                $this->Presences_Schedule_Registers_Show($schedule,$schedules).
                $this->GetLatexSkel("Tail.tex").
                "";

            

            //$this->ShowLatexCode($latex);

            $this->RunLatexPrint
            (
               "Presences.".
               $schedule[ "Submission" ].".".
               //$this->Text2Sort($texfile).".".
               $this->MTime2FName().
               ".tex",
               $latex
             );
        }
    }
}

?>