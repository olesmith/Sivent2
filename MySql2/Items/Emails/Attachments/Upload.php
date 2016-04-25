<?php

class ItemsEmailsAttachmentsUpload extends ItemsEmailsAttachmentsCGI
{
    //*
    //* function TestAttachmentFile, Parameter list:
    //*
    //* Tests validity of uploaded file.
    //*

    function TestAttachmentFile()
    {
        $res=TRUE;
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (
              !isset($_FILES[ $this->AttachmentFieldName() ]['error'])
              ||
              is_array($_FILES[ $this->AttachmentFieldName() ]['error'])
           )
        {
            $this->Message='Invalid parameters.';
            $res=FALSE;
        }

        // Check $_FILES['upfile']['error'] value.
        switch ($_FILES[ $this->AttachmentFieldName() ]['error'])
        {
           case UPLOAD_ERR_OK:
               break;
           case UPLOAD_ERR_NO_FILE:
               $this->Message='No file sent.';
               $res=FALSE;
           case UPLOAD_ERR_INI_SIZE:
           case UPLOAD_ERR_FORM_SIZE:
               $this->Message='Exceeded filesize limit.';
               $res=FALSE;
           default:
               $this->Message='Unknown errors.';
               $res=FALSE;
        }

        // You should also check filesize here.
        if ($_FILES[ $this->AttachmentFieldName() ]['size'] > 1000000)
        {
            $this->Message='Exceeded filesize limit.';
            $res=FALSE;
        }

        return $res;
    }


    //*
    //* function AttachmentFileMIMEType, Parameter list:
    //*
    //* Detect upload file MIME type..
    //*

    function AttachmentFileMIMEType()
    {
        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->file($_FILES[ $this->AttachmentFieldName() ]['tmp_name']);
    }

    //*
    //* function AttachmentFileTempName, Parameter list:
    //*
    //* Generate temp name for upload file.
    //*

    function AttachmentFileTempName()
    {
        return
            sys_get_temp_dir().
            "/".
            getmypid().
            rand();
    }

    //*
    //* function MoveAttachmentFile, Parameter list:
    //*
    //* Generate temp name and move upload file.
    //*

    function MoveAttachmentFile()
    {
        $srcname=$_FILES[ $this->AttachmentFieldName() ]['tmp_name' ];
        $destname=$this->AttachmentFileTempName();

        move_uploaded_file($srcname,$destname);

        return basename($destname);
    }

}

?>