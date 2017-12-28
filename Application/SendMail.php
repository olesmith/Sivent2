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
    
    /* //\* */
    /* //\* function FilterMailField, Parameter list: $field */
    /* //\* */
    /* //\* Filters mail field text over global vars. */
    /* //\* */

    /* function FilterMailField($field,$filters=array()) */
    /* { */
    /*     $filters=array_merge */
    /*     ( */
    /*        $filters, */
    /*        array */
    /*        ( */
    /*            $this->ApplicationObj()->MyApp_Mail_Info_Get(), */
    /*           $this->HtmlSetupHash, */
    /*           $this->CompanyHash */
    /*        ) */
    /*     ); */

    /*     if (method_exists($this,"Unit")) */
    /*     { */
    /*         $unit=$this->Unit(); */
    /*         $runit=array(); */
    /*         foreach ($unit as $key => $value) */
    /*         { */
    /*             $runit[ "Unit_".$key ]=$value; */
    /*         } */
    /*         array_push($filters,$runit); */
    /*     } */

    /*     $field=$this->FilterHashes */
    /*     ( */
    /*        $this->Html2Text($field), */
    /*        $filters */
    /*     ); */

    /*     return $field; */
    /* } */

    /* //\* */
    /* //\* function ApplicationSendEmail, Parameter list: $user,$mailhash,$filters=array(),$attachments=array() */
    /* //\* */
    /* //\* Sends email calling Email::SendEmail. */
    /* //\* Add trailer msg and inserts MailInfo vars into $mailhash. */
    /* //\* */

    /* function  ApplicationSendEmail($user,$mailhash,$filters=array(),$attachments=array()) */
    /* { */
    /*     return $this->MyApp_Email_Send($user,$mailhash,$filters,$attachments); */
    /* } */
 
    /* //\* */
    /* //\* function MailInfo, Parameter list:  */
    /* //\* */
    /* //\* Returns mail info, that is, content of $this->MailInfo. */
    /* //\* Supposed to be overwritten by and ApplicationObj. */
    /* //\* */

    /* function MailInfo() */
    /* { */
    /*     return $this->MailInfo; */
    /* } */
}


?>