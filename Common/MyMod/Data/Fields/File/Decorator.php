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
        if ($this->LatexMode())
        {
            return $this->MyMod_Data_Fields_File_Decorator_Latex($data,$item,$plural,$edit);
        }
        
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        //If file has been uploaded, print download link and date uploaded

        $this->MakeSureWeHaveRead("",$item,array($data."_Time",$data."_OrigName"));

        $values=array();
        if ($edit==1)
        {
            array_push
            (
                $values,
                $this->MyMod_Data_Fields_File_Extensions_Permitted_Text($data)
            );
        }
        
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

            if (!empty($filetime))
            {
                array_push
                (
                    $values,
                    $this->MyMod_Data_Fields_File_Decorator_Unlink_Link($edit,$item,$data,$value),
                    $this->MyMod_Data_Fields_File_Decorator_Download_Link($edit,$item,$data,$value)
                );
            }
        }
        
        return $values;
    }
    
    
    //*
    //* Create file field decorator, being a link to download the file
    //*

    function MyMod_Data_Fields_File_Decorator_Latex($data,$item,$plural=FALSE)
    {
        $rvalue="-";
        if (!empty($item[ $data ]))
        {
            $value=$item[ $data ];
            $origname=$this->Sql_Select_Hash_Value($item[ "ID" ],$data."_OrigName","ID");
            
            $rvalue=$value;
            if (!empty($origname))
            {
                $destfile=$this->MyMod_Data_Upload_FileName_Get($data,$item,"pdf");

                $filetime="-";
                $filesize="-";
                if (file_exists($destfile))
                {
                    $filetime=$this->TimeStamp2Text(filemtime($destfile));
                    $filesize=filesize($destfile);
                }
                
                $rvalue=
                    basename($origname).": ".
                    $filetime." (".$filesize." bytes)";
            }            
        }
        
        return $rvalue;
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
    
    //* MyMod_Data_Fields_File_Image_Dimensions
    //* 
    //* If we have an image, try to detect image dimensions info.
    //*

    function MyMod_Data_Fields_File_Image_Dimensions($item,$data)
    {
        $info="";
        if ($this->MyMod_Data_Value_Image_Is($item,$data))
        {
            $info="-";
            if (file_exists($item[ $data ]))
            {
                $imginfo=getimagesize($item[ $data ]);
                if (count($imginfo)>2)
                {
                    $info=$imginfo[ 0 ]."x".$imginfo[ 1 ];
                }
            }
        }

        return $info;
    }
    
    //* MyMod_Data_Fields_File_Decorator_Title
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Title($item,$data,$msgkey)
    {
        return
            join
            (
                "\n",
                array
                (
                    $this->MyLanguage_GetMessage($msgkey).": ".$item[ $data ],
                    $this->MyLanguage_GetMessage("File_Original").": ".$item[ $data."_OrigName" ],
                    "Time: ".$this->MyMod_Data_Fields_File_Decorator_Download_TimeStamp($item,$data),
                    "Size: ".$this->MyMod_Data_Fields_File_Decorator_SizeInfo($item,$data),
                    "Dimensions: ".$this->MyMod_Data_Fields_File_Image_Dimensions($item,$data)
                )
            );
    }

}

?>