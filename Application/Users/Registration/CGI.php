<?php



class UsersRegistrationCGI extends UsersRegistrationEmail
{
    //*
    //* function CGI2Friend, Parameter list: $item
    //*
    //* Reads Friend according to GET Unit value,
    //* reads into $this->ApplicationObj->Friend.
    //*

    function CGI2Friend()
    {
        $friend=$this->GetGET("Friend");
        if (empty($friend) || !preg_match('/^\d+$/',$friend))
        {
            die("Invalid Friend: ".$friend);
        }

        $this->Friend=$this->SelectUniqueHash
        (
           "",
           array("ID" => $friend)
        );
    }


    //*
    //* function CGI2Name, Parameter list:
    //*
    //* Reads and preprocesses new email.
    //*

    function CGI2Name()
    {
        $name=$this->GetGETOrPOST("Name");
        $name=preg_replace('/^\s*/',"",$name);
        $name=preg_replace('/\s*$/',"",$name);
        $name=preg_replace('/\s+/'," ",$name);

        return $name;
    }

    //*
    //* function CGI2NewEmail, Parameter list:
    //*
    //* Reads and preprocesses new email.
    //*

    function CGI2NewEmail()
    {
        $email=$this->GetGETOrPOST("NewEmail");
        $email=strtolower($email);

        return $email;
    }



    //*
    //* function CGI2ConfirmCode, Parameter list:
    //*
    //* Reads and preprocesses confirm code.
    //*

    function CGI2ConfirmCode()
    {
        return preg_replace
        (
           '/[^\d]+/',
           "",
           $this->GetGETOrPOST("ConfirmCode")
        );
    }

}

?>