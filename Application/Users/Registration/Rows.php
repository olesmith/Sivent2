<?php



class UsersRegistrationRows extends UsersRegistrationCells
{
    //*
    //* function RegistrationNameRow, Parameter list:
    //*
    //* Creates Registration table name row.
    //*

    function RegistrationNameRow()
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"NameFieldName").":"),
               $this->RegistrationNameField(),
               $this->RegisterMsgs[ "Name" ],
            );
    }

    //*
    //* function RegistrationEmailRow, Parameter list: $fieldname="NewEmail",$fieldvalue=""
    //*
    //* Creates Registration table email row.
    //*

    function RegistrationEmailRow($fieldname="NewEmail",$fieldvalue="")
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"EmailFieldName").":"),
               $this->RegistrationEmailField($fieldname,$fieldvalue),
               $this->RegisterMsgs[ $fieldname ],
            );
    }

    //*
    //* function RegistrationPassword1Row, Parameter list:
    //*
    //* Creates Registration table password row.
    //*

    function RegistrationPassword1Row()
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"PasswordFieldName").":"),
               $this->RegistrationPasswordField(),
               $this->RegisterMsgs[ "Pwd1" ],
            );
    }

    //*
    //* function RegistrationPassword2Row, Parameter list:
    //*
    //* Creates Registration table passwords rows.
    //*

    function RegistrationPassword2Row()
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"Password2FieldName").":"),
               $this->RegistrationPasswordField("Pwd2"),
               $this->RegisterMsgs[ "Pwd2" ],
            );
    }

    //*
    //* function RegistrationPasswordsRow, Parameter list:
    //*
    //* Creates Registration table passwords row.
    //*

    function RegistrationPasswordsRow()
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"PasswordFieldName").":"),
               $this->RegistrationPasswordFields(),
               $this->RegisterMsgs[ "Pwd1" ],
            );
    }
    //*
    //* function RegistrationConfirmRow, Parameter list:
    //*
    //* Creates Registration table confirm row.
    //*

    function RegistrationConfirmRow()
    {
        return
            array
            (
               $this->B($this->GetMessage($this->UsersDataMessages,"ConfirmCodeFieldName").":"),
               $this->RegistrationConfirmField(),
               $this->RegisterMsgs[ "ConfirmCode" ],
            );
    }
}

?>