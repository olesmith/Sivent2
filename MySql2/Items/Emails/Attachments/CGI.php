<?php

class ItemsEmailsAttachmentsCGI extends ItemsUpdate
{

    //*
    //* function AttachmentFieldName, Parameter list:
    //*
    //* Name of attachment cgi key.
    //*

    function AttachmentFieldName()
    {
        return "Attachment";
    }

    //*
    //* function AttachmentFieldNoName, Parameter list: $n
    //*
    //* Name of attachment cgi key.
    //*

    function AttachmentFieldNoName($n)
    {
        return $this->AttachmentFieldName()."_".$n;
    }
    //*
    //* function AttachmentFieldNoValue, Parameter list: $n
    //*
    //* Name of attachment cgi key.
    //*

    function AttachmentFieldNoValue($n)
    {
        return $this->GetPOST($this->AttachmentFieldNoName($n));
    }

    //*
    //* function NAttachmentsFieldName, Parameter list: 
    //*
    //* Name of number of attachment cgi key.
    //*

    function NAttachmentsFieldName()
    {
        return "N".$this->AttachmentFieldName()."s";
    }

    //*
    //* function NAttachmentsFieldValue, Parameter list: 
    //*
    //* Value of numberof  attachment cgi key.
    //*

    function NAttachmentsFieldValue()
    {
        if (!isset($_POST[ $this->NAttachmentsFieldName() ])) { return 0; }

        return $this->GetPOSTint($this->NAttachmentsFieldName());
    }

    //*
    //* function CGI2Attachments, Parameter list: 
    //*
    //* Returns list of attachments.
    //*

    function CGI2Attachments()
    {
        $attachments=array();

        for ($n=1;$n<=$this->NAttachmentsFieldValue();$n++)
        {
            $attachments[ $n ]=array
            (
               "Attachment" => $this->GetPOST("Attachment_".$n),
               "File"       => $this->GetPOST("File_".$n),
               "MIME"       => $this->GetPOST("MIME_".$n),
            );
        }

        return $attachments;
    }


    //*
    //* function AddAttachmentEntry, Parameter list: 
    //*
    //* If new attachment is defined, attachment.
    //*

    function AddAttachmentEntry()
    {
        if (
              !empty($_FILES[ $this->AttachmentFieldName() ])
              &&
              !empty($_FILES[ $this->AttachmentFieldName() ][ 'tmp_name' ])
           )
        {
            $uploadinfo=$_FILES[ $this->AttachmentFieldName() ];
            if($this->TestAttachmentFile())
            {
                $mimetype=$this->AttachmentFileMIMEType();
                $name=basename($_FILES[ $this->AttachmentFieldName() ]['name' ]);
                $destname=$this->MoveAttachmentFile();

                return array
                (
                   "Attachment" => $destname,
                   "File"        => $name,
                   "MIME"        => $mimetype,
                );
            }
            else
            {
                //error
            }

        }

        return array();
    }

    //*
    //* function DelAttachmentEntries, Parameter list: &$attachments
    //*
    //* Deletes attachments according to CGI
    //*

    function DelAttachmentEntries(&$attachments=array())
    {
        $rattachments=array();

        $deleted=FALSE;
        foreach (array_keys($attachments) as $n)
        {
            if ($this->GetPOSTint("Delete_".$n)==1)
            {
                $file=
                    sys_get_temp_dir().
                    "/".
                    $attachments[ $n ][ "Attachment" ];

                if (
                      file_exists($file)
                      &&
                      !empty($attachments[ $n ][ "Attachment" ])
                   ) { unlink($file); }
                $deleted=FALSE;
            }
            else
            {
                array_push($rattachments,$attachments[ $n ]);
            }
        }

        $attachments=$rattachments;

        return $deleted;
    }

}

?>