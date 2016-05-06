<?php

class MyEventAppAccess extends MyEventAppAccessors
{
    //*
    //* function UserEventAccess, Parameter list: $event=array(),$user=array(),$profile=""
    //*
    //* Checks if current user or $user, with current profile or $profile has access to
    //* current event or $event. Returns TRUE if access granted, FALSE otherwise.
    //*

    function EventAccess($event=array(),$user=array(),$profile="")
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
        if (empty($event))   { $event=$this->Event(); }
        if (empty($user))    { $user=$this->LoginData(); }
        if (empty($profile)) { $profile=$this->Profile(); }

        if (!$this->EventAccess($event,$user,$profile))
        {
            $this->DoDie("No '".$profile."' user access to event",$event,$user);
        }
        
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
}
?>
