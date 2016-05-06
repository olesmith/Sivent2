<?php

class LoginPasswordRecoverMail extends LoginPasswordRecoverForms
{
    //*
    //* function SendRecoverPasswordMail, Parameter list: $user
    //*
    //* Sends email as a response to a password reset request.
    //*

    function  SendRecoverPasswordMail($user)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Recover";
        $args[ "Login" ]=$this->GetPOST("Recover_Login");
        $args[ "Code" ]=$user[ "RecoverCode" ];
                
        $this->MyMod_Mail_Typed_Send
        (
           "Password_Reset",
           $user,
           $this->Unit(),
           array
           (
              "RecoverLink" => $this->ScriptExec
              (
                 $this->CGI_Hash2URI($args)
              ),
           )
        );
    }

    //*
    //* function SendPasswordRecoveredMail, Parameter list: $user
    //*
    //* Sends email informing that password has been changed.
    //*

    function  SendPasswordRecoveredMail($user)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Login";

        $this->MyMod_Mail_Typed_Send
        (
           "Password_Changed",
           $user,
           $this->Unit(),
           array
           (
              "LoginLink" => $this->ScriptExec
              (
                 $this->CGI_Hash2URI($args)
              ),
           )
        );
    }

}


?>