<?php


class ItemsEmailsAttachmentsRow extends ItemsEmailsAttachmentsCells
{
    //*
    //* function AttachmentTitles, Parameter list: $edit
    //*
    //* Creates attachments title row.
    //*

    function AttachmentTitles($edit)
    {
        $row=array("Anexos","Arquivo","Tipo");
        if ($edit==1)
        {
            array_push
            (
               $row,
               "Remover"
            );
        }

        return array
        (
           "TitleRow" => TRUE,
           "Class" => 'head',
           "Row" => $row,
        );
    }

    //*
    //* function AttachmentRow, Parameter list: $edit,$n,$attachment
    //*
    //* Creates last/new attachment row. 
    //* Reads cgi data from VAR_$nread, displays (writes to) $nwrite.
    //* Necessaru when deleting attachments.
    //*

    function AttachmentRow($edit,$n,$attachment)
    {
        $row=array
        (
           $this->AttachmentNoCell($n).
           $this->AttachmentCell($n,$attachment),
           $this->AttachmentFileCell($n,$attachment),
           $this->AttachmentMIMECell($n,$attachment)
        );

        if ($edit==1)
        {
            array_push
            (
               $row,
               $this->AttachmentDelBox($edit,$n)
            );
        }

        return $row;
    }

    //*
    //* function NewAttachmentRow, Parameter list: $n
    //*
    //* Creates last/new attachment row.
    //*

    function NewAttachmentRow($n)
    {
        return array
        (
           $this->AttachmentNoCell($n),
           $this->MakeFileField($this->AttachmentFieldName()),
           "",""
        );
    }
}

?>