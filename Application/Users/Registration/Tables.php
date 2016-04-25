<?php



class UsersRegistrationTables extends UsersRegistrationRows
{
    //*
    //* function RegistrationTable, Parameter list: $options
    //*
    //* Creates the Registration table.
    //*

    function RegistrationTable($options)
    {
        return
            $this->Html_Table
            (
               "",
               array
               (
                   $this->RegistrationNameRow(),
                   $this->RegistrationEmailRow(),
                   $this->RegistrationPassword1Row(),
                   $this->RegistrationPassword2Row(),
               ),
               $options
            ).
            "<BR>".
            "";
    }


    //*
    //* function ResendConfirmRegistrationTable, Parameter list: $options
    //*
    //* Creates the resend Confirm Registration table.
    //*

    function ResendConfirmRegistrationTable($options)
    {
        return
            $this->HtmlTable
            (
               "",
               array
               (
                   $this->RegistrationEmailRow(),
               ),
               $options
            ).
            "<BR>".
            "";

    }

    //*
    //* function ConfirmRegistrationTable, Parameter list: $options
    //*
    //* Creates the Confirm Registration form.
    //*

    function ConfirmRegistrationTable($options)
    {
        return
            $this->HtmlTable
            (
               "",
               array
               (
                   $this->RegistrationEmailRow(),
                   $this->RegistrationConfirmRow(),
               ),
               $options
            ).
            "<BR>".
            "";
    }

    //*
    //* function LogonTable, Parameter list: $options
    //*
    //* Creates logon table.
    //*

    function LogonTable($options)
    {
        return
            $this->HtmlTable
            (
               "",
               array
               (
                   $this->RegistrationEmailRow("Login"),
                   $this->RegistrationPasswordRow(),
               ),
               $options
            ).
            "<BR>".
            "";
    }


    //*
    //* function RecoverTable, Parameter list: $options
    //*
    //* Creates recover table.
    //*

    function RecoverTable($options)
    {
        return
            $this->HtmlTable
            (
               "",
               array
               (
                $this->RegistrationEmailRow("Recover_Login",$this->GetGET("Email")),
                "bbbb"
               ),
               $options
            ).
            "<BR>".
            "";
    }
}

?>