<?php

class MyEventsAccess extends ModulesCommon
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
        $res=TRUE;
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
        if (empty($item[ "ID" ])) { return FALSE; }

        $res=$this->Current_User_Event_Coordinator_Is($item);

        return $res;
    }


    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted. That is:
    //* No questionary data defined - and no inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        if (empty($item[ "ID" ])) { return FALSE; }
        

        $res=$this->Current_User_Event_Coordinator_Is($item);
        if (
              $res
              &&
              $this->MyMod_Item_Children_Has
              (
                 array("InscriptionsObj","DatasObj","DataGroupsObj"),
                 array
                 (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $this->Event("ID"),
                 )
              )
           )
        {
            $res=FALSE;
        }
 
        return $res;
    }
    
    //*
    //* function Event_Inscriptions_Public_Is, Parameter list: $event=array()
    //*
    //* Checks if $event inscriptions are public.
    //*

    function Event_Inscriptions_Public_Is($event=array())
    {
        if (empty($event)) { return TRUE; }

        $res=TRUE;
        if ($event[ "Inscriptions_Public" ]==2)
        {
            $res=FALSE;
        }

        return $res;
    }

    //*
    //* function MayInscribe, Parameter list: $event=array()
    //*
    //* Checks if $friend may be inscribed, that is:
    //*
    //* 1: Has Profile in $this->ApplicationObj()->UserProfiles.
    //* 2: Not inscribed already.
    //*

    function MayInscribe($event=array())
    {
        if (empty($event)) { return TRUE; }
        
        $res=$this->Event_Inscriptions_Public_Is($event);
        if ($res)
        {
            $res=!$this->IsInscribed($event);
        }

        return $res;
    }

    
    //*
    //* function IsInscribed, Parameter list: $event=array()
    //*
    //* Checks if $friend may be inscribed, that is:
    //*
    //* 1: Has Profile in $this->ApplicationObj()->UserProfiles.
    //* 2: Not inscribed already.
    //*

    function IsInscribed($event=array())
    {
        if (empty($event)) { return TRUE; }
        
        $this->ApplicationObj()->Event=$event;
        
        $res=FALSE;
        if ($this->InscriptionsObj()->IsInscribed($this->LoginData()))
        {
            $res=TRUE;
        }

        return $res;
    }
}

?>