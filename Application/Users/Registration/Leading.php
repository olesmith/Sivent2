<?php



class UsersRegistrationLeading extends UsersRegistrationTrailing
{
    var $RegistrationSystemPaths=array("../Application/System/Users/Registration");

    //*
    //* function ReadRegistrationTable, Parameter list: $options
    //*
    //* Reads system registration table.
    //*

    function ReadRegistrationTable($file)
    {
        $lang=$this->MyLanguage_GetLanguageKey();
        foreach ($this->RegistrationSystemPaths as $path)
        {
            $rfile=preg_replace('/\.php$/',"",$file);
            
            $rfile=$path."/".$rfile.$lang.".php";
            if (!file_exists($rfile))
            {
                $rfile=$path."/".$file;
            }

            if (file_exists($rfile))
            {
                return
                    $this->Filter
                    (
                       $this->ReadPHPText($rfile),
                       $this->HtmlSetupHash
                    ).
                    "";
            }

            return "No such ".$rfile;
        }

        return "No such ".$file;
    }

    //*
    //* function SystemLeadingTable, Parameter list: $options
    //*
    //* Prints initial registration info, pertaining to SiMon.
    //*

    function SystemLeadingTable($options)
    {
        return
            $this->ReadRegistrationTable("System/Leading.php");
    }


    //*
    //* function RegistrationLeadingTable, Parameter list: $options
    //*
    //* Generates leading Registration table.
    //*

    function RegistrationLeadingTable($options)
    {
        return
            $this->H(2,$this->GetRealNameKey($this->Actions[ "Register" ],"Title")).
            $this->ReadRegistrationTable("Registration/Leading.php");
            "";
    }
    //*
    //* function ConfirmationLeadingTable, Parameter list: $options
    //*
    //* Creates leading table info of the Confirm Registration form.
    //*

    function ConfirmationLeadingTable($options)
    {
        return
            $this->H(2,$this->GetRealNameKey($this->Actions[ "Confirm" ],"Title")).
            $this->ReadRegistrationTable("Confirm/Leading.php");
            "";
    }

    //*
    //* function ResendConfirmationLeadingTable, Parameter list: $options
    //*
    //* Creates leading table info of the resend Confirmation form.
    //*

    function ResendConfirmationLeadingTable($options)
    {
         return
            $this->RegistrationLeadingTable($options).
            $this->H(2,$this->GetRealNameKey($this->Actions[ "ResendConfirm" ],"Title")).
            "";
    }


    //*
    //* function LogonLeadingTable, Parameter list: $options
    //*
    //* Creates leading table info of the resend Confirmation form.
    //*

    function LogonLeadingTable($options)
    {
         return
            $this->H(2,$this->GetRealNameKey($this->Actions[ "Logon" ],"Title")).
            $this->ReadRegistrationTable("Logon/Leading.php");
            "";
    }



    //*
    //* function RegistrationLinks, Parameter list: $options
    //*
    //* Creates alternatives for Logon
    //*

    function RegistrationLinks($options)
    {
         return
                $this->HtmlTable
                (
                   "",
                   array
                   (
                      $this->HtmlList
                      (
                         array
                         (
                            $this->MyActions_Entry("Register"),
                            $this->MyActions_Entry("Confirm"),
                            $this->MyActions_Entry("ResendConfirm"),
                         )
                      ),
                   ),
                   $options
                 );
    }

    //*
    //* function ConfirmationLinks, Parameter list: $options
    //*
    //* Creates alternatives for Logon
    //*

    function ConfirmationLinks($options)
    {
         return
                $this->HtmlTable
                (
                   "",
                   array
                   (
                      $this->HtmlList
                      (
                         array
                         (
                            $this->MyActions_Entry("Register"),
                            $this->MyActions_Entry("Confirm"),
                            $this->MyActions_Entry("ResendConfirm"),
                         )
                      ),
                   ),
                   $options
                 );
    }

    //*
    //* function LogonRecover, Parameter list: $options
    //*
    //* Creates alternatives for Logon
    //*

    function LogonRecover($options)
    {
         return
                $this->HtmlTable
                (
                   "",
                   array
                   (
                      $this->HtmlList
                      (
                         array
                         (
                            $this->MyActions_Entry("Logon"),
                            $this->MyActions_Entry("Recover"),
                         )
                      ),
                   ),
                   $options
                 );
    }


    //*
    //* function ResendConfirmationLinks, Parameter list: $options
    //*
    //* Creates alternatives for resend confirmation
    //*

    function ResendConfirmationLinks($options)
    {
         return
                $this->HtmlTable
                (
                   "",
                   array
                   (
                      $this->Htmls_List
                      (
                         array
                         (
                            $this->MyActions_Entry("Confirm"),
                            $this->MyActions_Entry("Logon"),
                         )
                      ),
                   ),
                   $options
                 );
    }
}

?>