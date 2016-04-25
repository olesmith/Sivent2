<?php



class UsersRegistrationHandle extends UsersRegistrationHandlers
{
    //*
    //* function HandleNewRegistration, Parameter list:
    //*
    //* Will handle a new registration.
    //*

    function HandleNewRegistration()
    {
        $this->MyApp_Interface_Head();
        $options=array
        (
           "ALIGN" => 'center',
           "WIDTH" => '60%',
           "CLASS" => 'activeinfo',
        );

        $poptions=$options;
        $poptions[ "CLASS" ]='inactiveinfo';

        echo
             $this->SystemLeadingTable($poptions).
            "\n<P></P>\n";


        $roptions=$poptions;
        $coptions=$poptions;
        $loptions=$poptions;
        $rroptions=$options;
        $ccoptions=$options;
        $lloptions=$options;

        $action=$this->GetGET("Action");

        if (preg_match('/^(Register|ResendConfirm)$/',$action))
        {
            $roptions=$options;
            $rroptions=$poptions;
        }
        elseif (preg_match('/^(Logon|Recover)$/',$action))
        {
            $loptions=$options;
            $lloptions=$poptions;
        }
        elseif (preg_match('/^(Confirm)$/',$action))
        {
            $coptions=$options;
            $ccoptions=$poptions;
        }

        if ($this->GetGET("Action")=="ResendConfirm")
        {
            $this->HandleResendConfirm($roptions,$rroptions);
        }
        else
        {
            $this->HandleRegistration($roptions,$rroptions);
        }


        $res=$this->HandleConfirm($coptions,$ccoptions);

        if ($this->GetGET("Action")=="Recover")
        {
            $res=$this->HandleRecover($loptions,$lloptions);
        }

        echo $this->SystemTrailingTable($poptions);
    }


    //*
    //* function DoHandleAction, Parameter list: $def,$options,$formoptions
    //*
    //* Handles initial Registration.
    //*

    function DoHandleAction($def,$options,$formoptions)
    {
        $html="";

        $res=0;
        if ($this->GetGET("Action")==$def[ "Action" ])
        {
            $method=$def[ "Leading" ];
            if (!empty($method)) { $html.=$this->$method($options); }

            if ($this->GetPOST($def[ "POST" ])==1)
            {
                $method=$def[ "Validate" ];
                if (!empty($method) && $item=$this->$method())
                {
                    $method=$def[ "Update" ];
                    if (!empty($method)) { $html.=$this->$method($item); }
                    $res=1;
                 }
            }

            $method=$def[ "Form" ];
            if (!empty($method)) { $html.=$this->$method($options,$formoptions); }
        }

        if (!empty($html)) { $html=$this->FrameIt($html,$options)."<P></P>"; }
        echo $html;

        return $res;
    }

    //*
    //* function AddRegistration, Parameter list:
    //*
    //* Updates initial Registration.
    //*

    function AddRegistration()
    {
        $friend=array
        (
           "CondEmail"   => $this->CGI2NewEmail(),
           "Password"    => md5($this->GetGETOrPOST("Pwd1")),
           "Name"        => $this->GetGETOrPOST("Name"),
           "ConfirmCode" => rand(),
           "CTime"       => time(),
           "ATime"       => time(),
           "MTime"       => time(),
        );

        $this->FriendsObj()->MySqlInsertItem("",$friend);

        $friend[ "Email" ]=$friend[ "CondEmail" ];
        $this->SendRegistrationEmail($friend);
    }

    //*
    //* function ConfirmRegistration, Parameter list: $friend
    //*
    //* Updates confirmed Registration.
    //*

    function ConfirmRegistration($friend)
    {
        $email=$friend[ "CondEmail" ];
        $code=$friend[ "ConfirmCode" ];

        $friend[ "Email" ]=$friend[ "CondEmail" ];
        $friend[ "CondEmail" ]="";
        $friend[ "ConfirmCode" ]="";
        $friend[ "MTime" ]=time();
        $friend[ "ATime" ]=time();

        $this->FriendsObj()->Sql_Update_Item
        (
            $friend,
            array 
            (
               "CondEmail"   => $email,
               "ConfirmCode" => $code,
            ),
            array("Email","CondEmail","ConfirmCode","MTime","ATime")
        );

        $this->SendConfirmedEmail($friend);
    }

    //*
    //* function ResendConfirmation, Parameter list: $friend
    //*
    //* Resends confirmation email.
    //*

    function ResendConfirmation($friend)
    {
        $this->SendRegistrationEmail($friend);
    }
}

?>