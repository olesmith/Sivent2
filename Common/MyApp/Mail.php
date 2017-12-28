<?php

trait MyApp_Mail
{
    //*
    //* function MyApp_Mail_Init, Parameter list: 
    //*
    //* Initializes mailing, if no.
    //*

    function MyApp_Mail_Init()
    {
        if ($this->Mail)
        {
            $this->MailInfo=$this->ReadPHPArray($this->MailSetup);
        }
    }

        
    //*
    //* function MyApp_Mail_Init, Parameter list: $key=""
    //*
    //* Initializes mailing, if no.
    //*

    function MyApp_Mail_Info_Get($key="")
    {
        if (empty($this->MailInfo))
        {
            $this->MyApp_Mail_Init();
        }

        if (!empty($key))
        {
            if (!empty($this->MailInfo[ $key ]))
            {
                return $this->MailInfo[ $key ];
            }
            else
            {
                return $key;
            }
        }
        
        return $this->MailInfo;
    }

    
    //*
    //* function MyApp_Email_Hash_Get, Parameter list: $user,$mailhash,$filters=array()
    //*
    //* Sends email calling ApplicationObj::MyApp_Mail_Info_Get.
    //* Add trailer msg and inserts MailInfo vars into $mailhash.
    //*

    function  MyApp_Email_Hash_Get($user,$mailhash,$filters=array())
    {
        $mailhash=$this->MyEmail_Recipients_2_Hash($mailhash);

        if (!empty($user))
        {
            $mailhash[ "To" ]=array($user[ "Email" ]);
            if (empty($user[ "Email" ]) && !empty($user[ "CondEmail" ]))
            {
                $mailhash[ "To" ]=array($user[ "CondEmail" ]);
            }
        }

        $mailinfo=$this->ApplicationObj()->MyApp_Mail_Info_Get();
        foreach (array("FromEmail","FromName") as $data)
        {
            $mailhash[ $data ]=$mailinfo[ $data ];
        }
        
        $mailhash[ "Body" ].=
            "\n-----\n".
            "####################################################################################\n".
            $this->MyLanguage_GetMessage("MailTrailer")."\n".
            "####################################################################################";


        $mailhash=
            $this->MyEmail_Hash_Filters
            (
                $mailhash,
                array("Body","Subject"),
                array_merge
                (
                    array($user),
                    $filters
                )
            );

        
        return $mailhash;
     }

    
    //*
    //* function MyApp_Email_Send, Parameter list: $user,$mailhash,$filters=array(),$attachments=array()
    //*
    //* Sends email calling ApplicationObj::MyApp_Mail_Info_Get.
    //* Add trailer msg and inserts MailInfo vars into $mailhash.
    //*

    function  MyApp_Email_Send($user,$mailhash,$filters=array(),$attachments=array())
    {
        if (!is_array($attachments)) { $attachments=array($attachments); }

        $mailhash=
            $this->MyApp_Email_Hash_Get
            (
                $user,
                $mailhash,
                $filters
            );
        
        $this->EmailStatus=FALSE;

        if (!empty($this->DBHash[ "MailDebug" ]))
        {
            echo 
                "Fake sending...<BR>".
                "To: ".
                 join(",<BR>",$mailhash[ "To" ]).
                "<BR>".
                "CC: ".
                join(",<BR>",$mailhash[ "CC" ]).
                "<BR>".
                "BCC: ".
                join(",<BR>",$mailhash[ "BCC" ]).
                "<BR>".
                "Subject: ".$mailhash[ "Subject" ].
                "<BR>".
                "Body: ".preg_replace('/\n/',"<BR>",$mailhash[ "Body" ]).
                "<BR>".
                "";

            if (!empty($attachments))
            {
                echo
                    "Attachments:".
                    $this->BR().
                    join($this->BR(),$attachments).
                    "";
            }
            $this->EmailStatus=TRUE;
        }
        else
        {
            if ($this->MyEmail_Email_Send($this->MyApp_Mail_Info_Get(),$mailhash,$attachments))
            {
                $this->EmailStatus=TRUE;
            }
            else
            {
                $this->EmailStatusMessage="Erro enviando email: ".$this->Email_PHPMailer->ErrorInfo;
                $this->EmailStatus=FALSE;  
            }

            echo $this->EmailStatusMessage($mailhash,$attachments);
        }

        return $this->EmailStatus;
    }
}

?>