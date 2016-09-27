<?php

class SendMail extends LeftMenu
{
    var $EmailStatus=TRUE;
    var $EmailStatusMessage="";


    //*
    //* function EmailStatusMessage, Parameter list: $mailhash=array(),$attachments=array()
    //*
    //* Returns formatted EmailStatus.
    //*

    function  EmailStatusMessage($mailhash=array(),$attachments=array())
    {
        $msg=$this->DIV($this->EmailStatusMessage,array("CLASS" => 'error'));
        if ($this->EmailStatus)
        {
            $table=array();
            if (!empty( $mailhash[ "Subject" ]))
            {
                array_push
                (
                   $table,
                   array
                   (
                      $this->B("Assunto:"),
                      $mailhash[ "Subject" ],
                   )
                );
            }
            if (!empty( $mailhash[ "To" ]))
            {
                array_push
                (
                   $table,
                   array
                   (
                      $this->B("Para:"),
                      join(";",$mailhash[ "To" ]),
                   )
                );
            }

            if (!empty( $mailhash[ "CC" ]))
            {
                array_push
                (
                   $table,
                   array
                   (
                      $this->B("CC:"),
                      join(";",$mailhash[ "CC" ]),
                   )
                );
            }

            if (!empty( $mailhash[ "BCC" ]))
            {
                $msg.=
                array_push
                (
                   $table,
                   array
                   (
                      $this->B("CCO:"),
                      join(";",$mailhash[ "BCC" ]),
                    )
                );
            }

            $n=1;
            foreach ($attachments as $attachment)
            {
                array_push
                (
                   $table,
                   array
                   (
                      $this->B("Anexo ".$n++.":"),
                      $attachment[ "Name" ],
                    )
                );
            }
            $msg=
                $this->DIV("Mensagem Enviado com Êxito.",array("CLASS" => 'error')).
                $this->Html_Table("",$table);
        }

        return $msg;
    }
    
    //*
    //* function FilterMailField, Parameter list: $field
    //*
    //* Filters mail field text over global vars.
    //*

    function FilterMailField($field,$filters=array())
    {
        $filters=array_merge
        (
           $filters,
           array
           (
              $this->MailInfo,
              $this->HtmlSetupHash,
              $this->CompanyHash
           )
        );

        if (method_exists($this,"Unit"))
        {
            $unit=$this->Unit();
            $runit=array();
            foreach ($unit as $key => $value)
            {
                $runit[ "Unit_".$key ]=$value;
            }
            array_push($filters,$runit);
        }

        $field=$this->FilterHashes
        (
           $this->Html2Text($field),
           $filters
        );

        return $field;
    }

    //*
    //* function ApplicationSendEmail, Parameter list: $user,$mailhash,$filters=array(),$attachments=array()
    //*
    //* Sends email calling Email::SendEmail.
    //* Add trailer msg and inserts MailInfo vars into $mailhash.
    //*

    function  ApplicationSendEmail($user,$mailhash,$filters=array(),$attachments=array())
    {
        if (!is_array($attachments)) { $attachments=array($attachments); }
        
        $this->Mail2Recipients($mailhash);

        if (!empty($user))
        {
            $mailhash[ "To" ]=array($user[ "Email" ]);
            if (empty($user[ "Email" ]) && !empty($user[ "CondEmail" ]))
            {
                $mailhash[ "To" ]=array($user[ "CondEmail" ]);
            }
        }
        
        foreach (array("FromEmail","FromName") as $data)
        {
            $mailhash[ $data ]=$this->MailInfo[ $data ];
        }
        
        $mailhash[ "Body" ].=
            "\n-----\n".
            "####################################################################################\n".
            $this->MyLanguage_GetMessage("MailTrailer")."\n".
            "####################################################################################";

        $filters=array_merge
        (
           array($user),
           $filters
        );

        foreach (array("Body","Subject") as $data)
        {
            $mailhash[ $data ]=$this->FilterMailField($mailhash[ $data ],$filters);
        }
        
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
            if ($this->SendEmail($this->MailInfo(),$mailhash,$attachments))
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
 
    //*
    //* function MailInfo, Parameter list: 
    //*
    //* Returns mail info, that is, content of $this->MailInfo.
    //* Supposed to be overwritten by and ApplicationObj.
    //*

    function MailInfo()
    {
        return $this->MailInfo;
    }
}


?>