<?php


include_once("libphp-phpmailer/class.phpmailer.php");
include_once("libphp-phpmailer/class.smtp.php");
#include_once("libphp-phpmailer/class.pop3.php");

include_once("MyEmail/Recipients.php");
include_once("MyEmail/Filters.php");

trait MyEmail 
{
    use
       MyEmail_Recipients,
       MyEmail_Filters;
    
    var $Email_PHPMailer=NULL;

    //*
    //* function MyEmail_Address_Valid, Parameter list: $email
    //*
    //* Checks if $email is a valid email address: \S+@\S+.
    //*

    function MyEmail_Address_Valid($email)
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
    //* function MyEmail_Email_SMTP_Init, Parameter list: $setup
    //*
    //* Inits SMTP conversation
    //*

    function MyEmail_Email_SMTP_Init($setup)
    {
        $this->Email_PHPMailer->IsSMTP();

        //SMTP Authentication
        $this->Email_PHPMailer->SMTPAuth=FALSE;
        if (!empty($setup[ "Auth" ]))
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
    //* function MyEmail_Email_Headers_Set, Parameter list: $mailhash
    //*
    //* Sets email headers.
    //*

    function MyEmail_Email_Headers_Set($mailhash)
    {
        $this->Email_PHPMailer->ContentType="text/html; charset=utf-8";

        $this->Email_PHPMailer->Subject=$mailhash[ "Subject" ];  
   
        $this->Email_PHPMailer->From=$mailhash[ "FromEmail" ];  
        $this->Email_PHPMailer->FromName=$mailhash[ "FromName" ];  

        foreach (array("To","CC","BCC","ReplyTo",) as $key )
        {
            if (!is_array($mailhash[ $key ]))
            {
                $mailhash[ $key ]=array($mailhash[ $key ]);
            }
        }
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

        foreach ($mailhash[ "BCC" ] as $id => $rto)
        {
           $this->Email_PHPMailer->addReplyTo($rto);
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
    //* function MyEmail_Email_Send, Parameter list: $setup,$mailhash,$attachments=array(
    //*
    //* Wraps the mail sending.
    //* 
    //*

    function MyEmail_Email_Send($setup,$mailhash,$attachments=array())
    {
        if (empty($mailhash[ "To" ]) && empty($mailhash[ "BCC" ]) && empty($mailhash[ "CC" ])) { return FALSE; }
        
        $mailhash[ "Subject" ]=utf8_decode($mailhash[ "Subject" ]);

        $mailhash[ "Body" ]=preg_replace('/\n/',"<BR>\n",$mailhash[ "Body" ]);
        $mailhash[ "Body" ]=utf8_decode($mailhash[ "Body" ]);

        $this->Email_PHPMailer = new PHPMailer;

        $this->MyEmail_Email_SMTP_Init($setup);
        $this->MyEmail_Email_Headers_Set($mailhash); 

        foreach ($attachments as $id => $attachment)
        {
            $res=$this->Email_PHPMailer->addAttachment($attachment[ "File" ],$attachment[ "Name" ]);
        }

        $res=$this->Email_PHPMailer->Send();

        if (!$res)
        {
            echo "Mailer Error: " . $this->Email_PHPMailer->ErrorInfo;
            var_dump($res);
        }
        
        return $res;
    }
    
    //*
    //* function MyEmail_Mail_Comp_Get, Parameter list: $key
    //*
    //* Returns unit mail leader.
    //* 
    //*

    function MyEmail_Mail_Comp_Get($key)
    {
        $unit=$this->Unit();
        
        return
            $this->FilterHash
            (
               $this->GetRealNameKey($unit,$key).
               "",
               $unit,
               "Unit_"
            );
               
    }
    //*
    //* function MyEmail_Mail_Head_Get, Parameter list: 
    //*
    //* Returns unit mail leader.
    //* 
    //*

    function MyEmail_Mail_Head_Get()
    {
        return
            $this->MyEmail_Mail_Comp_Get("MailHead").
            "\n\n".
            "";
    }
    
    //*
    //* function MyEmail_Mail_Tail_Get, Parameter list: 
    //*
    //* Returns unit mail trailer.
    //* 
    //*

    function MyEmail_Mail_Tail_Get()
    {
        return $this->MyEmail_Mail_Comp_Get("MailTail");
    }
 }
?>