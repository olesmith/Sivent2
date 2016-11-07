<?php

class ItemsEmailsSend extends ItemsEmailsForm
{
    //*
    //* function FormSendMails, Parameter list: 
    //*
    //* Do acutau sending.
    //*

    function FormSendMails($emails)
    {
        //$this->ApplicationObj->DebugMail=TRUE;

        $this->NAttachments=$this->NAttachmentsFieldValue();

        $files=array();
        for ($n=1;$n<=$this->NAttachments;$n++)
        {
            $file=
                sys_get_temp_dir().
                "/".
                $this->AttachmentFieldNoValue($n);

            if (file_exists($file))
            {
                $file=array
                (
                   "File" => $file,
                   "Name" => $this->GetPOST("File_".$n),
                   "MIME" => $this->GetPOST("MIME_".$n),
                );

                array_push($files,$file);
            }
        }


        foreach (array("FromEmail","FromName") as $data)
        {
            $mailhash[ $data ]=$this->ApplicationObj->MailInfo[ $data ];
        }

        $mailhash[ "ReplyTo" ]=$this->LoginData[ "Email" ];

        $bccs=array();
        foreach (array_keys($emails) as $typekey)
        {
            foreach ($emails[ $typekey ] as $email)
            {
                if ($this->GetPOSTint("Inc_".$email[ "ID" ])==1 || $this->GetPOSTint("Inc_All")==1)
                {
                    array_push($bccs,$email[ "Email" ]);
                }
            }
        }

        if (count($bccs)>0)
        {
            $subject=$this->GetPOST("Subject");
            $subject=preg_replace('/^\s+/',"",$subject);
            $subject=preg_replace('/\s+$/',"",$subject);
            $subject=preg_replace('/\s+/'," ",$subject);

            if (preg_match('/\S/',$subject))
            {
                $body=$this->GetPOST("Body");
                $body=preg_replace('/^\s+/',"",$body);
                $body=preg_replace('/\s+$/',"",$body);
                $body=preg_replace('/\s+/'," ",$body);

                array_push($bccs,$this->ApplicationObj->LoginData[ "Email" ]);
                foreach (array("AdmEmail","BCCEmail") as $key)
                {
                    if (!empty($this->ApplicationObj->MailInfo[ $key ]))
                    {
                        array_push($bccs,$this->ApplicationObj->MailInfo[ $key ]);
                    }
                }

                if (preg_match('/\S/',$body))
                {                
                    $mailhash=array
                    (
                       "To" => "",
                       "FromEmail" => $this->ApplicationObj->MailInfo[ "FromEmail" ],
                       "FromName" => $this->ApplicationObj->HtmlSetupHash[ "ApplicationTitle" ],
                       "CC" => array(),
                       "BCC" => join
                       (
                          ",",
                          $bccs
                       ),
                       "ReplyTo" => $this->ApplicationObj->LoginData[ "Email" ],
                       "Subject" => $this->GetPOST("Subject"),
                       "Body" => $this->GetPOST("Body"),
                       "AltBody" => $this->GetPOST("Body"),
                    );

                    $res= $this->ApplicationObj->ApplicationSendEmail(array(),$mailhash,array(),$files);
                    foreach ($files as $file)
                    {
                        if (file_exists($file[ "File" ])) { unlink($file[ "File" ]); }
                    }

                    return $res;
                }
                else
                {
                    $this->ApplicationObj->EmailStatusMessage="Mensagem sem assunto - não enviada";
                    $this->ApplicationObj->EmailStatus=FALSE;  
                }
            }
            else
            {
                $this->ApplicationObj->EmailStatusMessage="Mensagem sem assunto - não enviada";
                $this->ApplicationObj->EmailStatus=FALSE;  
            }

        }
        else
        {
            $this->ApplicationObj->EmailStatusMessage="Nenhum Recipiente - mensagem não enviada";
            $this->ApplicationObj->EmailStatus=FALSE;  
        }

        echo $this->ApplicationObj->EmailStatusMessage();
    }


    
}
?>