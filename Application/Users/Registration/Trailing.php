<?php



class UsersRegistrationTrailing extends UsersRegistrationValidate
{
    //*
    //* function SystemTrailingTable, Parameter list: $options
    //*
    //* Prints trailing registration info, pertaining to System.
    //*

    function SystemTrailingTable($options)
    {
        return
            $this->ReadRegistrationTable("System/Trailing.php");
        //"\n<P></P>\n";
    }
    //*
    //* function RegistrationTrailingTable, Parameter list: $options
    //*
    //* Creates trailing table info of the Confirm Registration form.
    //*

    function RegistrationTrailingTable($options)
    {
         return
            $this->ReadRegistrationTable("Registration/Trailing.php");
            "";
    }

    //*
    //* function ConfirmationTrailingTable, Parameter list: $options
    //*
    //* Creates trailing table info of the Confirm Registration form.
    //*

    function ConfirmationTrailingTable($options)
    {
         return
            $this->ReadRegistrationTable("Confirm/Trailing.php");
            "";
    }

    //*
    //* function LogonTrailingTable, Parameter list: $options
    //*
    //* Creates trailing table info of the Logon form.
    //*

    function LogonTrailingTable($options)
    {
         return
            $this->ReadRegistrationTable("Logon/Trailing.php");
            "";
    }
}

?>