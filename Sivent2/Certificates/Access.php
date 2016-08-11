<?php

class Certificates_Access extends ModulesCommon
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

        
        $res=$this->Current_User_Event_Coordinator_Is();
 
        return $res;
    }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted.
    //* Coordiantor and Admin may - if not used in Collaborators table.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=$this->Current_User_Event_Coordinator_Is();

        return $res;
    }
    
    //*
    //* function CheckGenerateAccess, Parameter list: $item=array()
    //*
    //* Checks if certificate $item may be generated.
    //*

    function CheckGenerateAccess($item=array())
    {
       if (empty($item)) { return TRUE; }

        $res=FALSE;
        if (preg_match('/^(Public)$/',$this->Profile()))
        {
            $code=$this->Certificates_Validate_CGI2Code();
            if ($this->Certificates_Validate_NMatch()>0)
            {
                $res=TRUE;
            }
        }
        elseif (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if ($item[ "Friend" ]==$this->LoginData("ID"))
            {
                $res=TRUE;
            }
        }
        else
        {
            $res=$this->Current_User_Event_Coordinator_Is();
        }
        
        return $res;
    }
}

?>