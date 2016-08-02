<?php

class EventsSchedules extends EventsPreInscriptions
{
    //*
    //* function Event_Schedule_Public, Parameter list: $item=array()
    //*
    //* Returns TRUE if event may public Schedule.
    //*

    function Event_Schedule_Public($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=TRUE;
        if (empty($item[ "Schedule_Public" ]) || $item[ "Schedule_Public" ]!=2)
        {
            $res=FALSE;
        }

        return $res;
    }
}

?>