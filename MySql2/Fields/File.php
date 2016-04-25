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
                    $rvalue=$item[ $data ];
                    $item[ $data."_OrigName" ]=$rvalue;
                    $this->MySqlSetItemValues
                    (
                       $this->SqlTableName(),
                       array($data."_OrigName"),
                       $item
                    );
                }
                

                $src="";
                $name="";
                if (!empty($this->ItemData[ $data ][ "Icon" ]))
                {
                    $icon="icons/".$this->ItemData[ $data ][ "Icon" ];
                    if (file_exists($icon))
                    {
                        $name=$this->IMG
                        (
                           "icons/".$this->ItemData[ $data ][ "Icon" ],
                           $item [ $data."_OrigName" ],
                           20,20
                        );
                    }
                    else
                    {
                        $name=$item [ $data."_OrigName" ];
                    }
                    
                    $src=$this->FileDownloadHref($item,$data);
                }
                elseif (!empty($this->ItemData[ $data ][ "Iconify" ]))
                {
                    $ext=preg_split('/\./',$rvalue);
                    $ext=array_pop($ext);

                    $src=$this->GetUploadedFileName($data,$item,$ext);
                    $name=$this->IMG
                    (
                       $src,
                       $item [ $data."_OrigName" ],
                       20,20
                    );
                }
                else
                {
                    $name=$rvalue;
                    $src=$this->FileDownloadHref($item,$data);
                }

                $title=
                    "Carregado: ".
                    $this->TimeStamp2Text($filetime,FALSE).
                    " (".
                    $this->FileFieldSizeInfo($item,$data).
                    ")";

                if ($edit==1)
                {
                    $title.=
                        " ".
                        $this->PermittedFileExtensionsText($data);                
                }
               
                $rvalue=" ".$this->A
                (
                   $src,
                   $name,
                   array
                   (
                      "CLASS" => "uploadmsg",
                      "TITLE" =>
                      preg_replace('/<BR>/',"\n",$title)
                   )
                );
            }
            else
            {
                $rvalue.="- '".$value."' non-existent";
            }
        }
        elseif (!empty($item[ "ID" ]))
        {
            //Try to correct if appeas as uploaded...
            $val=strlen($this->Sql_Select_Hash_Value($item[ "ID" ],$data."_Contents"));

            if ($val>0)
            {
                $destfile=$this->GetUploadedFileName($data,$item,"pdf");

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

        return $rvalue."\n";
    }

    //*
}

?>