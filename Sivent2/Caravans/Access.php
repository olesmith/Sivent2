<?php

class Caravans_Access extends ModulesCommon  //Inscriptions
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function HasModuleAccess, Parameter list: $event=array()
    //*
    //* Determines if we have access to module.
    //*

    function HasModuleAccess($event=array())
    {
        $res=$this->ApplicationObj()->Current_User_Event_Caravans_May_Edit($event);

        return $res;
    }

    //*
    //* function CheckShowAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->HasModuleAccess();

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if ($item[ "Friend" ]=$this->LoginData("ID"))
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckShowListAccess($item=array())
    {
        $res=$this->HasModuleAccess();

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckEditAccess($item=array())
    {
        $res=$this->CheckShowAccess($item);
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if ($item[ "Friend" ]=$this->LoginData("ID"))
            {
                $res=TRUE;
            }
        }

        return $res;
   }
    
    //*
    //* function CheckEditListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->CheckShowListAccess($item);
   }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted.
    //* Coordiantor and Admin may - if not used in Caravans table.
    //*

    function CheckDeleteAccess($item=array())
    {
        return $this->CheckShowAccess($item);
   }
}

?>