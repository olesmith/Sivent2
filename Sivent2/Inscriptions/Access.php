<?php

class InscriptionsAccess extends MyInscriptions
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function CheckShowAccess, Parameter list: $item
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=parent::CheckShowAccess($item);

        if ($res) { $res=$this->Current_User_Event_May_Access($this->Event()); }

        return $res;
    }
    
    //*
    //* function CheckShowListAccess, Parameter list: $item
    //*
    //* Checks if we may show list of iincriptions.
    //*

    function CheckShowListAccess($item=array())
    {
        //$res=$this->Current_User_Event_May_Access($this->Event());
        $res=$this->Coordinator_Inscriptions_Access_Has();

        return $res;
    }
    
    //*
    //* function CheckEditAccess, Parameter list: $item
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=parent::CheckEditAccess($item);

        if ($res)
        {
            $res=
                $this->ApplicationObj()->Current_User_Event_Inscription_May_Edit
                (
                    $item,
                    $this->Event()
                );
        }

        return $res;
    }

    //*
    //* function CheckEditListAccess, Parameter list: $item
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function CheckEditListAccess($item=array())
    {
        $res=$this->ApplicationObj()->Current_User_Event_Inscriptions_May_Edit($this->Event());

        return $res;
    }

    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=parent::CheckDeleteAccess($item);
        if ($res)
        {
            $res=$this->CheckEditAccess($item);
        }
        
        if ($res)
        {
            if
                (
                   $this->MyMod_Item_Children_Has
                   (
                      array
                      (
                         "CollaboratorsObj",
                         "SubmissionsObj",
                         "CaravaneersObj",
                         "SpeakersObj",
                         "PreInscriptionsObj",
                         "PresencesObj",
                      ),
                      array
                      (
                         "Unit" => $this->Unit("ID"),
                         "Event" => $this->Event("ID"),
                         "Friend" => $item[ "Friend" ],
                      )
                   )
                )
            {
                $res=FALSE;
            }
        }

 
        return $res;
    }
    
    //* function CheckCertificateAccess, Parameter list: $item=array()
    //*
    //* Checks if cert may be printed. Access rights and liberation.
    //*

    function CheckCertificateAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=FALSE;
        if ($this->Current_User_Event_Coordinator_Is())
        {
            $res=
                $this->ApplicationObj()->Current_User_Event_Inscriptions_May_Edit($this->Event());
        }
        elseif (!empty($item[ "Friend" ]) && $item[ "Friend" ]==$this->LoginData("ID"))
        {
            $res=TRUE;
        }

        if (empty($item[ "Certificate" ]) || $item[ "Certificate" ]!=2)
        {
            $res=FALSE;
        }
        
        $res=
            $res
            &&
            $this->EventsObj()->Event_Certificates_Published()
            &&
            $this->CheckEditAccess($item);
        
        return $res;
    }
    
    //* function CheckCertificatesAccess, Parameter list: $item=array()
    //*
    //* Checks if cert may be printed. Access rights and liberation.
    //*

    function CheckCertificatesAccess($item=array())
    {
        $res=FALSE;
        if ($this->Current_User_Event_Coordinator_Is())
        {
            $res=
                $this->ApplicationObj()->Current_User_Event_Inscriptions_May_Edit($this->Event())
                &&
                $this->CheckEditListAccess();
        }
        
        $res=
            $res
            &&
            $this->EventsObj()->Event_Certificates_Published();

        return $res;
    }
}

?>