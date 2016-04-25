<?php

include_once("Password/Change.php");
include_once("Password/Recover.php");

class LoginPassword extends LoginPasswordRecover
{
    //*
    //* function IsAValidPassword, Parameter list: $password,&$message
    //*
    //* Tests whether $password is considered a valid password.
    //*

    function IsAValidPassword($password,&$message)
    {
        $res=TRUE;
        if (strlen($password)<8)
        {
            $message=$this->GetMessage($this->LoginMessages,"Error_PasswordNotAccepted");
            $res=FALSE;
        }

        return $res;
    }
}


?>