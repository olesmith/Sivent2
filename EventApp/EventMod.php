<?php


class EventMod extends DBDataObj
{
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
        $res=FALSE;
        if (preg_match('/^(Admin)$/',$this->Profile()))
        {
            $res=TRUE;
        }

        return $res;
     }

    //*
    //* function Current_User_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Coordinator_Is()
    {
        $res=FALSE;
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            if ($this->LoginData("Unit")==$this->Unit("ID"))
            {
                $res=TRUE;
            }
        }

        return $res;
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
        if (empty($unit)) { $unit=$this->Unit("ID"); }
        if (is_array($unit)) { $unit=$unit[ "ID" ]; }
        
        if (empty($event)) { $event=$this->Event("ID"); }
        if (is_array($event)) { $event=$event[ "ID" ]; }
        
        $res=$this->Current_User_Admin_Is();
        if (!$res)
        {
            $events=
                $this->PermissionsObj()->Sql_Select_Unique_Col_Values
                (
                   "Event",
                   array
                   (
                      "User" => $this->LoginData("ID"),
                   )
                );

            if (preg_grep('/^(0|'.$event.')$/',$events)) { $res=TRUE; }
        }

        return $res;
    }
}

?>