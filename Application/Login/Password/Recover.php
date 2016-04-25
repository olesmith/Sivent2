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
    //* function StartPasswordRecovery, Parameter list: 
    //*
    //* Creates recovery entry and sends mail.
    //*

    function StartPasswordRecovery()
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
            $this->SendRecoverPasswordMail($user);
        }

        echo 
            $this->H(3,$this->GetMessage($this->LoginMessages,"Recover_Password_Mail_Message"));
    }


    //*
    //* function HandleRecover, Parameter list:
    //*
    //* Handles reset password procedure.
    //*

    function HandleRecover()
    {
        $this->MyApp_Interface_Head();

        if (
            ($this->GetPOST("Update")!=1)
            ||
            $this->GetPOST("Recover_Login")==""
           )
        {
            if (
                $this->GetGETOrPOST("Login")!=""
                &&
                preg_match('/^\S+\@\S+$/',$this->GetGETOrPOST("Login"))
                &&
                $this->GetGETOrPOST("Code")!=""
                &&
                preg_match('/^\d+$/',$this->GetGETOrPOST("Code"))
               )
            {
                $this->FinalRecoverPasswordForm();
            }
            else
            {
                $this->InitRecoverPasswordForm();
            }
        }
        else
        {
            $this->StartPasswordRecovery();
        }

        exit();

    }
}


?>