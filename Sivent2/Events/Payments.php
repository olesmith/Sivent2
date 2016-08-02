<?php

class EventsPayments extends EventsCaravans
{
    //*
    //* function Event_Payments_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event is paid.
    //*

    function Event_Payments_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=FALSE;
        if (!empty($item[ "Payments" ]) && $item[ "Payments" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }
}

?>