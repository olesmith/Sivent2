<?php

class MyFriendsAccess extends MyFriendsFriend
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
        if (!$res && preg_match('/^(Candidate|Assessor|Friend)/',$this->Profile()))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->LoginData("ID"))
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
        
        $res=$this->Current_User_Event_Coordinator_Is(array("ID" => 0));
        
        if (!$res && preg_match('/^(Candidate|Assessor|Friend)/',$this->Profile()))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->LoginData("ID"))
            {
                $res=TRUE;
            }
        }
        return $res;
    }
}

?>