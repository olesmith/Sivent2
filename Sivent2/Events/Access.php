<?php

class EventsAccess extends MyEvents
{
    //*
    //* function CheckShowAccess, Parameter list: $item
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item)
    {
        if (empty($item)) { return TRUE; }
        
        $res=parent::CheckShowAccess($item);

        if ($res) { $res=$this->Current_User_Event_May_Access($item); }

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item)
    {
        if (empty($item)) { return TRUE; }
        
        $res=parent::CheckEditAccess($item);

        if ($res) { $res=$this->Current_User_Event_May_Edit($item); }

        return $res;
    }

    /* //\* */
    /* //\* function CheckDeleteAccess, Parameter list: $item */
    /* //\* */
    /* //\* Checks if $item may be deleted. That is: */
    /* //\* No questionary data defined - and no inscriptions. */
    /* //\* */

    /* function CheckDeleteAccess($item) */
    /* {  */
    /*     $res=parent::CheckDeleteAccess($item); */

    /*     return $res; */
    /* } */
}

?>