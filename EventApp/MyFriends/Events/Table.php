<?php

class MyFriends_Events_Table extends MyFriends_Events_Rows
{
    //*
    //* function Friend_Events_Exclude, Parameter list: $events,$excludeevents=array()
    //*
    //* Exclude $excludeevents in $events (as has been shown...).
    //*

    function Friend_Events_Exclude($events,$excludeevents=array())
    {
        $excludeids=array_keys($excludeevents);

        $revents=array();
        foreach (array_keys($events) as $id)
        {
            if (preg_grep('/^'.$events[ $id ][ "ID" ].'$/',$excludeids)) { continue; }

            $revents[ $id ]=$events[ $id ];
        }

        return $revents;            
    }

    
    //*
    //* function Friend_Events_Table, Parameter list: $friend,&$n,$events,$excludeevents=array()
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Events_Table($friend,&$n,$events,$excludeevents=array())
    {
        $events=$this->Friend_Events_Exclude($events,$excludeevents);
        if (empty($events))
        {
            return array();
        }
        
        $table=$this->Friend_Event_Titles();
        foreach ($events as $id => $event)
        {
            $event[ "No" ]=$n;
            $table=
                array_merge
                (
                   $table,
                   $this->Friend_Event_Rows($friend,$event)
                );
            $n++;
        }
        
        return $table;
    }
}

?>