<?php


class MyPermissionsAccess extends ModulesCommon
{
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
        
        $res=
            $this->Current_User_Admin_Is()
            ||
            $this->Current_User_Coordinator_Is();
      
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

        $res=
            $this->Current_User_Admin_Is()
            ||
            $this->Current_User_Event_Coordinator_Is(array("ID" => 0));

        return $res;
    }


    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted. That is:
    //* No questionary data defined - and no inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        if (empty($item[ "ID" ])) { return FALSE; }

        $res=$this->Current_User_Admin_Is();

        //var_dump($res);
 
        return $res;
    }    
}

?>