<?php

class SchedulesTimes extends SchedulesAccess
{
    var $TimesSelectField="Times";
    var $TimeGETField="Time";
    
    //*
    //* function Times, Parameter list: 
    //*
    //* Reads event dates, if necessary.
    //*

    function Times()
    {
        if (empty($this->Times))
        {
            $this->Times=
                $this->TimesObj()->Sql_Select_Hashes
                (
                   array
                   (
                      "Unit" => $this->Unit("ID"),
                      "Event" => $this->Event("ID"),
                    )
                );
        }

        return $this->Times;
    }
        
    //*
    //* function Date, Parameter list: $key=""
    //*
    //* Reads event date, if necessary.
    //*

    function Date($key="")
    {
        if (empty($this->Date))
        {
            $date=$this->CGI_GETOrPOSTint($this->DateGETField);
            if (!empty($date))
            {
                $this->Date=
                    $this->TimesObj()->Sql_Select_Hash
                    (
                       array
                       (
                          "ID" => $date,
                          "Unit" => $this->Unit("ID"),
                          "Event" => $this->Event("ID"),
                        )
                    );
            }
            
        }

        if (!empty($key)) { return $this->Date[ $key ]; }
        
        return $this->Date;
    }
    
    //*
    //* function DateTimes, Parameter list: $date
    //*
    //* Returns $date hours.
    //*

    function DateTimes($date)
    {
        return
            $this->TimesObj()->Sql_Select_Hashes
            (
               array
               (
                  "Date" => $date[ "ID" ],
                  "Unit" => $this->Unit("ID"),
                  "Event" => $this->Event("ID"),
               )
            );
    }
    
    
    //*
    //* function ScheduleTimes, Parameter list: 
    //*
    //* Returns dates to include in schedule.
    //*

    function ScheduleTimes()
    {
        $dateids=$this->CGI2Times();

        $dates=array();
        foreach ($this->Times() as $did => $date)
        {
            if (preg_grep('/^'.$date[ "ID" ].'$/',$dateids))
            {
                array_push($dates,$date);
            }
        }

        return $dates;
    }

    
    
    //*
    //* function CGI2Times, Parameter list: 
    //*
    //* Detects Times ids to include.
    //*

    function CGI2Times()
    {
        $dateids=$this->CGI_POSTint($this->TimesSelectField);
        if (empty($dateids))
        {
            $date=$this->CGI_GETOrPOSTint($this->DateGETField);
            if (!empty($date))
            {
                $dateids=array($date);
            }
            else
            {
                $dateids=array();
                foreach ($this->Times() as $did => $date)
                {
                    array_push($dateids,$date[ "ID" ]);
                }
            }
        }

        return $dateids;
    }
    //*
    //* function TimesSelectField, Parameter list: $dates=array()
    //*
    //* Creates multiple dates select field.
    //*

    function TimesSelectField($dates=array())
    {
        if (empty($dates)) { $dates=$this->Times(); }
        return
            $this->Html_Select_Multi_Field
            (
               $dates,
               "Times",
               "ID",
               "#Name",
               "",
               $this->CGI2Times(),
               $addempty=FALSE
            );
    }
    
    //*
    //* function TimesSchedulesTables, Parameter list: $edit
    //*
    //* Generates all dates schedule.
    //*

    function TimesSchedulesTables($edit)
    {
        $tables=array();
        foreach ($this->ScheduleTimes() as $date)
        {
            array_push($tables,$this->DateSchedulesTable($edit,$date));
        }

        return $tables;
    }

    
    //*
    //* function TimesScheduleRooomsCommonField, Parameter list: $date,$time
    //*
    //* Produces event common field for time slot.
    //*

    function TimesScheduleRooomsCommonField($date,$time)
    {
        $texts=array();
        if (!empty($time[ "Activity" ]))
        {
            array_push($texts,$time[ "Activity" ]);
        }
                
        if (!empty($time[ "Room" ]))
        {
            array_push($texts,$this->RoomsObj()->Sql_Select_Hash_Value($time[ "Room" ],"Name"));
        }
                
        return join(": ",$texts);
    }
    
    //*
    //* function TimesScheduleRoomsTitleRow, Parameter list: $edit,$date,$time,$place,$rooms
    //*
    //* Generates titles row with room names.
    //*

    function TimesScheduleRoomsTitleRow($edit,$date,$place,$rooms)
    {
        return
            array_merge
            (
               array($this->GetRealNameKey($this->ItemData[ "Time" ])),
               $this->RoomsObj()->RoomTitleCells($rooms,$date),
               array("")
            );
                
    }


    //*
    //* function TimesRoomsTopology, Parameter list: $edit,$times,$rooms
    //*
    //* Initializes topology. If we are NOT editing, performs 'shrinking on rows.
    //*

