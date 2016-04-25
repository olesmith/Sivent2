<?php

class LoginLogoff extends LoginForm
{
    //*
    //* function DoLogoff, Parameter list: $logindata
    //*
    //* Does logoff, that is, resets the SID cookie and other cookies,
    //* writes a messgae containing link to login and exits.
    //*

    function DoLogoff()
    {
        $this->LoginType="Public";
        $this->LogMessage("Logoff","Logged off");
        $this->CookieTTL=time()-60*60; //in the past to disable

        $unit=$this->GetCGIVarValue("Unit");

        $this->SetCookie("SID","",time()-$this->CookieTTL);
        $this->SetCookie("Admin","",time()-$this->CookieTTL);
        $this->SetCookie("Profile","",time()-$this->CookieTTL);
        $this->SetCookie("ModuleName","",time()-$this->CookieTTL);

        //Delete entry en session table
        if (isset($this->SessionData[ "SID" ]))
        {
            $this->MyApp_Session_SID_Delete($this->SessionData[ "SID" ]);
        }

        $this->ResetCookieVars();

        $this->LoginType="Public";
        $this->Profile="Public";

        $args=$this->Query2Hash();
        $args=$this->Hidden2Hash($args);
        $query=$this->Hash2Query($args);

        $this->AddCommonArgs2Hash($args);
        $args[ "Action" ]="Start";

        $this->MyApp_CGI_Reload_Try($args);

        //Shouldn't get here!!
        exit();
    }
}


?>