<?php


class MyUnitsAccess extends ModulesCommon
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckShowAccess($item=array())
    {
        $res=TRUE;

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=
            $this->Current_User_Admin_Is()
            ||
            $this->Current_User_Event_Coordinator_Is(array("ID" => 0));

        return $res;
    }

    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted.
    //* That is, if noone is inscribed.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=
            $this->Current_User_Admin_Is()
            &&
            !$this->Unit_Events_Has();

        return $res;
    }
}

?>