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
        $user[ "Email" ]=$user[ "Email" ];                
        
        $this->MyMod_Mail_Typed_Send
        (
           "Email_Change",
           $user,
           $this->Unit(),
           array
           (
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
        $user[ "Email" ]=$user[ "Email" ];
        $this->MyMod_Mail_Typed_Send
        (
           "Email_Changed",
           $user,
           $this->Unit(),
           array
           (
           )
        );
    }

}


?>