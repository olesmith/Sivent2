<?php

class SchedulesSchedule extends SchedulesSubmissions
{
    //*
    //* function SetSchedule, Parameter list: $schedule
    //*
    //* Stores schedule
    //*

    function SetSchedule($schedule)
    {
        if (empty($this->Schedules[ $schedule[ "Date" ] ]))
        {
            $this->Schedules[ $schedule[ "Date" ] ]=array();
        }

        if (empty($this->Schedules[ $schedule[ "Date" ] ][ $schedule[ "Time" ] ]))
        {
            $this->Schedules[ $schedule[ "Date" ] ][ $schedule[ "Time" ] ]=array();
        }

        $this->Schedules[ $schedule[ "Date" ] ][ $schedule[ "Time" ] ][ $schedule[ "Room" ] ]=$schedule;
    }
    
    //*
    //* function Schedule, Parameter list: $date,$time,$room
    //*
    //* Returns schedule entry, if defined.
    //*

    function Schedule($date,$time,$place,$room)
    {
        if (is_array($time))  { $time=$time[ "ID" ]; }
        if (is_array($room))  { $room=$room[ "ID" ]; }

        $schedule=array(); 
        if (
              !empty($this->Schedules[ $time ])
              &&
              !empty($this->Schedules[ $time ][ $room ])
           )
        {
            $schedule=$this->Schedules[ $time ][ $room ];
        }

        return $schedule;
    }
        
    //*
    //* function ScheduleCGIName, Parameter list: $date,$time,$room
    //*
    //* Returns CGI name of schedule field.
    //*

    function ScheduleCGIName($date,$time,$room)
    {
        if (is_array($date)) { $date=$date[ "ID" ]; }
        if (is_array($time)) { $time=$time[ "ID" ]; }
        if (is_array($room)) { $room=$room[ "ID" ]; }
       
        return "Schedule_".$date."_".$time."_".$room;
    }
        
    //*
    //* function ScheduleCGIValue, Parameter list: $date,$time,$room
    //*
    //* Returns CGI value of schedule field.
    //*

    function ScheduleCGIValue($date,$time,$room)
    {
        return $this->CGI_POSTint($this->ScheduleCGIName($date,$time,$room));
    }
}

?>