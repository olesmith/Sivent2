<?php

class Submissions_Access extends ModulesCommon
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
        $res=$this->ApplicationObj()->Current_User_Event_Submissions_May_Edit($event);
        
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

        if (preg_match('/^(Friend)$/',$this->Profile()))
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
        
        if (preg_match('/^(Public|Friend)$/',$this->Profile()))
        {
            if ($this->EventsObj()->Event_Submissions_Public())
            {            
                $res=TRUE;
            }
        }

        return $res;
    }
    
     //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckShowListAccess($item=array())
    {
        $res=$this->HasModuleAccess();

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if ($this->EventsObj()->Event_Submissions_Open())
            {            
                $res=TRUE;
            }
        }
        
        if (preg_match('/^(Public|Friend)$/',$this->Profile()))
        {
            if ($this->EventsObj()->Event_Submissions_Public())
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

        $res=$this->HasModuleAccess();

        if (preg_match('/^(Friend)$/',$this->Profile()))
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
    //* function CheckEditListAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditListAccess($item=array())
    {
        $res=
            $this->Current_User_Coordinator_Is()
            &&
            $this->HasModuleAccess();

        return $res;
    }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->CheckEditAccess($item);
        if ($item[ "Status" ]==2) { $res=FALSE; }

        $res=
            $res
            &&
            $this->SchedulesObj()->Sql_Select_Hashes_Has_Not
            (
                $this->UnitEventWhere
                (
                    array("Submission" => $item[ "ID" ],)
                )
            )
            &&
            $this->AssessorsObj()->Sql_Select_Hashes_Has_Not
            (
                $this->UnitEventWhere
                (
                    array("Submission" => $item[ "ID" ],)
                )
            )
            ;
 
        return $res;
    }
    
    //*
    //* function CheckAddAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckAddAccess($item=array())
    {
        $res=FALSE;
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $res=$this->EventsObj()->Event_Submissions_Open();
        }
        else
        {
            $res=$this->CheckEditAccess($item);
        }

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if (!$this->EventsObj()->Event_Submissions_Inscriptions_Open())
            {
                $res=FALSE;
            }
        }
        
        return $res;
    }
    
    //*
    //* function CheckDownloadAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be downloaded.
    //*

    function CheckDownloadAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
      
        $res=$this->CheckShowAccess($item);

        if (preg_match('/^(Public)$/',$this->Profile()))
        {
            $res=$this->EventsObj()->Event_Submissions_Public();
        }

        return $res;
    }
    
    //*
    //* function CheckCertAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may generate certificate.
    //*

    function CheckCertAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
      
        $res=$this->Current_User_Event_Coordinator_Is();

        if (preg_match('/^(Friend)$/',$this->Profile()))
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

        if (empty($item[ "Certificate" ]) || $item[ "Certificate" ]!=2)
        {
            $res=FALSE;
        }

        if (preg_match('/^(Public)$/',$this->Profile()))
        {
            $res=FALSE;
        }
        
        return $res;
    }

    //*
    //* function Submission_Author_Data_Perms, Parameter list: $data,$item
    //*
    //* Checks if author data is editable:
    //*
    //* True if $item "Freind".$n is positive.
    //*

    function Submission_Author_Data_Perms($data,$item)
    {
        if (empty($item)) { return 1; }

        $res=$this->ItemData[ $data ][ $this->Profile() ];

        //Show access, decision reached.
        if ($res<=1) { return $res; }
        
        if (preg_match('/\d+$/',$data,$matches))
        {
            $n=array_shift($matches);
        }
        else
        {
            $n=1;
        }
        
        $friendkey=$this->Author_Data_Get($n,"Friend");
        if ($res>0 && $item[ $friendkey ]>0)
        {
            $res=1;
        }
        
        return $res;
    }

}

?>