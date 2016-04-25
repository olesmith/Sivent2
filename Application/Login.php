<?php

include_once("Login/Form.php");
include_once("Login/Logoff.php");
include_once("Login/Password.php");
include_once("Login/Login.php");
include_once("Login/ShiftUser.php");

class Login extends LoginShiftUser
{
    var $AuthHash=array();
    var $Login,$Password,$LoginID,$Privileges;
    var $LoginData=NULL;
    var $PersonIDCol,$CoordIDCol;
    var $PublicAllowed=0;
    var $PublicInterface=0;
    var $EditGroup="";
    var $AdminGroup="";
    var $LoginMessages="Login.php";
    var $NProfiles=0;
    var $LoginPreMessage="";
    var $LoginPostMessage="";
    var $RecoverPasswordTTL=3600;


    //*
    //* function GetLoginType, Parameter list: 
    //*
    //* Returns the actual login type, return the strings:
    //* Admin, Person or Public. Calls MyApp_Login_Detect first.
    //*

    function GetLoginType()
    {
        if (!preg_match('/^(Admin|Person|Public)$/',$this->LoginType))
        {
            $this->MyApp_Login_Detect();
        }

        $ltype="Public";
            if ($this->LoginType=="Admin")  { $ltype="Admin"; }
        elseif ($this->LoginType=="Person") { $ltype="Person"; }

        return $ltype;
    }

    //*
    //* function SetLoginData, Parameter list: $logindata
    //*
    //* Sets LoginData to $logindata. Also sets LoginData, LoginID and Login
    //*

    function SetLoginData($logindata)
    {
        if (is_array($logindata) && count($logindata)>0)
        {
            $this->LoginData=$logindata;

            $this->MyApp_Login_Detect();
        }
    }

    //*
    //* function GetLoginData, Parameter list: $data=""
    //*
    //* Returns the array LoginData.
    //*

    function GetLoginData($data="")
    {
        if (empty($data))
        {
            return $this->LoginData;
        }
        elseif (!empty($this->LoginData[ $data ]))
        {
            return $this->LoginData[ $data ];
        }
        
        return "";
    }


    //*
    //* function PrintPublicLink, Parameter list: $logindata
    //*
    //* If public is allowed, print a link to the public interface
    //*

    function PrintPublicLink()
    {
        if ($this->PublicAllowed)
        {
            print $this->H
            (
               3,
               $this->GetMessage($this->LoginMessages,"AccessPublic").
               $this->Href
               (
                  "?Public=1&Search=1",
                  $this->GetMessage($this->LoginMessages,"ClickHere")
               )
            );
        }
    }

    //*
    //* function FindLoggedID, Parameter list: 
    //*
    //* Finds and returns login ID logged in.
    //*

    function FindLoggedID()
    {
        $loginid=0;
        if ($this->LoginID!="" && $this->LoginID>0)
        {
            $loginid=$this->LoginID;
        }
        elseif ($this->LoginData[ "ID" ]!="" && $this->LoginData[ "ID" ]>0)
        {
            $loginid=$this->LoginData[ "ID" ];
        }

        if ($loginid>0)
        {
            $this->LoginID=$loginid;
            $this->LoginData[ "ID" ]=$loginid;
        }

        return $loginid;
    }

    //*
    //* function TransferLoginData, Parameter list: $object
    //*
    //* Centralized way of transferring login data to $object.
    //*

    function TransferLoginData($object)
    {
        $object->LoginType=$this->LoginType;
        $object->LoginID=$this->LoginID;

        $object->LoginData=$this->LoginData;
        $object->AuthHash=$this->AuthHash;

        foreach ($this->ExtraPathVars as $id => $data)
        {
            $object->$data=$this->$data;      
        }
    }

    //*
    //* function BadGuy, Parameter list: $object
    //*
    //* Something's wrong, are we expired or are we being spoofed?
    //* Write message and exit.
    //*

     function BadGuy()
    {
        exit();
        $this->MyApp_Interface_Head();

        $msg=$this->GetMessage($this->LoginMessages,"Expired");
        print $this->H
        (
           2,
           $msg."<BR>".
           $this->Href("?Login=1")
        );

        $this->PrintPublicLink();

        $this->SetCookie("SID","",time()-$this->CookieTTL);
        $this->ResetCookieVars();
        exit();
    }


}


?>