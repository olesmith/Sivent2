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
}

?>