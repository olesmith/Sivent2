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
    //*
    //* function UnitWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => sql where clause.
    //*

    function UnitWhere($where=array(),$unit=array())
    {
        if (empty($unit))  $unit=$this->Unit();
        
        $where[ "Unit" ]=$unit[ "ID" ];

        return $where;
    }

    //*
    //* function UnitEventWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => and Event => sql where clause.
    //*

    function UnitEventWhere($where=array(),$event=array(),$unit=array())
    {
        if (empty($event)) $event=$this->Event();
        if (empty($unit))  $unit=$this->Unit();

        if (!is_array($event))
        {
            $event=array("ID" => $event);
        }
        
        $where[ "Unit" ]=$unit[ "ID" ];
        $where[ "Event" ]=$event[ "ID" ];

        return $where;
    }

    //*
    //* sub Unit, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Unit($key="")
    {
        $res=$this->ApplicationObj()->CGI_GET2Hash("Unit","UnitsObj",$key,"Unit",FALSE);

        $action=$this->CGI_GET("Action");
        if (empty($this->ApplicationObj()->Unit) && $action!="Start")
        {
            echo
                "No such unit: ".$this->CGI_GETint("Unit");

            exit(1);
        }
        
        return $res;
    }

    //*
    //* sub Event, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Event($key="")
    {
        return $this->ApplicationObj()->CGI_GET2Hash("Event","EventsObj",$key,"Event",FALSE);
    }

    //*
    //* function PrintDocHeads, Parameter list: 
    //*
    //* Overrides Application::PrintDocHeads.
    //*

    function PrintDocHeads()
    {
        $this->ApplicationObj()->MyApp_Interface_Head();
    }


    //*
    //* function SetEvent, Parameter list: 
    //*
    //* Sets $this->ApplicationObj->Event to $event.
    //*

    function SetEvent($event)
    {
        $this->ApplicationObj->Event=$event;
    }


    //*
    //*
    //* function SqlEventTableName, Parameter list: $table="",$event=array()
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlEventTableName($module,$event=array())
    {
        $table="#Unit__#Event_".$module;

        $eventid=0;
        if ($this->CGI_GET("ModuleName")=="Events")
        {
            $eventid=$this->CGI_GET("ID");
        }

        if (empty($eventid))
        {
            $eventid=$this->CGI_GET("Event");
        }

        if (!empty($event))
        {
            $eventid=$event[ "ID" ];
        }

        $table=preg_replace('/#Event/',$eventid,$table);

        return preg_replace('/#Unit/',$this->ApplicationObj->Unit("ID"),$table);
    }
    
}

?>