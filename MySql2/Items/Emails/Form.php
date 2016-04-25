<?php

class ItemsEmailsForm extends ItemsEmailsTable
{
    //*
    //* function EmailsSearchForm, Parameter list: $fixedvars=array()
    //*
    //* Email oriented search form.
    //*

    function EmailsSearchForm($fixedvars=array())
    {
        return 
            $this->SearchVarsTable
            (
               array("Paging","DataGroups"),
               "",
               "Emails", //action
               array(),
               $fixedvars
            ).
            $this->BR();
    }

    //*
    //* function SendEmailForm, Parameter list: $where=array(),$friendkeys=array("Friend"),$fixedvars=array()
    //*
    //* Creates form for emailing items.
    //*

    function SendEmailForm($edit,$rwhere=array(),$friendkeys=array("Friend"),$fixedvars=array())
    {
        if (!is_array($friendkeys)) { $friendkeys=array($friendkeys); }

        $emails=$this->ReadEmails($rwhere,$friendkeys);
        $attachments=$this->CGI2Attachments();

        $msg="Enviar Mensagem";

        $attachment=$this->AddAttachmentEntry();

        $addedattachment=FALSE;
        $res=FALSE;

        if (!empty($attachment))
        {
            array_push($attachments,$attachment);
            $addedattachment=FALSE;
        }
        else
        {
            $del=$this->DelAttachmentEntries($attachments);

            if (!$del && $this->GetPOSTint("Send")==1)
            {
                $res=$this->FormSendMails($emails);
                if ($res)
                {
                    $edit=0;
                    $msg="Mensagem Enviado";
                }
                else
                {
                    $msg="Erro enviando Mensagem";
                }
            }
        }

        $html=
            $this->EmailsSearchForm($fixedvars).
            $this->H(2,$msg);

        if ($edit==1)
        {
            $html.=
                $this->StartForm().
                "";
        }

        $html.=
            $this->SendEmailHtmlTable($edit,$emails,$attachments).
            "";

        if ($edit==1)
        {
            $html.=
                join("",$this->SearchVarsAsHiddens()).
                $this->MakeHidden($this->ModuleName."_IncludeAll",$this->CGI2IncludeAll()).
                $this->MakeHidden("Send",1).
                $this->EndForm().
                "";
        }

        return $html;
    }
 }
?>