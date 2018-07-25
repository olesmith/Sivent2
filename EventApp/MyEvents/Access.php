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
    //* function Event_Inscriptions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has Caravans.
    //*

    function Event_Inscriptions_Open($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        if (empty($event)) { return FALSE; }

        $res=$this->Event_Inscriptions_Public_Is($event);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$event[ "StartDate" ]
                  ||
                  $today>$event[ "EndDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }
    
    //*
    //* function Event_Inscriptions_Show_Should, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has Caravans.
    //*

    function Event_Inscriptions_Show_Should($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        if (empty($event)) { return FALSE; }

        $res=$this->Event_Inscriptions_Public_Is($event);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if
                (
                    $today<$event[ "StartDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }
    
    //*
    //* function Event_Inscriptions_Show_Should, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has Caravans.
    //*

    function Event_Inscriptions_Edit_May($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        if (empty($event)) { return FALSE; }

        $res=$this->Event_Inscriptions_Public_Is($event);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$event[ "StartDate" ]
                  ||
                  $today>$event[ "EditDate" ]
               )
            {
                $res=FALSE;
            }
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
        
        $res=$this->Event_Inscriptions_Open($event);
        if ($res)
        {
            $res=!$this->IsInscribed($event);
        }
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

    function IsInscribed($event=array(),$friend=array())
    {
        if (empty($event)) { return TRUE; }
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        $this->ApplicationObj()->Event=$event;
        
        $res=FALSE;
        if ($this->InscriptionsObj()->IsInscribed($friend))
        {
            $res=TRUE;
        }

        return $res;
    }
}

?>