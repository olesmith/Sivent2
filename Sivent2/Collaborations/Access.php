<?php

class Collaborations_Access extends ModulesCommon
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
        /* //$res=$this->ApplicationObj()->Current_User_Event_Collaborations_May_Edit($event); */
        /* $res=$this->ApplicationObj()->Coordinator_Collaborations_Access_Has($event); */

        /* return $res; */
        return $this->EventsObj()->Event_Collaborations_Has($event);
    }
    //* function HasModuleEditAccess, Parameter list: $event=array()
    //*
    //* Determines if we have access to module.
    //*

    function HasModuleEditAccess($event=array())
    {
        //$res=$this->ApplicationObj()->Current_User_Event_Collaborations_May_Edit($event);
        $res=
            $this->HasModuleAccess($event)
            &&
            $this->ApplicationObj()->Coordinator_Collaborations_Access_Has($event);

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
        
        return $res;
    }

    //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
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
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->HasModuleEditAccess();

        return $res;
    }
    
    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditListAccess($item=array())
    {
        $res=$this->HasModuleEditAccess();

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
        
        $res=$this->HasModuleEditAccess();
        //$res=$this->ApplicationObj()->Current_User_Event_Collaborations_May_Edit($this->Event());

        if (
              $res
              &&
              $this->MyMod_Item_Children_Has
              (
                 array("CollaboratorsObj"),
                 array
                 (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $this->Event("ID"),
                    "Collaboration" => $item[ "ID" ],
                 )
              )
           )
        {
            $res=FALSE;
        }

        return $res;
    }
}

?>