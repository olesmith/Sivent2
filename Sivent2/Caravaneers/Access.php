<?php

class CaravaneersAccess extends ModulesCommon
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
        if (empty($item)) { return TRUE; }

        $res=$this->Current_User_Event_Coordinator_Is();

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            if ($item[ "Friend" ]=$this->LoginData("ID"))
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
        return $this->CheckShowAccess($item);
   }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted.
    //* Coordiantor and Admin may - if not used in Caravaneers table.
    //*

    function CheckDeleteAccess($item=array())
    {
        return $this->CheckShowAccess($item);
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
            //Todo: Check via code.
        }

        return $res;
    }
}

?>