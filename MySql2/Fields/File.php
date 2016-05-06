<?php

include_once("File/Structure.php");
include_once("File/Update.php");

class FileFields extends FileFieldsUpdate
{
    //*
    //* Variables of Fields class:
    //*

    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function GetUploadPath()
    {
        $path=preg_replace('/#Module/',$this->ModuleName,$this->UploadPath);

        if ($path=="") { return; }

        $path=$this->FilterObject($path);

        $comps=preg_split('/\/+/',$path);
        if (!preg_grep('/'.$this->ModuleName.'/',$comps))
        {
            array_push($comps,$this->ModuleName);
        }


        $path="";
        for ($n=0;$n<count($comps);$n++)
        {
            if ($path!="")
            {
                $path.="/";
            }

            $path.=$comps[$n];

            if (!is_dir($path))
            {
                var_dump("Creating: ".$path);
                mkdir($path);
            }
            
        }

        touch($path."/index.php");
        return $path;
    }

    //*
    //* Returns full (relative) name of uploaded file pertaining to $data.
    //*

    function GetUploadedFileName($data,$item,$ext)
    {
        $uploadpath=$this->GetUploadPath();

        //Make sure we have an index.php, so no-one may list the files
        $index=$uploadpath."/index.php";
        if (!file_exists($index))
        {
            if (is_writable($index))
            {

                $this->MyWriteFile($index,array());
            }
        }

        $uploadpath.="/";
        if ($this->UploadFilesHidden)
        {
            $uploadpath.=".";
        }

        //Make files hidden
        return $uploadpath.$data."_".$item[ "ID" ].".".$ext;
    }

    //*
    //* Show allowed extensions valid for $data.
    //*

    function PermittedFileExtensionsText($data)
    {
        $extensions=$this->FileFieldExtensions($data);

        $text="";
        if (count($extensions)>0)
        {
            $text=
                $this->GetMessage($this->ItemDataMessages,"PermittedFileTypes").
                ": ".
                join(", ",$extensions);
        }

        return $text;
    }

    //* FileFieldSizeInfo
    //* 
    //*

    function FileFieldSizeInfo($item,$data)
    {
        $table=$this->SqlTableName();
        $rdata=$data."_Size";

        $this->MakeSureWeHaveRead("",$item,array($rdata));

        $value=0;
        if (!empty($item[ $rdata ])) { $value=$item[ $rdata ]; }

        return $value." bytes";
    }

    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function FileDownloadHref($item,$data)
    {
        $args=$this->Query2Hash();
        $args=$this->Hidden2Hash($args);
        $this->AddCommonArgs2Hash($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Download";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return "?".$this->Hash2Query($args);        
    }

    //*
    //* Create file field decorator, being a link to download the file
    //*

    function FileFieldDecorator($data,$item,$plural=FALSE,$edit=0)
    {
        return $this->MyMod_Data_Fields_File_Decorator($data,$item,$plural,$edit);
    }
}

?>