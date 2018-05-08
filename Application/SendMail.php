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
            foreach (array("To","CC","BCC","ReplyTo") as $key)
            {
                if (!is_array($mailhash[ $key ]))
                {
                    $mailhash[ $key ]=array($mailhash[ $key ]);
                }
            }
            
            $table=array();
            if (!empty( $mailhash[ "Subject" ]))
            {
                array_push
                (
                   $table,
                   array
                   (
                      $this->B
                      (
                          $this->MyLanguage_GetMessage("SendMail_Subject").": "
                      ),
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
                      $this->B
                      (
                          $this->MyLanguage_GetMessage("SendMail_To").": "
                      ),
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
                      $this->B
                      (
                          $this->MyLanguage_GetMessage("SendMail_CC").": "
                      ),
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
                      $this->B
                      (
                          $this->MyLanguage_GetMessage("SendMail_BCC").": "
                      ),
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
                      $this->B
                      (
                          $this->MyLanguage_GetMessage("SendMail_Attachment")." ".
                          $n++.":"
                      ),
                      $attachment[ "Name" ],
                    )
                );
            }
            $msg=
                $this->DIV
                (
                    $this->MyLanguage_GetMessage("SendMail_Sent"),
                    array
                    (
                        "CLASS" => 'error',
                    )
                ).
                $this->Html_Table("",$table);
        }

        return $msg;
    }
}


?>