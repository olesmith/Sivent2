<?php

include_once("Recover/Forms.php");
include_once("Recover/Mail.php");

class LoginPasswordRecover extends LoginPasswordRecoverMail
{ 
    //*
    //* function AddRecoverEntry, Parameter list:& $user
    //*
    //* Creates recovery code and inserts record in auth sql table.
    //*

    function AddRecoverEntry(&$user)
    {
        $user[ "RecoverCode" ]=rand().rand();
        $user[ "RecoverMTime" ]=time();

        $this->MySqlSetItemValues
        (
           $this->AuthHash[ "Table" ],
           array("RecoverCode","RecoverMTime"),
           $user
        );
    }

    //*
    //* function Email2RecoverEntry, Parameter list: $email
    //*
    //* Retrieves recovery code from auth sql table.
    //*

    function Email2RecoverEntry($email)
    {
        return $this->SelectUniqueHash
        (
           $this->AuthHash[ "Table" ],
           array("Email" => $email),
           TRUE,
           array("RecoverCode","RecoverMTime")
        );
    }


    //*
    //* function Login_Password_Recovery_Start, Parameter list: 
    //*
    //* Creates recovery entry and sends mail.
    //*

    function Login_Password_Recovery_Start()
    {
        $user=$this->SelectUniqueHash
        (
           $this->AuthHash[ "Table" ],
           array
           (
              "Email" => $this->GetPOST("Recover_Login")
           ),
           TRUE
        );

        if (
              preg_match('/^\d+$/',$user[ "ID" ])
              &&
              $user[ "ID" ]>0
           )
        {
            $this->AddRecoverEntry($user);
            $this->Login_Password_Mail_Recover($user);
        }

        echo 
            $this->H(3,$this->GetMessage($this->LoginMessages,"Recover_Password_Mail_Message"));
    }

    //*
    //* function Login_Password_Recover_Has_Login, Parameter list:
    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Has_Login()
    {
        $login=$this->CGI_GETOrPOST("Login");
        if (!empty($login) && preg_match('/^\S+\@\S+$/',$login))
        {
            return True;
        }

        return False;
    }

    //*
    //* function Login_Password_Recover_Has_Code, Parameter list:
    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Has_Code()
    {
        $code=$this->CGI_GETOrPOST("Code");
        if (!empty($code) && preg_match('/^[0-9]+$/',$code))
        {
            return True;;
        }

        return False;
    }
    
    //*
    //* function Login_Password_Recover_Handle, Parameter list:
    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Handle()
    {
        $this->MyApp_Interface_Head();

        if (
            ($this->CGI_GETOrPOSTint("Update")!=1)
            ||
            $this->CGI_GETOrPOST("Recover_Login")==""
           )
        {
            if (
                $this->Login_Password_Recover_Has_Login()
                &&
                $this->Login_Password_Recover_Has_Code()
               )
            {
                $this->Login_Password_Recovery_Form_Final();
            }
            else
            {
                $this->Login_Password_Recovery_Form_Init();
            }
        }
        else
        {
            $this->Login_Password_Recovery_Start();
        }

        exit();

    }
}


?>