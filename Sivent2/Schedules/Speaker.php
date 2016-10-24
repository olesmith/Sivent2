<?php

class SchedulesSpeaker extends SchedulesSchedules
{
    //*
    //* function Speakers, Parameter list: $friend
    //*
    //* Returns speaker's $friend data.
    //*

    function Speakers($friend)
    {
        if (is_array($friend)) { $friend=$friend[ "ID" ]; }
        
        if (empty($this->Speakers[ $friend ]))
        {
            $this->Speakers[ $friend ]=$this->Sql_Select_Hash(array("ID" => $friend));
        }

        return  $this->Speakers[ $friend ];
    }

    //*
    //* function Speaker2Schedules, Parameter list: $speaker,$datas=array()
    //*
    //* Returns speaker's submissions
    //*

    function Speaker2Schedules($speaker,$datas=array())
    {
        if (is_array($speaker)) $speaker=$speaker[ "Friend" ];

        $submissions=$this->SpeakersObj()->Speaker2Submissions($speaker,array("ID"));

        $sids=$this->MyHash_HashesList_Values($submissions,"ID");

        $where=$this->UnitEventWhere();
        $where[ "Submission" ]=$this->Sql_Where_IN($sids);

        //var_dump($where);

        return $this->Sql_Select_Hashes($where,$datas,"Submission");
    }

    //*
    //* function SchedulesSplit, Parameter list: 
    //*
    //* Returns sorted table with $schedules.
    //*

    function SchedulesSplit($schedules)
    {
        $schedules=$this->MyHash_HashesList_2IDs($schedules,"Date");

        $items=array();
        foreach ($this->ScheduleDates() as $date)
        {
            if (empty($schedules[ $date[ "ID" ] ])) { continue; }

            $dschedules=$schedules[ $date[ "ID" ] ];
            $dschedules=$this->MyHash_HashesList_2IDs($dschedules,"Time");
            
            foreach ($this->DateTimes($date) as $time)
            {
                if (empty($dschedules[ $time[ "ID" ] ])) { continue; }
            
                $tschedules=
                    $this->MyHash_HashesList_2IDs
                    (
                       $dschedules[ $time[ "ID" ] ],
                       "Place"
                    );
                
                foreach ($this->SchedulePlaces() as $place)
                {
                    if (empty($tschedules[ $place[ "ID" ] ])) { continue; }
                    
                    $pschedules=
                        $this->MyHash_HashesList_2IDs
                        (
                           $tschedules[ $place[ "ID" ] ],
                           "Place"
                        );

                    foreach ($this->ScheduleRooms($place) as $room)
                    {
                        if (empty($pschedules[ $room[ "ID" ] ])) { continue; }
                    
                        $rschedules=$pschedules[ $room[ "ID" ] ];
                       
                        foreach ($rschedules as $rschedule)
                        {
                            array_push
                            (
                               $items,
                               $rschedule
                            );
                        }
                    }
                }
            }
        }

        return $items;
    }
    
    //*
    //* function SchedulesTable, Parameter list: 
    //*
    //* Returns sorted table with $schedules.
    //*

    function SchedulesTable($schedules,$datas)
    {
        $schedules=$this->SchedulesSplit($schedules);
        
        return
            $this->SchedulesObj()->MyMod_Items_Table
            (
               0,
               $schedules,
               $datas
            );

    }

    //*
    //* function SchedulesHtmlTable, Parameter list: 
    //*
    //* Returns sorted table with $schedules.
    //*

    function SchedulesHtmlTable($schedules,$datas)
    {
        return
            $this->Html_Table
            (
               $this->GetDataTitles($datas),
               $this->SchedulesTable($schedules,$datas)
            );

    }

}

?>