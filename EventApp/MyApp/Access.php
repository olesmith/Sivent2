<?php

include_once("Access/May.php");

class MyEventAppAccess extends MyEventAppAccess_May
{
    //*
    //* function EventAccess, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Checks if current user or $user, with current profile or $profile has access to
    //* current event or $event. Returns TRUE if access granted, FALSE otherwise.
    //*

    function EventAccess($event=array(),$user=array(),$profile="")
    {
       return TRUE;
    }

    
    //*
    //* function EventEditAccess, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Checks if current user or $user, with current profile or $profile has access to
    //* current event or $event. Returns TRUE if access granted, FALSE otherwise.
    //*

    function EventEditAccess($event=array(),$user=array(),$profile="")
    {
        if (empty($event))   { $event=$this->Event(); }
        if (empty($user))    { $user=$this->LoginData(); }
        if (empty($profile)) { $profile=$this->Profile(); }

        $res=FALSE;
        if (preg_match('/(Admin|Friend|Public)/',$profile))
        {
            $res=TRUE;
        }
        elseif (preg_match('/(Coordinator)/',$profile))
        {
            if (!empty($event))
            {
                //Event ids, user has access to.
                $events=
                    $this->PermissionsObj()->Sql_Select_Unique_Col_Values
                    (
                      "Event",
                       array
                       (
                          "User" => $user[ "ID" ],
                        )
                    );

                if (preg_grep('/^(0|'.$event[ "ID" ].')$/',$events)) { $res=TRUE; }
            }
            else
            {
                $res=TRUE;
            }
            
        }

        return $res;
    }

    
    //*
    //* function CheckUserEventAccess, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Gets user event access. If false, aborts.
    //*

    function CheckEventAccess($event=array(),$user=array(),$profile="")
    {
        $res=$this->EventAccess($event,$user,$profile);
        
        return $res; 
    }
    
    //*
    //* function CheckUserEventEditAccess, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Gets user event edit access. If false, aborts.
    //*

    function CheckEventEditAccess($event=array(),$user=array(),$profile="")
    {
        $res=$this->EventEditAccess($event,$user,$profile);
        
        return TRUE; 
    }
    
    //*
    //* function AppHasSponsors, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Gets user event access. If false, aborts.
    //*

    function AppHasSponsors()
    {
        return $this->Sponsors;
    }
    
    //*
    //* function FriendIsInscribed, Parameter list: $event=array(),$friend=array()
    //*
    //* Gets user event access. If false, aborts.
    //*

    function FriendIsInscribed($event=array(),$friend=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        return $this->EventsObj()->FriendIsInscribed($event,$friend);
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
        if (preg_match('/^(Coordinator|Admin)$/',$this->Profile()))
        {
            if ($this->LoginData("Unit")==$this->Unit("ID"))
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* sub Coordinator_Access_Has, Parameter list: $type,$event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Coordinator_Access_Has($type,$event=array())
    {
        $res=$this->Current_User_Admin_Is();
        if ($res) { return TRUE; }

        $res=$this->Current_User_Coordinator_Is();
        if (!$res) { return FALSE; }

        $res=$this->Current_User_Event_Coordinator_Is($event);
        if (!$res) { return FALSE; }

        $types=$this->Current_User_Event_Coordinator_Types($event);

        //var_dump($type);
        //if (!empty($event[ "ID" ])) var_dump($event[ "ID" ]);
        //var_dump($types);
        $res=FALSE;
        if (
              preg_grep('/^0$/',$types)
              ||
              preg_grep('/^'.$type.'/',$types)
           )
        {
            $res=TRUE;
        }

        return $res;
    }
    

    
    //*
    //* function Current_User_Event_Coordinator_Where, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns where clause for retrieving user event permissions.
    //*

    function Current_User_Event_Coordinator_Where($event=array(),$unit=array())
    {
        if (empty($unit)) { $unit=$this->Unit("ID"); }
        if (is_array($unit)) { $unit=$unit[ "ID" ]; }
        
        if (empty($event)) { $event=$this->Event("ID"); }
        if (is_array($event)) { $event=$event[ "ID" ]; }

        return
            array
            (
               "Unit" => $unit,
               "Event" => array(0,$event),
               "User" => $this->LoginData("ID"),
            );
        
    }

    
    //*
    //* function Current_User_Event_Coordinator_Permissions, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns  user event permissions.
    //*

    function Current_User_Event_Coordinator_Permissions($event=array(),$unit=array())
    {
        return
            $this->PermissionsObj()->Sql_Select_Hashes
            (
               $this->Current_User_Event_Coordinator_Where($event,$unit)
            );
    }

    //Transparent storage of permissions types read.
    var $__Types=array();
    
    //*
    //* function Current_User_Event_Coordinator_Types, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns  user event coordinator types.
    //*

    function Current_User_Event_Coordinator_Types($event=array(),$unit=array())
    {
        if (empty($this->__Types[ $event[ "ID" ] ]))
        {
            $this->__Types[ $event[ "ID" ] ]=
                $this->PermissionsObj()->Sql_Select_Unique_Col_Values
                (
                   "Type",
                   $this->Current_User_Event_Coordinator_Where($event,$unit)
                );    
        }
        
        return $this->__Types[ $event[ "ID" ] ];
    }

    
    //*
    //* function Current_User_Event_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Event_Coordinator_Is($event=array(),$unit=array())
    {
        if (empty($event)) { $event=$this->Event("ID"); }
        if (is_array($event)) { $event=$event[ "ID" ]; }
        
        $res=$this->Current_User_Admin_Is();

        if ($this->Current_User_Coordinator_Is() && !$res)
        {
            $events=
                $this->PermissionsObj()->Sql_Select_Unique_Col_Values
                (
                   "Event",
                   $this->Current_User_Event_Coordinator_Where($event,$unit)
                );

            if (preg_grep('/^(0|'.$event.')$/',$events)) { $res=TRUE; }
        }

        return $res;
    }
}
?>
