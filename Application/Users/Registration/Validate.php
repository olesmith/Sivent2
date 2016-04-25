<?php



class UsersRegistrationValidate extends UsersRegistrationCGI
{
    //*
    //* function ValidateName, Parameter list: $name
    //*
    //* Tests if $name is a name.
    //*

    function ValidateName($name)
    {
        if (preg_match('/\S+/',$name)) { return TRUE; }

        return FALSE;
    }
    //*
    //* function IsValidEmail, Parameter list: $email
    //*
    //* Tests if email is a valid email addres.
    //*

    function IsValidEmail($email)
    {
        $comps=preg_split('/@/',$email);
        if (count($comps)==2)
        {
            $mailname=$comps[0];
            $domain=$comps[1];
            if (
                  preg_match('/^[a-zA-Z0-9\._\-]+$/',$mailname)
                  &&
                  preg_match('/^[a-zA-Z0-9\._\-]+$/',$domain)
               )
            {
                return TRUE;
            }
        }

        return FALSE;
    }


    //*
    //* function EmailIsUnique, Parameter list: $email
    //*
    //* Tests if email is a valid email addres.
    //*

    function EmailIsUnique($email)
    {
        if (
              $this->FriendsObj()->MySqlNEntries
              (
                 "",
                 "LOWER(".$this->Sql_Table_Column_Name_Qualify("Email").")".
                 "=".
                 $this->Sql_Table_Column_Value_Qualify($email)
              )
              +
              $this->FriendsObj()->MySqlNEntries
              (
                 "",
                 "LOWER(".$this->Sql_Table_Column_Name_Qualify("CondEmail").")".
                 "=".
                 $this->Sql_Table_Column_Value_Qualify($email)
              )
           )
        {
            return FALSE;
        }

        return TRUE;
    }

    //*
    //* function TestPasswords, Parameter list: $password
    //*
    //* Tests if password is acceptable.
    //*

    function TestPassword($password)
    {
        if (strlen($password)>=8)
        {
            return TRUE;
        }
        else
        {
            $this->HtmlStatus=$this->GetMessage($this->UsersDataMessages,"ShortPwd");
            $this->RegisterMsgs[ "Pwd1" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "ShortPwd"
            );
        }

        return FALSE;
    }



    //*
    //* function TestPasswords, Parameter list:
    //*
    //* Tests if passwords are identical.
    //*

    function TestPasswords()
    {
        $password1=$this->GetGETOrPOST("Pwd1");
        $password2=$this->GetGETOrPOST("Pwd2");
        
        $message="";
        if ($password1==$password2)
        {
            $res=$this->TestPassword($password1);
            if ($res==TRUE)
            {
                return TRUE;
            }
        }
        else
        {
            $this->RegisterMsgs[ "Pwd1" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "PwdMismatch"
            );
        }

        return FALSE;
    }


    //*
    //* function ValidateRegistration, Parameter list:
    //*
    //* Updates initial Registration.
    //*

    function ValidateRegistration()
    {
        $name=$this->CGI2Name();

        $res=TRUE;
        if (!$this->ValidateName($name))
        {
            $this->RegisterMsgs[ "Name" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "NoNameGiven"
            );

            $res=FALSE;
        }

        if (!$this->TestPasswords())
        {
            /* $this->RegisterMsgs[ "Pwd1" ]=$this->GetMessage */
            /* ( */
            /*    $this->UsersDataMessages, */
            /*    "PwdMismatch" */
            /* ); */

            $res=FALSE;
        }

        $email=$this->CGI2NewEmail();

        if (!$this->IsValidEmail($email))
        {
            $this->RegisterMsgs[ "NewEmail" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "InvalidEmail"
            );

            $res=FALSE;
        }

        if (!$this->EmailIsUnique($email))
        {
            $this->RegisterMsgs[ "NewEmail" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "EmailAlreadyRegistered"
            );

            $res=FALSE;
        }

        return $res;
    }


    //*
    //* function ValidateConfirmation, Parameter list:
    //*
    //* Validates the confirmations
    //*

    function ValidateConfirmation()
    {
        $friend=NULL;

        $email=$this->CGI2NewEmail();
        $code=$this->CGI2ConfirmCode();

        $where=array
        (
         //"Email" => NULL, //make sure we do not mess with confirmed registers!
           "CondEmail" => $email,
           "ConfirmCode" => $code,
        );

        $friend=$this->FriendsObj()->SelectUniqueHash
        (
           "",
           $where,
           TRUE
        );


        if (empty($email) || empty($code) || empty($friend))
        {
            print $this->H(4,$this->GetMessage($this->UsersDataMessages,"InvalidConfirmCode"));

            return FALSE;
        }
        elseif (!empty($friend[ "Email" ]))
        {
            print $this->H(4,$this->GetMessage($this->UsersDataMessages,"InvalidConfirmCode"));

            return FALSE;
        }

        return $friend;
    }


    //*
    //* function ValidateResendConfirmation, Parameter list:
    //*
    //* Validates the confirmations
    //*

    function ValidateResendConfirmation()
    {
        $friend=NULL;

        $email=$this->CGI2NewEmail();

        $where=array
        (
         //"Email" => NULL, //make sure we do not mess with confirmed registers!
           "CondEmail" => $email,
        );

        $friend=$this->FriendsObj()->SelectUniqueHash("",$where,TRUE);
        if (empty($email) || empty($friend))
        {
            $this->RegisterMsgs[ "NewEmail" ]=$this->GetMessage
            (
               $this->UsersDataMessages,
               "InvalidEmail"
            );

            $friend=FALSE;
        }

        return $friend;
    }
}

?>