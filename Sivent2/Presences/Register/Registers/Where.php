<?php


class Presences_Register_Registers_Where extends Presences_Register_Registers_CGI
{
    //*
    //* function Presences_Schedule_Friend_Where, Parameter list: $schedule,$friendid
    //*
    //* Reads $friendid/$schedule unique where clause.
    //*

    function Presences_Schedule_Friend_Where($schedule,$friendid)
    {
        if (is_array($friendid)) { $friendid=$friendid[ "ID" ]; }
        
        return
            $this->UnitEventWhere
            (
               array
               (
                  "Friend" => $friendid,
                  "Schedule" => $schedule[ "ID" ],
               )
            );
    }

}

?>