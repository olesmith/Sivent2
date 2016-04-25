<?php



class UsersRegistrationCells extends UsersRegistrationLeading
{
    //*
    //* function RegistrationNameField, Parameter list: 
    //*
    //* Returns Friend Name input field.
    //*

    function RegistrationNameField()
    {
        return $this->MakeInput
        (
           "Name",
           $this->GetPOST("Name"),
           30
        );
    }


    //*
    //* function RegistrationEmailField, Parameter list: $fieldname="NewEmail",$fieldvalue=""
    //*
    //* Returns Friend Email input field.
    //*

    function RegistrationEmailField($fieldname="NewEmail",$fieldvalue="")
    {
        if (empty($fieldvalue))
        {
            $fieldvalue=$this->CGI2NewEmail();
        }

        return $this->MakeInput($fieldname,$fieldvalue,30);
    }


    //*
    //* function RegistrationPasswordField, Parameter list: $fieldname="Pwd1"
    //*
    //* Returns Friend password input field.
    //*

    function RegistrationPasswordField($fieldname="Pwd1")
    {
        return $this->MakePassword($fieldname,"",10,0,array("AUTOCOMPLETE" => 'off'));
    }

    //*
    //* function RegistrationPasswordFields, Parameter list: 
    //*
    //* Returns Friend password input fields, BR inbetween.
    //*

    function RegistrationPasswordFields()
    {
        return
            $this->RegistrationPasswordField("Pwd1").
            "<BR>".
            $this->RegistrationPasswordField("Pwd2").
            "";
    }


    //*
    //* function RegistrationConfirmField, Parameter list: 
    //*
    //* Returns Friend confirm field.
    //*

    function RegistrationConfirmField()
    {
        return $this->MakeInput
        (
           "ConfirmCode",
           $this->CGI2ConfirmCode(),
           10
         );
    }
}

?>