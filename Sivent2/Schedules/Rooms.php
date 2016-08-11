<?php

class SchedulesRooms extends SchedulesDates
{
    var $RoomsSelectField="Rooms";
    var $RoomGETField="Room";
    //*
    //* function Rooms, Parameter list: 
    //*
    //* Reads event rooms, if necessary.
    //*

    function Rooms()
    {
        if (empty($this->Rooms))
        {
            $this->Rooms=
                $this->RoomsObj()->Sql_Select_Hashes
                (
                   array
                   (
                      "Unit" => $this->Unit("ID"),
                      "Event" => $this->Event("ID"),
                    )
                );
        }

        return $this->Rooms;
    }
    
    //*
    //* function Room, Parameter list: $key=""
    //*
    //* Reads event room, if necessary.
    //*

    function Room($key="")
    {
        if (empty($this->Room))
        {
            $room=$this->CGI_GETOrPOSTint($this->RoomGETField);
            if (!empty($room))
            {
                $this->Room=
                    $this->RoomsObj()->Sql_Select_Hash
                    (
                       array
                       (
                          "ID" => $room,
                          "Unit" => $this->Unit("ID"),
                          "Event" => $this->Event("ID"),
                        )
                    );
            }
        }

        if (!empty($key)) { return $this->Room[ $key ]; }
        
         return $this->Room;
    }
    
    //*
    //* function ScheduleRooms, Parameter list: $place
    //*
    //* Returns dates to include in schedule.
    //*

    function ScheduleRooms($place)
    {
        $roomids=$this->CGI2Rooms($place);

        $rooms=array();
        foreach ($this->Rooms() as $rid => $room)
        {
            if (preg_grep('/^'.$room[ "ID" ].'$/',$roomids))
            {
                array_push($rooms,$room);
            }
        }

        return $rooms;
    }

    
    //*
    //* function CGI2Rooms, Parameter list: $place
    //*
    //* Creates multiple rooms select field.
    //*

    function CGI2Rooms($place)
    {
        $roomids=$this->CGI_POSTint($this->RoomsSelectField);
        if (empty($roomids))
        {
            $room=$this->CGI_GETOrPOSTint($this->RoomGETField);
            if (!empty($room))
            {
                $roomids=array($room);
            }
            else
            {
                $roomids=array();
                foreach ($this->Rooms() as $rid => $room)
                {
                    if ($room[ "Place" ]==$place[ "ID" ])
                    {
                        array_push($roomids,$room[ "ID" ]);
                    }
                }
            }
        }

        return $roomids;
    }
    
    //*
    //* function RoomsSelectField, Parameter list: $rooms=array()
    //*
    //* Creates multiple rooms select field.
    //*

    function RoomsSelectField($rooms=array())
    {
        if (empty($rooms)) { $rooms=$this->Rooms(); }
        
        return
            $this->Html_Select_Multi_Field
            (
               $rooms,
               $this->RoomsSelectField,
               "ID",
               "#Name",
               "",
               $this->CGI2Rooms(),
               $addempty=FALSE
            );
    }

    //*
    //* function ScheduleRoomSubmissionField, Parameter list: $edit,$date,$time,$room
    //*
    //* Generates $date, $time, $roow scedule field.
    //*

    function ScheduleRoomSubmissionField($edit,$date,$time,$place,$room)
    {
        $schedule=$this->Schedule($date,$time,$place,$room);

        if ($edit==1) { return $this->ScheduleRoomSubmissionEditField($date,$time,$room,$schedule); }
        else          { return $this->ScheduleRoomSubmissionShowField($date,$time,$room,$schedule); }
    }
    
    //*
    //* function ScheduleRoomSubmissionShowField, Parameter list: $date,$time,$room,$schedule
    //*
    //* Generates $date, $time, $roow show scedule field.
    //*

    function ScheduleRoomSubmissionShowField($date,$time,$room,$schedule)
    {
        $cell="";
        if (!empty($schedule[ "Submission" ]))
        {
            $submission=$this->SubmissionsObj()->Sql_Select_Hash(array("ID" => $schedule[ "Submission" ]));

            $friendinfo="-";
            
            $options=array();
            $class="";
            if (!empty($submission[ "Area" ]))
            {
                $area=$this->AreasObj()->Sql_Select_Hash($submission[ "Area" ],array("Color","Background"));
                $class='Area'.$submission[ "Area" ];
                $options[ "CLASS" ]=$class;
            }
            
            if (!empty($submission[ "Friend" ]))
            {
                $friend=$this->Speakers[ $submission[ "Friend" ] ];
                $friendinfo=$this->FriendsObj()->FriendInfo($friend,$class);
            }

            
            $cell=
                array
                (
                   "Text" => $this->FrameIt
                   (
                      $this->Span
                      (
                         $this->SubmissionsObj()->SubmissionAuthors($submission),
                         array("CLASS" => 'Bold')
                      ).
                      $this->BR().
                      $this->BR().
                      $this->Span
                      (
                         $this->SubmissionsObj()->SubmissionInfo($submission),
                         array("CLASS" => 'Italic')
                      ).
                      $this->BR().
                      $this->BR().
                      $this->ScheduleRoomMenu($schedule).
                      ""
                   ),
                   "Options" => $options
                );
        }

        return $cell;
    }
    
    //*
    //* function ScheduleRoomSubmissionEditField, Parameter list: $edit,$date,$time,$room,$schedule
    //*
    //* Generates $date, $time, $roow scedule select field.
    //*

    function ScheduleRoomSubmissionEditField($date,$time,$room,$schedule)
    {
        $submissionid=0;
        if (!empty($schedule[ "Submission" ])) $submissionid=$schedule[ "Submission" ];
        
        return 
            $this->Html_SelectField
            (
               $this->DisableScheduledSubmissions($time,$schedule),
               $this->ScheduleCGIName($date,$time,$room),
               "ID",
               "#Title",
               "#Authors",
               $submissionid,
               TRUE,
               "Disabled"
            ).
            "";
   }
    
    //*
    //* function ScheduleRoomMenu, Parameter list: $schedule
    //*
    //* Generates administrative menu for schedule cell. Returns empty for non admin users.
    //*

    function ScheduleRoomMenu($schedule)
    {
        //if (!preg_match('/(Admin|Coordinator)/',$this->Profile())) { return; }

        return
            $this->MyMod_HorMenu_Actions
            (
               array
               (
                  "Submission",
                  "PreInscriptions",
                  "Presences",
               ),
               "",
               "",
               $schedule
            ).
            "";
    }
    
}

?>