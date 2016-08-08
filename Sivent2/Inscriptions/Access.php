<?php

class InscriptionsAccess extends MyInscriptions
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

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
            if
                (
                   $this->MyMod_Item_Children_Has
                   (
                      array("CollaboratorsObj","CaravaneersObj",),
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
        
        //if ($this->Current_User_Event_Coordinator_Is()) { return TRUE; }
        
        $res=FALSE;
        if (!empty($item[ "Certificate" ]) && $item[ "Certificate" ]==2)
        {
            $res=TRUE;
        }
        
        
        $res=
            $res
            &&
            (
               $this->Current_User_Event_Coordinator_Is()
               ||
               $this->Inscriptions_Certificates_Published()
            )
            &&
            $this->CheckShowAccess($item);

        return $res;
    }
}

?>