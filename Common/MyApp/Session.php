<?php

include_once("Session/Table.php");
include_once("Session/User.php");
include_once("Session/SID.php");
include_once("Session/Auth.php");

//This MUST be global
global $SessionInitialized;
$SessionInitialized=0;

trait MyApp_Session
{
    var $Auth_Message="";

    use
        MyApp_Session_Table,MyApp_Session_User,
        MyApp_Session_SID,MyApp_Session_Auth;

    //*
    //* function MyApp_Session_Init, Parameter list:
    //*
    //* Initilizes session:
    //*
    //* Initilizes Session Table,
    //* Cleans out old entries in session table,
    //* Tries to initilize User Session,
    //* Finally, calls PostInitSession, if exists as a class method.
    //*

    function MyApp_Session_Init()
    {
        //Must be global!
        global $SessionInitialized;

         if (method_exists($this,"PreInitSession"))
        {
            $this->PreInitSession($this->LoginData);
        }
       
        $this->AuthData=$this->ReadPHPArray("Auth.Data.php");
        if ($SessionInitialized==0 && $this->NoInitSession==0)
        {
            $this->MyApp_Session_User_Init();
            $SessionInitialized=1;
        }

        if (method_exists($this,"PostInitSession"))
        {
            $this->PostInitSession($this->LoginData);
        }
    }


    //*
    //* function MyApp_Session_Data, Parameter list:
    //*
    //* Returns data definitions for session table.
    //*

    function MyApp_Session_Data()
    {
        $file="../Common/MyApp/Session/Data.php";
        $this->DataFilesMTime=filemtime($file);

        return $this->ReadPHPArray($file);
    }
}

?>