    function TimesRoomsTopology($edit,$times,$rooms)
    {
        $this->TimesRoomsInitTopology($times,$rooms);
        if ($edit==0)
        {
            $this->TimesRoomsEditTopology($times,$rooms);
        }
    }    
    
    //*
    //* function TimesRoomsInitTopology, Parameter list: $times,$rooms
    //*
    //* Returns initial times/rooms topology.
    //*

    function TimesRoomsInitTopology($times,$rooms)
    {
        $this->Topology=array();
        foreach ($times as $id => $time)
        {
            $timeid=$time[ "ID" ];
            
            $row=array();
            foreach ($rooms as $room)
            {
                $roomid=$room[ "ID" ];
                
                $submission=0;
                if (!empty($this->Schedules[ $timeid ][ $roomid ]))
                {
                    $submission=$this->Schedules[ $timeid ][ $roomid ][ "Submission" ];
                }
                
                $row[ $roomid ]=
                    array
                    (
                       "ID" => $submission,
                       "Count" => 1,
                    );
            }

            $this->Topology[ $timeid ]=$row;
        }
    }
    
    //*
    //* function TimesRoomsEditTopology, Parameter list: $times,$rooms
    //*
    //* Edits initial times/rooms topology, 'shrinking' repeated submissions,
    //* .
    //*

    function TimesRoomsEditTopology($times,$rooms)
    {
        foreach ($rooms as $room)
        {
            $roomid=$room[ "ID" ];
            
            $lasttimeid=0;
            $submission=0;
            foreach (array_keys($this->Topology) as $timeid)
            {
                if ($submission>0 && $this->Topology[ $timeid ][ $roomid ][ "ID" ]==$submission)
                {
                    unset($this->Topology[ $timeid ][ $roomid ]);
                    $this->Topology[ $lasttimeid ][ $roomid ][ "Count" ]++;
                }
                else
                {
                    $submission=$this->Topology[ $timeid ][ $roomid ][ "ID" ];
                    $lasttimeid=$timeid;
                }
            }
        }
    }
    
    //*
    //* function TimesRoomsTopologyCells, Parameter list: 
    //*
    //* Returns initial times/rooms topology.
    //*

    function TimesRoomsTopologyCells($edit,$date,$time,$place,$rooms)
    {
        $timeid=$time[ "ID" ];
        
        $row=array($this->B($this->TimesObj()->TimeTitleCell($time,$date)));
        
        foreach ($rooms as $room)
        {
            $roomid=$room[ "ID" ];
            if (!empty($this->Topology[ $timeid ][ $roomid ]))
            {
                array_push($row,$this->TimesRoomsTopologyCell($edit,$date,$time,$place,$room));
            }
        }
        
        array_push($row,"");

        return $row;
     }

    
    //*
    //* function TimesRoomsTopologyCell, Parameter list: $edit,$date,$time,$place,$room
    //*
    //* Creates topology cell entry. If Count key>1, multirowses.
    //*

    function TimesRoomsTopologyCell($edit,$date,$time,$place,$room)
    {
        $timeid=$time[ "ID" ];
        $roomid=$room[ "ID" ];
        
        $cell=$this->ScheduleRoomSubmissionField($edit,$date,$time,$place,$room);
        if ($this->Topology[ $timeid ][ $roomid ][ "Count" ]>1)
        {
            $nrows=$this->Topology[ $timeid ][ $roomid ][ "Count" ];
            $options=array("ROWSPAN" => $nrows);
            if (is_array($cell))
            {
                foreach ($cell[ "Options" ] as $option => $value)
                {
                    $options[ $option ]=$value;
                }
                
                $cell=$cell[ "Text" ];
            }
            $cell=
                array
                (
                   "Text"    => $cell,
                   "Options" => $options,
                );
        }

        return $cell;
    }
        
    //*
    //* function TimesScheduleRoomsRowDiagnostics, Parameter list: $edit,$date,$time,$room
    //*
    //* Generates row with room fields.
    //*

    function TimesScheduleRoomsDiagnosticsRows($edit,$date,$time,$place,$rooms)
    {
        $rows=array();
        if ($edit==1 && $time[ "Type" ]!=1)
        {
            $where=$this->UnitEventWhere(array("Time" => $time[ "ID" ]));
            $schedules=$this->Sql_Select_Hashes($where);
            if (count($schedules)>0)
            {
                //Create table with conflicting entries. Supposedly with delete link.
                array_push
                (
                   $rows,
                   array
                   (
                      $this->MyMod_Items_Group_Table_Html
                      (
                         0,
                         $schedules,
                         "Palestras Lancadas em Horário Comum"
                      ),
                   )
                );
             }
        }

        return $rows;
    }
}

?>