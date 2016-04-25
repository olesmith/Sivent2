<?php


include_once("Registration/Email.php");
include_once("Registration/CGI.php");
include_once("Registration/Validate.php");
include_once("Registration/Trailing.php");
include_once("Registration/Leading.php");
include_once("Registration/Cells.php");
include_once("Registration/Rows.php");
include_once("Registration/Tables.php");
include_once("Registration/Forms.php");
include_once("Registration/Register.php");
include_once("Registration/Confirm.php");
include_once("Registration/Handlers.php");
include_once("Registration/Handle.php");

class AppUsersRegistration extends UsersRegistrationHandle
{
    var $RegisterMsgs=array
    (
       "Name"        => "",
       "Login"       => "",
       "Password"     => "",
       "NewEmail"    => "",
       "Pwd1"        => "",
       "Pwd2"        => "",
       "ConfirmCode" => "",
       "Recover_Login" => "",
    );

    var $Registration=array
    (
       "Leading"     => "RegistrationLeadingTable",
       "Action"      => "Register",
       "POST"        => "Register",
       "Validate"    => "ValidateRegistration",
       "Update"      => "AddRegistration",
       "Form"        => "RegistrationForm",
       "Alternative" => "RegistrationLinks",
    );
    var $ResendConfirmation=array
    (
       "Leading"     => "ResendConfirmationLeadingTable",
       "Action"      => "ResendConfirm",
       "POST"        => "Resend",
       "Validate"    => "ValidateResendConfirmation",
       "Update"      => "ResendConfirmation",
       "Form"        => "ResendConfirmRegistrationForm",
       "Alternative" => "ResendConfirmationLinks",
    );
    var $Confirm=array
    (
       "Leading"     => "ConfirmationLeadingTable",
       "Action"      => "Confirm",
       "POST"        => "Confirm",
       "Validate"    => "ValidateConfirmation",
       "Update"      => "ConfirmRegistration",
       "Form"        => "ConfirmRegistrationForm",
       "Alternative" => "ConfirmationLinks",
    );
    var $Logon=array
    (
       "Leading"     => "LogonLeadingTable",
       "Action"      => "Logon",
       "POST"        => "Logon",
       "Validate"    => "",
       "Update"      => "",
       "Form"        => "LogonForm",
       "Alternative" => "LogonRecover",
    );
    var $Recover=array
    (
       "Leading"     => "LogonLeadingTable",
       "Action"      => "Recover",
       "POST"        => "Recover",
       "Validate"    => "",
       "Update"      => "",
       "Form"        => "RecoverForm",
       "Alternative" => "",
    );
    var $UsersDataMessages="Users.php";
}

?>