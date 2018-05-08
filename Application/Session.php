<?php

class Session extends Login
{
    var $SessionsTable="Sessions";
    var $MayCreateSessionTable=FALSE;
    var $MaxLoginAttempts=5;
    var $BadLogonRegistered=0;
    var $NoInitSession=0;
    var $SessionData=array();
    var $SessionMessages="Session.php";
    #var $CookieTTL=3600;

    var $Authenticated=FALSE;



    //*
    //* function Session, Parameter list: 
    //*
    //* Constructur
    //*
    
    function SessionAddMsg($msg)
    {
        if (TRUE)
        {
            $this->AddMsg($msg);
        }
    }



    //*
    //* function GetSessionsTable, Parameter list: 
    //*
    //* Returns name of Sessions table
    //*

    function GetSessionsTable()
    {
        return $this->MyApp_Session_Table_Get();
    }



    //*
    //* function RegisterBadLogon, Parameter list: 
    //*
    //* Registers bad logon attempt.
    //*

    function RegisterBadLogon()
    {
        if ($this->BadLogonRegistered!=0) { return; }

        $login=strtolower($this->GetPOST("Login"));

        $time=time();

        //All sessions with attempted Login OR IP address
        //$where="Login='".$login."' OR IP='".$_SERVER[ "REMOTE_ADDR" ]."'";
        $where=
            $this->Sql_Table_Column_Name_Qualify("Login").
            "=".
            $this->Sql_Table_Column_Value_Qualify($login);
        
        $sessions=$this->SelectHashesFromTable($this->GetSessionsTable(),$where);

        if (count($sessions)>0)
        {
            foreach ($sessions as $id => $session)
            {
                $session[ "Login" ]=$login;
                $session[ "IP" ]=$_SERVER[ "REMOTE_ADDR" ];
                $session[ "ATime" ]=$time;
                $session[ "LastAuthenticationAttempt" ]=$time;
                $session[ "Authenticated" ]=1; //1, is not auth, enum!
                $session[ "LastAuthenticationSuccess" ]=-1;
                $session[ "NAuthenticationAttempts" ]++;

                $this->MySqlUpdateItem
                (
                   $this->GetSessionsTable(),
                   $session,$where
                );
                $this->SessionAddMsg("Removing bad session: ".$session[ "Login" ]);
            }
        }
        else
        {                    
            $session=array
            (
                "SID"       => -1,
                "LoginID"   => $this->LoginData[ "ID" ],
                "Login"     => $login,
                "LoginName" => $this->LoginData[ "Name" ],
                "CTime"     => $time,
                "ATime"     => $time,
                "IP"        => $_SERVER[ "REMOTE_ADDR" ],
                "Authenticated"  => 1, //1, is not auth, enum!
                "LastAuthenticationAttempt"  => $time,
                "LastAuthenticationSuccess"  => -1,
                "NAuthenticationAttempts"  => 1,
            );

            $this->MySqlInsertItem($this->GetSessionsTable(),$session);
        }

        $this->BadLogonRegistered=1;
     }

    //*
    //* function GoHTTPS, Parameter list: 
    //*
    //* Redirects to HTTPS.
    //*

    function GoHTTPS()
    {
        if (!isset($_SERVER[ "HTTPS" ]))
        {
            if (!empty($this->DBHash[ "HTTPS" ]))
            {
                header
                (
                   "Location: https://".$this->ServerName()."/".
                   $this->CGI_Script_Path()."/".
                   $this->CGI_Script_Name().
                   $this->CGI_Script_Path_Info()."?".
                   $this->CGI_Query_String()
                );

                exit();
            }
        }
    }



    //*
    //* function HandleShowSessions, Parameter list: 
    //*
    //* Show list of logged on users.
    //*

    function HandleShowSessions()
    {
        if ($this->Profile!="Admin") { die("Only admin may list sessions"); }

        $sqltable=$this->GetSessionsTable();
        
        $sessions=$this->Sql_Select_Hashes
        (
           array(),
           array(),
           "",
           "",
           $sqltable
         );

        $session=array_pop($sessions);
        array_push($sessions,$session);
        $keys=array_keys($session);
        //sort($keys);

        $delete=$this->CGI_GET("Session");

        $args=$this->CGI_URI2Hash();
        
        $table=array();
        foreach ($sessions as $session)
        {
            $href="";
            if (!empty($delete) && $session[ "ID" ]==$delete)
            {
                $res=$this->Sql_Delete_Item($delete,"ID",$sqltable);
                $href="Removed";
            }
            else
            {
                $args[ "Session" ]=$session[ "ID" ];
                $href=
                    $this->Href
                    (
                       "?".$this->CGI_Hash2URI($args),
                       "Remove",
                       "Remove Session/Login"
                    );
            }
            
            $row=array($href);
            foreach ($keys as $key)
            {
                array_push($row,$session[ $key ]);
            }

            array_push($table,$row);
        }

        $this->MyApp_Interface_Head();
        array_unshift($keys,"");
        echo
            $this->H(1,"Sessões Ativas").
            $this->Html_Table
            (
               $keys,
               $table
            ).
            "";
    }
}

?>