<?php

class MyEventsFriend extends MyEventsAccess
{
    //*
    //* function FriendIsInscribed, Parameter list: $event,$friend
    //*
    //* Detects whether $friend is inscribed in $event.
    //*

    function FriendIsInscribed($event,$friend)
    {
        if (empty($event)) { return FALSE; }
        
        $ninscriptions=$this->InscriptionsObj()->MySqlNEntries
        (
            "",
            array
            (
                "Friend" => $friend[ "ID" ],
                "Event" => $event[ "ID" ],
             )
        );

        $res=TRUE;
        if ($ninscriptions==0)
        {
            $res=FALSE;
        }

        return $res;
    }
}

?>