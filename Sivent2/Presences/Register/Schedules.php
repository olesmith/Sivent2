<?php

class Presences_Register_Schedules extends Presences_Register_Schedule
{
    //*
    //* function Presences_Register_Schedules_Read, Parameter list: $schedule
    //*
    //* Reads schedules associated with $schedule[ "Submission" ].
    //*

    function Presences_Register_Schedules_Read($schedule)
    {
        $where=$this->UnitEventWhere(array("Submission" => $schedule[ "Submission" ]));
        
        return $this->SchedulesObj()->Sql_Select_Hashes($where);
    }
    
    //*
    //* function Presences_Register_Schedules_Titles, Parameter list: $schedule
    //*
    //* Reads schedules titles row.
    //*

    function Presences_Register_Schedules_Titles()
    {
        $schedulestitles=$this->SchedulesObj()->GetDataTitles($this->Presences_Schedules_Data());
        array_push($schedulestitles,"");
        
        return $schedulestitles;
    }
    
    //*
    //* function Presences_Register_Schedules_Table, Parameter list: $schedule,$schedules=array()
    //*
    //* Handles registrations for schedule.
    //*

    function Presences_Register_Schedules_Table($schedule,$schedules=array())
    {
        if (empty($schedules)) { $schedules=$this->Presences_Register_Schedules_Read($schedule); }

        $schedulestable=
            $this->SchedulesObj()->MyMod_Items_Table
            (
               0,
               $schedules,
               $this->Presences_Schedules_Data()
            );

        foreach (array_keys($schedulestable) as $id)
        {
            $cell="-";
            if ($schedule[ "ID" ]!=$schedules[ $id ][ "ID" ])
            {
                $cell=$this->MyActions_Entry("Register",$schedules[ $id ]);
            }
            array_push($schedulestable[ $id ],$cell);
        }

        return $schedulestable;
    }

    //*
    //* function Presences_Register_Schedules_Show, Parameter list: $schedule,$schedules=array()
    //*
    //* Handles registrations for schedule.
    //*

    function Presences_Register_Schedules_Show($schedule,$schedules=array())
    {
        $method="Html_Table";
        if ($this->ApplicationObj()->LatexMode) { $method="LatexTable"; }
        
        return
            $this->H(2,$this->MyLanguage_GetMessage("Precenses_Submission_Schedule_Title")).
            $this->SchedulesObj()->$method
            (
               $this->Presences_Register_Schedules_Titles(),
               $this->Presences_Register_Schedules_Table($schedule,$schedules)
            ).
            "";
    }

}

?>