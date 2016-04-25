<?php


class ItemsEmailsAttachmentsCells extends ItemsEmailsAttachmentsUpload
{
    //*
    //* function AttachmentNoCell, Parameter list: $n
    //*
    //* Creates attachment number cell $n.
    //*

    function AttachmentNoCell($n)
    {
        return
            $this->B($n.":",array("ALIGN" => 'center'));
    }

    //*
    //* function AttachmentCell, Parameter list: $n,$attachment
    //*
    //* Creates attachment number cell $n.
    //*

    function AttachmentCell($n,$attachment)
    {
        return
            $this->MakeHidden
           (
              $this->AttachmentFieldNoName($n),
              $attachment[ "Attachment" ]
           );
    }

    //*
    //* function AttachmentFileCell, Parameter list: $n,$attachment
    //*
    //* Creates attachment filename cell $n.
    //*

    function AttachmentFileCell($n,$attachment)
    {
        return
            basename($attachment[ "File" ]).
            $this->MakeHidden
            (
               "File_".$n,
               basename($attachment[ "File" ])
            );
    }

    //*
    //* function AttachmentMIMECell, Parameter list: $n,$attachment
    //*
    //* Creates attachment mime cell $nwrite.
    //*

    function AttachmentMIMECell($n,$attachment)
    {
        return
           " &lt;".
            $attachment[ "MIME" ].
            "&gt;".
           $this->MakeHidden
           (
              "MIME_".$n,
              $attachment[ "MIME" ]
           );
    }


     //*
    //* function AttachmentDelBox, Parameter list: $n
    //*
    //* Creates attachment filename cell $n.
    //*

    function AttachmentDelBox($n)
    {
        return $this->MakeCheckBox("Delete_".$n,1,FALSE);
    }
}

?>