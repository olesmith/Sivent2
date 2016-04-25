<?php


trait MyApp_Session_User
{
    //*
    //* function , Parameter list: 
    //*
    //* SID set:
    //*  - Call TestUserSID, verifying SID validity
    //*    - if valid: set logindata and sessiondata and return
    //*    - else: BaddGuys, exit!
    //* else:
    //* If logon requested or required:
    //* - If given, validate logondata:
    //*   - if valid:
    //*      - create SID and session
    //*      - update Session DB
    //*      - Retrieve logindata from session data
    //*   - else:
    //*      - call MyApp_Login_Form and exit
    //*

    function MyApp_Session_User_InitBySID()
    {
        if (isset($_COOKIE[ "SID" ]))
        {
            $sid=$this->GetCookie("SID");
            if ($this->MyApp_Session_User_TestSID($sid))
            {
               $this->MyApp_Session_SID_Update($sid);

               $this->MyApp_Session_SID_2LoginData($sid);

               global $SessionInitialized;
               $SessionIntialized=1;
            }
            else
            {
                $this->MyApp_Session_SID_Delete($sid);
                $msg=$this->MyLanguage_GetMessage("Expired");
                $this->MyApp_Login_Form($msg);

                //$this->DoDie("Unable to verify SID",$sid);
            }

            return TRUE;
        }

        return FALSE;
    }

     //*
    //* function MyApp_Session_User_Init, Parameter list: 
    //*
    //* SID set:
    //*  - Call TestUserSID, verifying SID validity
    //*    - if valid: set logindata and sessiondata and return
    //*    - else: BaddGuys, exit!
    //* else:
    //* If logon requested or required:
    //* - If given, validate logondata:
    //*   - if valid:
    //*      - create SID and session
    //*      - update Session DB
    //*      - Retrieve logindata from session data
    //*   - else:
    //*      - call MyApp_Login_Form and exit
    //*

    function MyApp_Session_User_InitByAuth()
    {
        $authok=0;
        $action=$this->GetGETOrPOST("Action");

        if ($action=="Logon")
        {
            //Logon requested
            $authok=$this->MyApp_Session_Auth();
        }
        elseif ($this->PublicAllowed)
        {
            return;
        }
        else
        {
            //Logon required
            $authok=$this->MyApp_Session_Auth();
        }

        if ($authok>0)
        {
            $sid=$this->MyApp_Session_SID_New();

            $this->MyApp_Session_SID_2LoginData($sid);


            global $SessionInitialized;
            $SessionIntialized=1;
        }
        elseif ($this->GetPOST("Login") || $this->GetPOST("Password"))
        {
            $this->HtmlStatus=
                $this->MyLanguage_GetMessage("InvalidPassword");

            $this->RegisterBadLogon();
        }
    }


     //*
    //* function MyApp_Session_User_Init, Parameter list: 
    //*
    //* SID set:
    //*  - Call TestUserSID, verifying SID validity
    //*    - if valid: set logindata and sessiondata and return
    //*    - else: BaddGuys, exit!
    //* else:
    //* If logon requested or required:
    //* - If given, validate logondata:
    //*   - if valid:
    //*      - create SID and session
    //*      - update Session DB
    //*      - Retrieve logindata from session data
    //*   - else:
    //*      - call MyApp_Login_Form and exit
    //*

    function MyApp_Session_User_Init()
    {
        $this->GoHTTPS();
        if (!$this->MyApp_Session_User_InitBySID())
        {
           $this->MyApp_Session_User_InitByAuth();
        }
    }

    //*
    //* function MyApp_Session_User_TestSID, Parameter list: $sid
    //*
    //* Tests if SID privided by cookies is valid.
    //* Returns TRUE on success and FALSE on failure.
    //* On sucess SessionData hash is populated.
    //*

    function MyApp_Session_User_TestSID($sid)
    {
        if (preg_match('/^\d+$/',$sid) && $sid>0)
        {
            $this->MyApp_Session_SID_Read($sid);

            if (is_array($this->Session) && count($this->Session)>0)
            {
                if ($this->Session[ "SID" ]==$sid)
                {
                    $time=time();
                    if ($this->Session[ "Authenticated" ]==2)
                    {
                        if ($time-$this->Session[ "ATime" ]<=60*60)
                        {
                            if ($this->Session[ "IP" ]==$_SERVER[ "REMOTE_ADDR" ])
                            {
                                //Success

                                $this->SessionData=$this->Session;
                                return TRUE;
                            }
                            else
                            {
                                $this->BadGuy();
                                $this->DoDie("Unable to logon....");
                            }
                        }
                        else
                        {
                            $this->HtmlStatus=
                                $this->MyLanguage_GetMessage("Expired");
                            $this->SessionAddMsg("Logon expired");
                            $this->MyApp_Login_Form("Logon Expired",1,"");
                            $this->DoExit();
                        }
                    }
                    else
                    {
                        $this->SessionAddMsg("Not authenticated");
                        $this->MyApp_Login_Form("Not auth",1,"");
                        $this->DoExit();
                    }
                }
            }
            else
            {
                $this->SessionAddMsg("Invalid session: ".$this->Session);
            }
        }
        else
        {
            $this->SessionAddMsg("Invalid format: $sid");
        }

        return FALSE;
    }
}

?>