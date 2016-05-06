<?php

include_once("../class.phpmailer.php");

trait MyEmail 
{
    var $Email_PHPMailer=NULL;

    //*
    //* function ValidEmailAddress, Parameter list: $email
    //*
    //* Checks if $email is a valid email address: \S+@\S+.
    //*

    function ValidEmailAddress($email)
    {
        $email=strtolower($email);

        $res=FALSE;

        $comps=preg_split('/@/',$email);

        if (count($comps)!=2) { $res=FALSE; }
        else
        {
            if (
                  preg_match('/^[a-z0-9\._]+$/',$comps[0])
                  &&
                  preg_match('/^[a-z0-9\._]+$/',$comps[1])
                ) { $res=TRUE; }

            if (!preg_match('/\./',$comps[1])) { $res=FALSE; }
        }

        return $res;
    }

    //*
    //* function EmailInitSMTP, Parameter list: $setup
    //*
    //* Sets email headers.
    //*

    function EmailInitSMTP($setup)
    {
        $this->Email_PHPMailer->IsSMTP();

        //SMTP Authentication
        $this->Email_PHPMailer->SMTPAuth=FALSE; 
        if ($setup[ "Auth" ]==2)
        {
            $this->Email_PHPMailer->SMTPAuth=TRUE;  
            $this->Email_PHPMailer->Username = $setup[ "User" ];  
            $this->Email_PHPMailer->Password = $setup[ "Password" ];
        }

        //Crypted
        if (!empty($setup[ "Secure" ]))
        {
            if ($setup[ "Secure" ]==2)
            {
                $this->Email_PHPMailer->SMTPSecure = 'ssl';
            }
            elseif ($setup[ "Secure" ]==3)
            {
                $this->Email_PHPMailer->SMTPSecure = 'tsl';
            }
        }

        //Port and Host
        $this->Email_PHPMailer->Port     = $setup[ "Port" ];  
        $this->Email_PHPMailer->Host     = $setup[ "Host" ];
        $this->Email_PHPMailer->Hostname = $setup[ "Host" ];
    }

    //*
    //* function MailKey2Recipients, Parameter list: $mailhash,$key
    //*
    //* Detects recipient $key.s.
    //*

    function MailKey2Recipients($mailhash,$key)
    {
        $tos=array();
        if (!empty($mailhash[ $key ]))
        {
            if (!is_array($mailhash[ $key ]))
            {
                $tos=preg_split('/\s*[,;]\s*/',$mailhash[ $key ]);
            }
            else
            {
                $tos=$mailhash[ $key ];
            }
        }

        return $tos;
    }


    //*
    //* function Mail2Recipients, Parameter list: &$mailhash
    //*
    //* Returns hash with To, CC and BCC as lists.
    //*

    function Mail2Recipients(&$mailhash)
    {
        foreach (array("To","CC","BCC") as $key)
        {
            $mailhash[ $key ]=$this->MailKey2Recipients($mailhash,$key);
        }
    }



    //*
    //* function SetEmailHeaders, Parameter list: $mailhash
    //*
    //* Sets email headers.
    //*

    function SetEmailHeaders($mailhash)
    {
        $this->Email_PHPMailer->ContentType="text/html; charset=utf-8";

        $this->Email_PHPMailer->Subject=$mailhash[ "Subject" ];  
   
        $this->Email_PHPMailer->From=$mailhash[ "FromEmail" ];  
        $this->Email_PHPMailer->FromName=$mailhash[ "FromName" ];  
   
        foreach ($mailhash[ "To" ] as $id => $to)
        {
            if (empty($to)) { continue; }
            $this->Email_PHPMailer->AddCC($to);
        }

        foreach ($mailhash[ "CC" ] as $id => $to)
        {
            if (empty($to)) { continue; }
            $this->Email_PHPMailer->AddCC($to);
        }

        foreach ($mailhash[ "BCC" ] as $id => $to)
        {
            if (empty($to)) { continue; }
            $this->Email_PHPMailer->AddBCC($to);
        }

        if (!empty($mailhash[ "ReplyTo" ])) 
        {
            $this->Email_PHPMailer->addReplyTo($mailhash[ "ReplyTo" ]);
        }

        $this->Email_PHPMailer->Body=$mailhash[ "Body" ];
        if (!empty($mailhash[ "AltBody" ]))
        {
            $this->Email_PHPMailer->AltBody=$mailhash[ "AltBody" ];
        }
        else
        {
            $this->Email_PHPMailer->AltBody=$mailhash[ "Body" ];
        }
    }

    //*
    //* function SendEmail, Parameter list: $setup,$mailhash,$attachments=array(
    //*
    //* Wraps the mail sending. Uses logon, if configure to.
    //* 
    //*

    function SendEmail($setup,$mailhash,$attachments=array())
    {
        if (empty($mailhash[ "To" ]) && empty($mailhash[ "BCC" ]) && empty($mailhash[ "CC" ])) { return FALSE; }
        
        $mailhash[ "Subject" ]=utf8_decode($mailhash[ "Subject" ]);

        $mailhash[ "Body" ]=preg_replace('/\n/',"<BR>\n",$mailhash[ "Body" ]);
        $mailhash[ "Body" ]=utf8_decode($mailhash[ "Body" ]);

        $this->Email_PHPMailer = new PHPMailer;

        $this->EmailInitSMTP($setup);
        $this->SetEmailHeaders($mailhash); 

        foreach ($attachments as $id => $attachment)
        {
            $res=$this->Email_PHPMailer->addAttachment($attachment[ "File" ],$attachment[ "Name" ]);
        }

        return $this->Email_PHPMailer->Send();
    }
}
?>