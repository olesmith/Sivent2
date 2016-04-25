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
 
        $href=$this->ScriptExec($this->CGI_Hash2URI($args));
        $href=preg_replace('/index.php/',"",$this->A($href));

        $args[ "Action" ]="Recover";
        $rhref=$this->ScriptExec($this->CGI_Hash2URI($args));
        $rhref=preg_replace('/index.php/',"",$this->A($rhref));

        $field="SendPassword";

        //Store in $friend in order to values being filtered.
        $friend[ "Href1" ]=$href;
        $friend[ "Href2" ]=$rhref;
        $friend[ "Login_Name" ]=$this->LoginData[ "Name" ];

        $this->ApplicationObj->ApplicationSendEmail
        (
           $friend,
           array
           (
              "Subject" => $this->GetRealNameKey($this->MailTexts[ $field ],"Subject"),
              "Body"    =>
                 $this->GetRealNameKey($this->MailTexts[ "MailHead" ],"Head").
                 "\n\n".
                 $this->GetRealNameKey($this->MailTexts[ $field ],"Body").
                 "\n\n---\n".
                 $this->GetRealNameKey($this->MailTexts[ "MailTail" ],"Tail")
           )
        );
   }
}

?>