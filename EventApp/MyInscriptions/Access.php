<?php

class MyInscriptions_Access extends ModulesCommon
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function MayInscribe, Parameter list: $item=array()
    //*
    //* Checks if $friend may be inscribed, that is:
    //*
    //* 1: Has Profile in $this->ApplicationObj()->UserProfiles.
    //* 2: Not inscribed already.
    //*

    function MayInscribe($item=array())
    {
        if (empty($event)) { return TRUE; }
        
        $res=$this->Event_Inscriptions_Public_Is($event);
        if ($res)
        {
            $res=!$this->IsInscribed($this->LoginData());
        }

        return $res;
    }

    //*
    //* function IsInscribed, Parameter list: $friend
    //*
    //* Reads  inscription.
    //*

    function IsInscribed($friend)
    {
        $ninscriptions=$this->Sql_Select_NEntries
        (
           $this->Friend2SqlWhere($friend)
        );

        $res=FALSE;
        if ($ninscriptions>0) { $res=TRUE; }

        return $res;
    }

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
        
        if (!$res && preg_match('/^(Friend)$/',$this->Profile()))
        {
            if (
                  !empty($item[ "Friend" ])
                  &&
                  $item[ "Friend" ]==$this->LoginData("ID")
               )
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
        
        return $res;
    }
    
    //*
    //* function CheckReceitAccess, Parameter list: $item=array()
    //*
    //* Checks if $item receit may be printed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckReceitAccess($item=array())
    {
        $profile=$this->Profile();
        if ($profile=="Public") { return False; }
        
        if (empty($item)) { return TRUE; }
 
        $res=$this->Current_User_Event_Coordinator_Is();
        if (!$res && $profile=="Friend")
        {
            $res=$this->Inscription_Complete($item);
        }
        
        return $res;
    }
}

?>