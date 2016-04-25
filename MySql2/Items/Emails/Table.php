<?php

class ItemsEmailsTable extends ItemsEmailsCells
{
    //*
    //* function SendEmailHtmlTable, Parameter list: $edit,$emails,$attachments
    //*
    //* Creates table for emailing items.
    //*

    function SendEmailHtmlTable($edit,$emails,$attachments)
    {
        $table=
            array
            (
               array
               (
                  $this->B("Para:",array("TITLE" => "BCC/CCO")),
                  $this->RecipientCell($edit,$emails)
               ),
               array
               (
                  $this->B("CC:"),
                  $this->CCCell($edit)
               ),
               array
               (
                  $this->B("De:",array("TITLE" => "Responder para/Reply-to")),
                  $this->LoginData[ "Email" ]
               ),
               array
               (
                  $this->B("Assunto:"),
                  $this->SubjectCell($edit)
               ),
               array
               (
                  $this->B("Mensagem:"),
                  $this->BodyCell($edit),
               ),
            );

        $table=array_merge
        (
           $table,
           $this->AttachmentsRows($edit,$attachments)
        );

        if ($edit==1)
        {
            array_push
            (
               $table,
               array
               (
                  $this->MakeHidden($this->NAttachmentsFieldName(),count($attachments)).
                  $this->MakeButton("submit","Enviar").
                  $this->MakeButton("reset","Resetar")
               )
            );
        }

        return $this->Html_Table("",$table,array("ALIGN" => 'center'),array(),array(),FALSE,FALSE);
    }

    //*
    //* function Emails2Table, Parameter list: $edit,$emails,$ncols,$selected=FALSE,$disabled=FALSE
    //*
    //* Creates table with checkboxes and emails.
    //*

    function Emails2Table($edit,$emails,$ncols,$selected=FALSE,$disabled=FALSE)
    {
        $table=array();
        foreach ($this->PageArray($emails,2) as $remails)
        {
            $row=array();
            foreach ($remails as $email)
            {
                array_push
                (
                   $row,
                   $this->Emails2TableCell($edit,$email,$selected,$disabled)
                );
            }

            array_push($row,"");
            array_push($table,$row);
        }

        $cell="&nbsp;";
        if ($edit==1)
        {
            $cell=
                $this->B("Incluir Todas: ").
                $this->MakeCheckBox("Inc_All",1,$selected,$disabled).
                "";

            array_unshift($table,array($cell));
        }



        return $table;
    }
}
?>