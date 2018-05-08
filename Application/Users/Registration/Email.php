<?php



class UsersRegistrationEmail extends Profiles
{
    //*
    //* function SendRegistrationEmail, Parameter list:
    //*
    //* Sends the registration confirmation email.
    //*

    function SendRegistrationEmail($friend)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Confirm";
        $args[ "ConfirmCode" ]=$friend[ "ConfirmCode" ];
        $args[ "NewEmail" ]=$friend[ "CondEmail" ];
        

        $rargs=$args;
        unset($rargs[ "ConfirmCode" ]);
        
        $rrargs=$rargs;
        $rrargs[ "Action" ]="ResendConfirm";
 
        $mailtype="Register";
        if ($this->GetCGIVarValue("Action")=="ResendConfirm")
        {
            $mailtype="Confirm_Resend";
        }


        $this->MyMod_Mail_Typed_Send
        (
           $mailtype,
           $friend,
           $this->Unit(),
           array
           (
              "ConfirmLink" => $this->CGI_Script_Exec
              (
                  $this->CGI_Hash2URI($args)
              ),
              "ConfirmLinkForm" => $this->CGI_Script_Exec
              (
                  $this->CGI_Hash2URI($rargs)
              ),
              "ResendCodeLink" => $this->CGI_Script_Exec
              (
                  $this->CGI_Hash2URI($rrargs)
              ),
           )
        );
    }

    //*
    //* function SendConfirmedEmail, Parameter list:
    //*
    //* Sends the confirmation email.
    //*

    function SendConfirmedEmail($friend)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Logon";
        $args[ "Email" ]=$friend[ "Email" ];
        unset($args[ "ConfirmCode" ]);
        
        $rargs=$args;
        $rargs[ "Action" ]="ResendConfirm";
 
        $mailtype="Confirm";

        $this->MyMod_Mail_Typed_Send
        (
           $mailtype,
           $friend,
           $this->Unit(),
           array
           (
              "LoginLink" => $this->CGI_Script_Exec
              (
                  $this->CGI_Hash2URI($args)
              ),
              "RecoverPasswordLink" => $this->CGI_Script_Exec
              (
                  $this->CGI_Hash2URI($rargs)
              ),
           )
        );
    }
}

?>