<?php


trait MyMod_Data_Fields_File
{
    //*
    //* Updates File field (ie moves file)
    //*

    function MyMod_Data_Fields_File_Update($data,&$item,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $uploadpath=$this->GetUploadPath();
        $extensions=$this->FileFieldExtensions($data);

        if (!empty($_FILES[ $rdata ]) && !empty($_FILES[ $rdata ][ 'tmp_name' ]))
        {
            $uploadinfo=$_FILES[ $rdata ];
            $tmpname=$uploadinfo['tmp_name'];
            $name=$uploadinfo['name'];
            $error=$uploadinfo['error'];

            $comps=preg_split('/\./',$name);
            $ext=$comps[ count($comps)-1 ];

            $comps=preg_split('/\//',$name);
            $rname=$comps[ count($comps)-1 ];
            $datatitle=$this->GetDataTitle($data);

             if (preg_grep('/^'.$ext.'$/i',$extensions))
            {
                $destfile=$this->GetUploadedFileName($data,$item,$ext);
                $res=move_uploaded_file($tmpname,$destfile);

                $item[ $data."_OrigName" ]=$name;
                $item[ $data ]=$destfile;
                $this->MySqlSetItemValues
                (
                   $this->SqlTableName(),
                   array($data,$data."_OrigName"),
                   $item
                );

                $msgtext=$this->GetMessage($this->ItemDataMessages,"FileUploaded");
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$datatitle,$msgtext);
                
                $this->HtmlStatus=$msgtext."<BR><BR>";

                $this->ApplicationObj->AddHtmlStatusMessage($msgtext);

                $item[ "__Res__" ]=TRUE;
                return $item;
            }
            elseif ($name!='')
            {
                $msgtext=$this->GetMessage($this->ItemDataMessages,"InvalidExtension");
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$rdata,$msgtext);
                $item[ $data."_Message" ]=$msgtext;

                $msgtext=$this->GetMessage($this->ItemDataMessages,"InvalidExtensionStatus");
                $msgtext=preg_replace('/#Extensions/',join(",",$extensions),$msgtext);
                $msgtext=preg_replace('/#Ext/',$ext,$msgtext);
                $msgtext=preg_replace('/#Name/',$rname,$msgtext);
                $msgtext=preg_replace('/#Data/',$rdata,$msgtext);
                 $this->HtmlStatus=$msgtext."<BR><BR>";
                 $item[ "__Res__" ]=FALSE;

                 $this->ApplicationObj->AddHtmlStatusMessage($msgtext);
                 echo $this->Div($msgtext,array("CLASS" => 'errors',"ALIGN" => 'center'));
           }
        }

        return FALSE;
    }
    
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
                    $args=$this->CGI_URI2Hash();
                    
                    $args[ "ModuleName" ]=$this->ModuleName;
                    $args[ "Action" ]="Download";
                    $args[ "ID" ]= $item[ "ID" ];                    
                    $args[ "Data" ]=$data;
                        
                        
                    $src=
                        "?".$this->CGI_Hash2URI($args);

                    //$src=$this->GetUploadedFileName($data,$item,$ext);
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
}

?>