<?php

class SchedulesUpdate extends SchedulesSpeaker
{
    //*
    //* function UpdateScheduleDate, Parameter list: $date
    //*
    //* Central schedule handler.
    //*

    function UpdateScheduleDate($date)
    {
        foreach ($this->SchedulePlaces() as $place)
        {
            foreach ($this->DateTimes($date) as $id => $time)
            {
                foreach ($this->ScheduleRooms($place) as $room)
                {
                    $this->UpdateScheduleEntry($date,$time,$place,$room);
                }
            }
        }
    }
    
    //*
    //* function UpdateScheduleEntry, Parameter list: $date,$time,$place,$room
    //*
    //* Updates $schedule entry.
    //*

    function UpdateScheduleEntry($date,$time,$place,$room)
    {
        $submissionid=$this->ScheduleCGIValue($date,$time,$room);
        $where=array
        (
           "Time" => $room[ "ID" ],
           "Room" => $time[ "ID" ],
        );
        $where=$this->UnitEventWhere($where);
        $schedule=$this->Sql_Select_Hash($where);

         if ($submissionid>0)
        {
            $where=
                array
                (
                   "Unit" => $this->Unit("ID"),
                   "Event" => $this->Event("ID"),
                   "Submission" => $submissionid,
                   "Time" => $time[ "ID" ],
                );

            $nsubmissions=$this->Sql_Select_NHashes($where);
            if ($nsubmissions==0)
            {
                $where=
                    array
                    (
                       "Unit" => $this->Unit("ID"),
                       "Submission" => $submissionid,
                       "Date" => $date[ "ID" ],
                       "Time" => $time[ "ID" ],
                       "Room" => $room[ "ID" ],
                    );

                 $schedule=$where;
                 $schedule[ "Date" ]=$date[ "ID" ];
                 $schedule[ "Place" ]=$place[ "ID" ];
                 $schedule[ "Room" ]=$room[ "ID" ];
                 $schedule[ "Submission" ]=$submissionid;
             
                 $this->Sql_Unique_Item_AddOrUpdate
                 (
                    $where,
                    $schedule
                 );
            
                 //$this->SetSchedule($schedule);
            }
            else { print "already $nsubmissions<BR>"; }
            
        }
        elseif (!empty($schedule))
        {
            print "delete<BR>";
            $this->Sql_Delete_Items
            (
               array
               (
                  "Unit" => $this->Unit("ID"),
                  "Event" => $this->Event("ID"),
                  "Time" => $time[ "ID" ],
                  "Room" => $room[ "ID" ],
               )
            );

            //unset($this->Schedules[ $time[ "ID" ] ][ $room[ "ID" ] ]);
        }
    }
}

?>