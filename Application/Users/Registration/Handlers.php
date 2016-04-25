<?php



class UsersRegistrationHandlers extends UsersRegistrationConfirm
{
    //*
    //* function HandleRegistration, Parameter list: $options=array(),$formoptions=array()
    //*
    //* Handles initial Registration.
    //*

    function HandleRegistration($options=array(),$formoptions=array())
    {
        return $this->DoHandleAction($this->Registration,$options,$formoptions);

    }

    //*
    //* function HandleResendConfirm, Parameter list: $options,$formoptions
    //*
    //* Handle Registration resend confirmation code.
    //*

    function HandleResendConfirm($options,$formoptions)
    {
        return $this->DoHandleAction($this->ResendConfirmation,$options,$formoptions);
    }


    //*
    //* function HandleConfirm, Parameter list: $options,$formoptions
    //*
    //* Handles initial Registration.
    //*

    function HandleConfirm($options,$formoptions)
    {
        return $this->DoHandleAction($this->Confirm,$options,$formoptions);
    }
}

?>