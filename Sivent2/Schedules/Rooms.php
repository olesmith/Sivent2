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
}

?>