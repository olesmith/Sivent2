<?php

include_once("Attachments/CGI.php");
include_once("Attachments/Upload.php");
include_once("Attachments/Cells.php");
include_once("Attachments/Row.php");

class ItemsEmailsAttachments extends ItemsEmailsAttachmentsRow
{
    //*
    //* function AttachmentsRows, Parameter list: $edit,$attachments 
    //*
    //* Creates rows with attachments.
    //*

    function AttachmentsRows($edit,$attachments)
    {
        $rows=array();
        array_push
        (
           $rows,
           $this->AttachmentTitles($edit)
        );

        $n=1;
        foreach (array_keys($attachments) as $k)
        {
            array_push
            (
               $rows,
               $this->AttachmentRow($edit,$n,$attachments[ $k ])
            );
            $n++;
        }

        if ($edit==1)
        {
            array_push
            (
               $rows,
               $this->NewAttachmentRow(count($attachments)+1)
            );
        }

        return $rows;
    }

}

?>