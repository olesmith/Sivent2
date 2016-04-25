<?php


trait MyApp_Session_SID
{
    //*
    //* function MyApp_Session_SID_New, Parameter list: $sid
    //*
    //* Registers new $sid session.
    //*

    function MyApp_Session_SID_New()
    {
        $this->MyApp_Session_SID_User_Deletes($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $sid=rand().rand().rand();
        $time=time();
        $this->Session=array
        (
           "SID"       => $sid,
           "LoginID"   => $this->LoginData[ "ID" ],
           "Login"     => $this->LoginData[ "Login" ],
           "LoginName" => $this->LoginData[ "Name" ],
           "CTime"     => $time,
           "ATime"     => $time,
           "IP"        => $_SERVER[ "REMOTE_ADDR" ],
           "Authenticated"  => 2,
           "LastAuthenticationAttempt"  => $time,
           "LastAuthenticationSuccess"  => $time,
           "NAuthenticationAttempts"  => 0,
        );

        $this->MySqlInsertItem($this->GetSessionsTable(),$this->Session);
        $this->SetCookie("SID",$sid,$time+$this->CookieTTL);

        return $sid;
    }

    //*
    //* function MyApp_Session_SID_Read, Parameter list: $sid
    //*
    //* Reads $sid as session SID.

    function MyApp_Session_SID_Read($sid)
    {
        $this->Session=$this->Sql_Select_Hash
        (
           array
           (
              "SID" => $sid
           ),
           array(),
           TRUE,
           $this->GetSessionsTable()
        );
    }

    //*
    //* function MyApp_Session_SID_2LoginData, Parameter list: $sid
    //*
    //* Reads $sid as session SID.

    function MyApp_Session_SID_2LoginData($sid)
    {
        $logindata=$this->MyApp_Login_Retrieve_LoginData($this->Session[ "Login" ]);

        $this->MyApp_Login_SetData($logindata);
    }

    //*
    //* function MyApp_Session_SID_Update, Parameter list: $sid
    //*
    //* Updates session entry.
    //*

    function MyApp_Session_SID_Update($sid)
    {
        $this->MyApp_Session_SID_User_Deletes($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $time=time();
        $this->Session[ "Authenticated" ]=2;
        $this->Session[ "LastAuthenticationAttempt" ]=$time;
        $this->Session[ "LastAuthenticationSuccess" ]=$time;
        $this->Session[ "NAuthenticationAttempts" ]=0;
        $this->Session[ "ATime" ]=$time;

        $this->MySqlSetItemValues
        (
           $this->GetSessionsTable(),
           array
           (
              "Authenticated",
              "LastAuthenticationAttempt","LastAuthenticationSuccess",
              "NAuthenticationAttempts","ATime",
           ),
           $this->Session
        );

        $this->SetCookie("SID",$sid,$time+$this->CookieTTL);
    }

    //*
    //* function MyApp_Session_SID_Delete, Parameter list: $sid
    //*
    //* Deletes $sid in sessions the table.
    //*

    function MyApp_Session_SID_Delete($sid)
    {
        $this->SetCookie("SID","",time()-$this->CookieTTL);
        $this->Sql_Delete_Items
        (
           array
           (
              "SID" => $sid,
           ),
           $this->GetSessionsTable()
        );
    }
    //*
    //* function MyApp_Session_SID_User_Deletes, Parameter list: $loginid=""
    //*
    //* Deletes SID=$sid entries in sessions the table.
    //*

    function MyApp_Session_SID_User_Deletes($loginid="")
    {
        if (empty($loginid)) { $loginid=$this->LoginData[ "ID" ]; }
        if (empty($loginid)) { return; }

        //Delete all entries associated with
        //LoginID $loginid in session table
        $this->Sql_Delete_Items
        (
           array
           (
              "LoginID" => $loginid,
           ),
           $this->GetSessionsTable()
        );
    }



}

?>