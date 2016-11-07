<?php

include_once("Decorator/Download.php");
include_once("Decorator/Unlink.php");

trait MyMod_Data_Fields_File_Decorator
{
    use
        MyMod_Data_Fields_File_Decorator_Download,
        MyMod_Data_Fields_File_Decorator_Unlink;
        
    //*
    //* Create file field decorator, being a link to download the file
    //*

    function MyMod_Data_Fields_File_Decorator($data,$item,$plural=FALSE,$edit=0)
    {
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        //If file has been uploaded, print download link and date uploaded

        $this->MakeSureWeHaveRead("",$item,array($data."_Time",$data."_OrigName"));

        $rvalue="";
        if (!empty($value))
        {
            $filetime="";
            if (!empty($item[ $data."_Time" ]))
            {
                $filetime=$item[ $data."_Time" ];
            }
            elseif (file_exists($value))
            {
                $filetime=filemtime($value);
            }

            $rvalue=$value;
            if (!empty($item[ $data."_OrigName" ]))
            {
                $rvalue=$item[ $data."_OrigName" ];
            }
            
            if (!empty($filetime))
            {
                if (empty($rvalue))
                {
                    $item[ $data."_OrigName" ]=$item[ $data ];
                    $this->MySqlSetItemValues
                    (
                       $this->SqlTableName(),
                       array($data."_OrigName"),
                       $item
                    );
                }
                
               
                $rvalue=
                    " ".
                    $this->MyMod_Data_Fields_File_Decorator_Download_Link($edit,$item,$data,$value).
                    "";
            }
        }
        elseif (!empty($item[ "ID" ]))
        {
            //Try to correct if appears as uploaded...
            $val=strlen($this->Sql_Select_Hash_Value($item[ "ID" ],$data."_Contents"));

            if ($val>0)
            {
                $destfile=$this->MyMod_Data_Upload_FileName_Get($data,$item,"pdf");

                $item[ $data."_OrigName" ]=$destfile;
                $item[ $data."_Size" ]=$val;
                $item[ $data ]=$destfile;

                $this->MySqlSetItemValues
                (
                   $this->SqlTableName(),
                   array($data,$data."_OrigName",$data."_Size"),
                   $item
                );

            }
        }

        return
            $rvalue.
            " ".
            $this->MyMod_Data_Fields_File_Extensions_Permitted_Text($data).
            " ".
            $this->MyMod_Data_Fields_File_Decorator_Unlink_Link($edit,$item,$data,$value).
            "\n";
    }
    
    

    //* FileFieldSizeInfo
    //* 
    //*

    function MyMod_Data_Fields_File_Decorator_SizeInfo($item,$data)
    {
        $file=$item[ $data];
        $filesize=0;
        if (file_exists($file))
        {
            $filesize=filesize($file);
        }

        return $filesize." bytes";
    }
}

?>