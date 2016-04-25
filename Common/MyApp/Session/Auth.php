<?php


trait MyApp_Session_Auth
{
    //*
    //* Testes authentication
    //*

    function AuthHash()
    {
        if (empty($this->AuthHash))
        {
            $this->AuthHash=$this->ReadPHPArray($this->AuthHashFile);

            $this->AuthHash[ 'LoginData' ]=preg_split('/\s*,\s*/',$this->AuthHash[ 'LoginData' ]);
        }

        return $this->AuthHash;
    }

    //*
    //* Testes authentication
    //*

    function MyApp_Session_Auth()
    {
        $login=strtolower($this->GetPOST("Login"));
        $login=preg_replace('/\s+/',"",$login);

        if ($login!="")
        {
            $where=
                $this->Sql_Table_Column_Name_Qualify("Login").
                "=".
                $this->Sql_Table_Column_Value_Qualify($login);
            
            $sessions=$this->SelectHashesFromTable($this->GetSessionsTable(),$where);

            $session=NULL;
            if (count($sessions)>=1)
            {
                //Take latest if doubt...
                $session=array_pop($sessions);
            }

            if (
                  is_array($session) && 
                  $session[ "NAuthenticationAttempts" ]>=$this->MaxLoginAttempts
               )
            {
                $this->MyApp_Session_Auth_TooManyAttempts();
            }
            elseif (count($sessions)>1)
            {
                $this->MyApp_Session_Auth_TooManySessions();
            }

            return $this->MyApp_Session_Auth_Authenticate($login);
        }

        return 0;
    }

    //*
    //* function MyApp_Session_Auth_Authenticate, Parameter list: $sid
    //*
    //* Handles invalid password.
    //*

    function MyApp_Session_Auth_Authenticate($login)
    {
        $logindata=$this->MyApp_Login_Retrieve_Data($login);

        if (count($logindata)>0)
        {
            $rlogin=$logindata[ "Login" ];
            if (strtolower($rlogin)==strtolower($login))
            {
                $password=$this->GetPOST("Password");

                $rrpassword=$password;
                if ($this->AuthHash[ "MD5" ]==1)
                {
                    $rrpassword=md5($password);
                }

                if ($rrpassword==$logindata[ "Password" ])
                {
                    $this->MyApp_Login_SetData($logindata);
                    $this->Authenticated=TRUE;

                    return TRUE;
                }
                else
                {
                    $this->Auth_Message=$this->MyLanguage_GetMessage("Error_PasswordMismatch");         
                }
            }
        }

        $this->Authenticated=FALSE;

        //Invalid login, if we are still here!
        $this->MyApp_Session_Auth_InvalidLogin($login);
    }


    //*
    //* function MyApp_Session_Auth_TooManyAttempts, Parameter list:
    //*
    //* Hhandles too any attempts.
    //*

    function MyApp_Session_Auth_TooManyAttempts()
    {
        $this->MyApp_Interface_Head();

        $msg1=$this->GetMessage
        (
           $this->SessionMessages,
           "SessionBlocked1"
        );
        $msg2=$this->GetMessage
        (
           $this->SessionMessages,
           "SessionBlocked2"
        );

        $msg1=preg_replace('/#MaxLoginAttempts/',$this->MaxLoginAttempts,$msg1);
        $msg2=preg_replace('/#MaxLoginAttempts/',$this->MaxLoginAttempts,$msg2);
        $this->RegisterBadLogon();

        echo
            $this->H(2,$msg1).
            $this->H(3,$msg2);

        $this->LogMessage("Auth",$msg1);

        $this->DoDie("Ciao....");;
    }


    //*
    //* function MyApp_Session_Auth_TooManySessions, Parameter list: $sid
    //*
    //* Hhandles too any sessions. Really shouldn't occur.
    //*

    function MyApp_Session_Auth_TooManySessions($where)
    {
        $this->Sql_Delete_Items($where,$this->GetSessionsTable());

        $this->SetCookie("SID","",time()-$this->CookieTTL);
        $this->ResetCookieVars();
        $this->MyApp_Login_Form("More than one LoginID Session!!");

        $this->DoDie("More than one Session");
    }


    //*
    //* function MyApp_Session_Auth_InvalidLogin, Parameter list: $login
    //*
    //* Handles invalid password.
    //*

    function MyApp_Session_Auth_InvalidLogin($login)
    {
        $this->Auth_Message=$this->MyLanguage_GetMessage("Error_PasswordMismatch");         

        $this->LogMessage("Authentication","Invalid login: ".$login);
        $this->RegisterBadLogon();
     }


}

?>