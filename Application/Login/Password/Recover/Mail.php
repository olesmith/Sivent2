<?php

class LoginPasswordRecoverMail extends LoginPasswordRecoverForms
{
    //*
    //* function Login_Password_Mail_Recover, Parameter list: $user
    //*
    //* Sends email as a response to a password reset request.
    //*

    function  Login_Password_Mail_Recover($user)
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
              "RecoverLink" => $this->CGI_Script_Exec
              (
                 $this->CGI_Hash2URI($args)
              ),
           )
        );
    }

    //*
    //* function Login_Password_Mail_Recovered, Parameter list: $user
    //*
    //* Sends email informing that password has been changed.
    //*

    function  Login_Password_Mail_Recovered($user)
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
              "LoginLink" => $this->CGI_Script_Exec
              (
                 $this->CGI_Hash2URI($args)
              ),
           )
        );
    }

}


?>