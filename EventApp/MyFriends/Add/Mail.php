<?php

class MyFriends_Add_Mail extends MyFriends_Groups
{
    //*
    //* function SendPasswordMail, Parameter list: $friend
    //*
    //* Sends recover password mail.
    //*

    function SendPasswordMail($friend)
    {
        $this->MailTexts=$this->MyMod_Mail_Texts_Get();

        $args=$this->CGI_URI2Hash();

        
        $args[ "Action" ]="Login";

        $rargs=$args;
        $rargs[ "Action" ]="Recover";
        
        $friend[ "Login_Name" ]=$this->LoginData[ "Name" ];

        $mailtype="Email_Created";

        $this->MyMod_Mail_Typed_Send
        (
           $mailtype,
           $friend,
           $this->Unit(),
           array
           (
              "LoginLink" => $this->ScriptExec
              (
                  $this->CGI_Hash2URI($args)
              ),
              "RecoverLoginLink" => $this->ScriptExec
              (
                  $this->CGI_Hash2URI($rargs)
              ),
           )
        );
   }
}

?>