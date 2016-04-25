<?php

class LoginLoginMail extends LoginPassword
{
    //*
    //* function SendChangeLoginMail, Parameter list: $user
    //*
    //* Sends email as a response to a login alteratiopn request.
    //*

    function SendChangeLoginMail($newemail,$user)
    {
        $user[ "NewEmail" ]=$newemail;
        $user[ "Email" ]=$user[ "Email" ].";".$newemail;
        $this->ApplicationSendEmail
        (
           $user,
           array
           (
              "Subject" => $this->GetMessage($this->LoginMessages,"Recover_Login_Mail_Subject"),
              "Body"    => $this->GetMessage($this->LoginMessages,"Recover_Login_Mail_Body"),
           )
        );
    }

    //*
    //* function SenddChangeLoginMail, Parameter list: $oldemail,$user
    //*
    //* Sends email informing that password has been changed.
    //*

    function  SendChangedLoginMail($oldemail,$user)
    {
        $user[ "OldEmail" ]=$oldemail;
        $user[ "Email" ]=$user[ "Email" ].";".$oldemail;
        $this->ApplicationSendEmail
        (
           $user,
           array
           (
              "Subject" => $this->GetMessage($this->LoginMessages,"Recovered_Login_Mail_Subject"),
              "Body"    => $this->GetMessage($this->LoginMessages,"Recovered_Login_Mail_Body"),
           )
        );
    }

}


?>