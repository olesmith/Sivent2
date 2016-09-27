<?php


class EventMod extends DBDataObj
{
    var $Uploads_Item2GGI=array("Event","Unit"); //Uploads, reverse path order
    
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
    }
    
    //*
    //* function InitActions, Parameter list:
    //*
    //* Overrides MySql2::InitActions.
    //*

    function InitActions()
    {
        parent::InitActions();

        foreach ($this->Access_Methods as $action => $method)
        {
            $this->Actions[ $action ][ "AccessMethod" ]=$method;
        }
    }

    //*
    //* function Current_User_Admin_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Admin_Is()
    {
        return $this->ApplicationObj()->Current_User_Admin_Is();
    }

    //*
    //* function Current_User_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Coordinator_Is()
    {
        return $this->ApplicationObj()->Current_User_Coordinator_Is();
    }

    //*
    //* function Unit_Events_Has, Parameter list: $unit=array()
    //*
    //* Returns TRUE if current unit has events registered.Otherwise FALSE.
    //*

    function Unit_Events_Has($unit=array())
    {
        if (empty($unit)) { $unit=$this->Unit("ID"); }
        if (is_array($unit)) { $unit=$unit[ "ID" ]; }
        
        $res=$this->MyMod_Item_Children_Has
        (
           "EventsObj",
           array("Unit" => $unit)
        );

        return $res;
     }

    //*
    //* function Current_User_Event_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Event_Coordinator_Is($event=array(),$unit=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Coordinator_Is($event,$unit);
    }
    
    //*
    //* function Event_Inscriptions_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Inscriptions_DateSpan($event=array())
    {
        return $this->EventsObj()->Event_Inscriptions_DateSpan($event);
    }
}

?>