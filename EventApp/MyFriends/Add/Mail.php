<?php

class MyFriendsAddMail extends MyFriendsGroups
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

        /* $field="SendPassword"; */

        
        /* $this->ApplicationObj->ApplicationSendEmail */
        /* ( */
        /*    $friend, */
        /*    array */
        /*    ( */
        /*       "Subject" => $this->GetRealNameKey($this->MailTexts[ $field ],"Subject"), */
        /*       "Body"    => */
        /*          $this->GetRealNameKey($this->MailTexts[ "MailHead" ],"Head"). */
        /*          "\n\n". */
        /*          $this->GetRealNameKey($this->MailTexts[ $field ],"Body"). */
        /*          "\n\n---\n". */
        /*          $this->GetRealNameKey($this->MailTexts[ "MailTail" ],"Tail") */
        /*    ) */
        /* ); */
   }
}

?>