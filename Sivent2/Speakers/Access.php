<?php

class Speakers_Access extends ModulesCommon
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function CheckShowAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->Current_User_Event_Coordinator_Is();
        if (!$res && preg_match('/^(Candidate|Friend)/',$this->Profile()))
        {
            if (!empty($item[ "Friend" ]) && $item[ "Friend" ]==$this->LoginData("ID"))
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
         
        $res=$this->CheckShowAccess($item);
        
        return $res;
    }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
         
        $res=$this->Current_User_Event_Coordinator_Is();

        if ($res)
        {
            $nitems=
                $this->SubmissionsObj()->Sql_Select_NHashes
                (
                   array("Friend" => $item[ "Friend" ])
                )
                +
                $this->SubmissionsObj()->Sql_Select_NHashes
                (
                   array("Friend2" => $item[ "Friend" ])
                )
                +
                $this->SubmissionsObj()->Sql_Select_NHashes
                (
                   array("Friend3" => $item[ "Friend" ])
                );

            if ($nitems>0) { $res=FALSE; }
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
        $res=$this->Current_User_Event_Coordinator_Is();

        return $res;
    }
     //*
    //* function CheckEditListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckEditListAccess($item=array())
    {
        $res=$this->Current_User_Event_Coordinator_Is();

        return $res;
    }
}

?>