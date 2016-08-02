<?php

class SchedulesSchedules extends SchedulesSchedule
{   
    //*
    //* function ReadSchedules, Parameter list: $date
    //*
    //* Reads event schedules, if necessary.
    //*

    function ReadDateSchedules($date)
    {
        $where=$this->UnitEventWhere(array("Date" => $date[ "ID" ]));

        $rschedules=array();
        foreach ($this->Sql_Select_Hashes($where) as $schedule)
        {
            $schedule=$this->PostProcess($schedule);
            
            $timeid=$schedule[ "Time" ];
            $roomid=$schedule[ "Room" ];
            
            if (empty($rschedules[ $timeid ])) $rschedules[ $timeid ]=array();
            $rschedules[ $timeid ][ $roomid ]=$schedule;

            if (!empty($schedule[ "Submission" ]))
            {
                $submissionid=$schedule[ "Submission" ];
            }
        }
        
        
        return $rschedules;
    }
    
    //*
    //* function Schedules2Authors, Parameter list: $time,$cschedule
    //*
    //* Detects authors that are occupied at time $cschedule.
    //* Current schedule, $cschedule, desconsidered.
    //*

    function Scheduled2Authors($time,$cschedule)
    {
        $timeid=$time[ "ID" ];
        if (empty($this->Schedules[ $timeid ])) return array();
        
        $authors=array();
        foreach ($this->Schedules[ $timeid ] as $roomid => $schedule)
        {
            if (!empty($cschedule[ "ID" ]) && $schedule[ "ID" ]==$cschedule[ "ID" ]) { continue; }
            
            if (!empty($schedule[ "Submission" ]))
            {
                $submissionid=$schedule[ "Submission" ];
                foreach ($this->Submissions($submissionid,"Friends") as $fid)
                {
                    $authors[ $fid ]=1;
                }
            }
        }

        return $authors;
    }

    
    //*
    //* function Schedules2Submissions, Parameter list: $time,$cschedule
    //*
    //* Detects submissions that are occupied at time of $cschedule.
    //* Current schedule, $cschedule, desconsidered.
    //*

    function Scheduled2Submissions($time,$cschedule)
    {
        $timeid=$time[ "ID" ];
        if (empty($this->Schedules[ $timeid ])) return array();
        
        $submissions=array();
        foreach ($this->Schedules[ $timeid ] as $roomid => $schedule)
        {
            if (!empty($cschedule[ "ID" ]) && $schedule[ "ID" ]==$cschedule[ "ID" ]) { continue; }
            
            if (!empty($schedule[ "Submission" ]))
            {
                $submissionid=$schedule[ "Submission" ];
                $submissions[ $submissionid ]=1;
            }
        }
        
        return $submissions;
    }
    
    //*
    //* function DisableScheduledSubmissions, Parameter list: $time,$cschedule,$submissions=array()
    //*
    //* Disables relevant submissions from being rescheduled.
    //*

    function DisableScheduledSubmissions($time,$cschedule,$submissions=array())
    {
        if (empty($submissions)) $submissions=$this->Submissions();
        
        //Disable already schedule submissions
        foreach ($this->Scheduled2Submissions($time,$cschedule) as $sid)
        {
            $submissions[ $sid ][ "Disabled" ]=TRUE;
        }

        //Disable already schedule authors
        $authorids=$this->Scheduled2Authors($time,$cschedule);

        foreach (array_keys($submissions) as $sid)
        {
            foreach ($this->Submissions($sid,"Friends") as $fid)
            {
                if (!empty($authorids[ $fid ]))
                {
                    $submissions[ $sid ][ "Disabled" ]=TRUE;
                }
            }
        }

        return $submissions;
    }
}

?>