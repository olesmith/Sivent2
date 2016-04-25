<?php



class UsersRegistrationForms extends UsersRegistrationTables
{
    //*
    //* function RegistrationForm, Parameter list: $options,$formoptions
    //*
    //* Creates the Registration form.
    //*

    function RegistrationForm($options,$formoptions)
    {
        return
            $this->FrameIt
            (
                $this->H
                (
                   4,
                   $this->MyMod_Language_Message("RegistrationForm_Title","Name")
                ).
                $this->StartForm().
                $this->RegistrationTable($formoptions).
                $this->MakeHidden("Register",1).
                $this->Buttons().
                $this->EndForm(),
                array("WIDTH" => '80%')
            ).
            "<P></P>".
            $this->RegistrationTrailingTable($options).
            "<BR>".
            "";

    }


    //*
    //* function ResendConfirmRegistrationForm, Parameter list: $options,$formoptions
    //*
    //* Creates the resend Confirm Registration form.
    //*

    function ResendConfirmRegistrationForm($options,$formoptions)
    {
        return
            $this->FrameIt
            (
                $this->H
                (
                   4,
                   $this->MyMod_Language_Message("ResendConfirmRegistrationForm_Title","Name")
                ).
               $this->StartForm().
               $this->ResendConfirmRegistrationTable($formoptions).
               $this->MakeHidden("Resend",1).
               $this->Buttons().
               $this->EndForm()
            ).
            "<P></P>".
            $this->ResendConfirmationLinks($options).
            "";

    }

    //*
    //* function ConfirmRegistrationForm, Parameter list: $options,$formoptions
    //*
    //* Creates the Confirm Registration form.
    //*

    function ConfirmRegistrationForm($options,$formoptions)
    {
        return
            $this->FrameIt
            (
                $this->H
                (
                   4,
                   $this->MyMod_Language_Message("ConfirmRegistrationForm_Title","Name")
                ).
                $this->StartForm().
                $this->ConfirmRegistrationTable($formoptions).
                $this->MakeHidden("Confirm",1).
                $this->Buttons().
                $this->EndForm()
            ).
            "<P></P>".
            $this->ConfirmationTrailingTable($options).
            "";

    }

    //* function LogioForm, Parameter list: $options,$formoptions
    //*
    //* Creates the Logon form.
    //*

    function LogonForm($options,$formoptions)
    {
        return
            $this->FrameIt
            (
                $this->H(4,"Logon: Digite Email e Senha").
                $this->StartForm("","post",0,array(),array("ModuleName")).
                $this->LogonTable($formoptions).
                $this->MakeHidden("Logon",1).
                $this->Buttons().
                $this->EndForm()
            ).
            "<P></P>>".
            $this->LogonTrailingTable($options).
            "";

    }


    //* function RecoverForm, Parameter list: $options,$formoptions
    //*
    //* Creates the Logon form.
    //*

    function RecoverForm($options,$formoptions)
    {
        return
            $this->FrameIt
            (
                $this->H(4,"Recuperar Senha: Digite Email").
                //$this->StartForm("","post",0,array(),array("ModuleName")).
                $this->StartForm().
                $this->RecoverTable($formoptions).
                $this->MakeHidden("Logon",1).
                $this->Buttons().
                $this->EndForm()
            ).
            "<P></P>".
            $this->LogonTrailingTable($options).
            "";

    }
}

?>