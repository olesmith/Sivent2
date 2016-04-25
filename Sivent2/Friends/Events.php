<?php


class FriendsEvents extends FriendsCollaborations
{
    //*
    //* function Friend_Events_Read, Parameter list: $friend=array()
    //*
    //* Reads suitable events for friend.
    //*

    function Friend_Events_Read($friend=array())
    {
        if (empty($friend))
        {
            $friend=$this->LoginData();
        }
        
        $events=array();
        foreach ($this->EventsObj()->Events_Open_Get() as $event)
        {
            $events[ $event ]=TRUE;
        }
        
        foreach ($this->EventsObj()->Sql_Select_Unique_Col_Values("ID","","ID") as $event)
        {
            $inscr=
                $this->Sql_Select_Unique_Col_Values
                (
                   "ID",
                   array("Friend" => $friend[ "ID" ]),
                   "ID",
                   $this->ApplicationObj->SqlEventTableName("Inscriptions","",array("ID" => $event))
                );

            if (count($inscr)>0) { $events[ $event ]=TRUE; }
        }
        
        $events=array_keys($events);
        sort($events,SORT_NUMERIC);

        return $this->EventsObj()->Sql_Select_Hashes(array("ID" => $this->Sql_Where_IN($events)));
    }

    
    //*
    //* function FriendEventsTable, Parameter list: $friend=array()
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Events_Table($friend=array())
    {
        $events=$this->Friend_Events_Read($friend);

        $this->EventsObj()->ItemData();
        $this->EventsObj()->Actions();
        
        echo
            $this->Html_Table
            (
               "",
               $this->EventsObj()->ItemsTableDataGroup
               (
                  "",
                  0,
                  "",
                  $events
               )
            ).
            "";
        exit();
    }
}

?>