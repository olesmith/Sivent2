<?php


class HandleZip extends HandleFiles
{
    var $ZipShowDatas=array("No","Edit","Name");

    var $ZipTmpFiles=array();
    
    //*
    //* function HandleZip, Parameter list: 
    //*
    //* Handles Module zipping of file.
    //*

    function HandleZip()
    {
        if ($this->GetPOST("ZIP")==1)
        {
            $this->NoPaging=TRUE;
            $this->ReadItems("",$this->GetFileFieldDatas(),FALSE,FALSE,0,TRUE);
            $this->DoZip();
        }

        $this->ReadItems("",$this->GetFileFieldDatas(),FALSE,FALSE,0,TRUE);
        $datas=array_merge
        (
           $this->ZipShowDatas,
           $this->GetFileFields()
        );

        echo 
            $this->SearchVarsTable
            (
               array("Paging","DataGroups"),
               "",
               "Zip",
               array(),
               array(),
               "",
               "",
               array($this->Html_Input_Button_Make("submit","ZIP",array("NAME" => "ZIP","VALUE" => 1)))
            ).
            $this->H(1,"ZIP Arquivos, ".count($this->ItemHashes)." ".$this->ItemsName).
            $this->PagingHorisontalMenu().
            $this->ItemsHtmlTable
            (
               "",
               0,
               $datas
            ).
            "";
    }




    //*
    //* function DoZip, Parameter list: 
    //*
    //* Will do the actual zipping on searched items.
    //*

    function DoZip()
    {
        $zipname="/tmp/".$this->ModuleName.".".$this->MTime2FName().".zip";

        $zip=$this->OpenZip($zipname);

        $nfiles=$this->ZipItems($zip);
        
        $this->CloseZip($zip,$zipname);
        $this->SendZip($zipname);

        $this->ZipRemoveTmpFiles($zipname);
        exit();
    }

    //*
    //* function ZipRemoveTmpFiles, Parameter list: $zipname
    //*
    //* Removes temporary files created (in $this->ZipTmpFiles) - and $zipname.
    //*

    function ZipRemoveTmpFiles($zipname)
    {
        unlink($zipname);
        foreach ($this->ZipTmpFiles as $file)
        {
            if (file_exists($file) && preg_match('/^ \/tmp/',$file)) //extra precaution!
            {
                unlink($file);
            }
        }
    }

    //*
    //* function ZipItems, Parameter list: $zip
    //*
    //* Will do the actual zipping on searched items.
    //*

    function ZipItems($zip)
    {
        $zip->addEmptyDir($this->GetUploadPath());

        $nfiles=0;
        foreach ($this->ItemHashes as $id => $item)
        {
            $nfiles+=$this->ZipItem($zip,$item);
        }

        return $nfiles;
    }

    //*
    //* function ZipItem, Parameter list: $zip,$item
    //*
    //* Will do the actual zipping on $item.
    //*

    function ZipItem($zip,$item)
    {
        $nfiles=0;
        foreach ($this->GetFileFields() as $filefield)
        {
            $file=$this->ZipItemFileField($zip,$item,$filefield);

            $this->ZipItemFileField($zip,$item,$filefield);
            $nfiles++;
        }

        return $nfiles;
    }

    //*
    //* function ZipItemFileField_OLD, Parameter list: $zip,$item,$data
    //*
    //* Will do the actual zipping on $item.
    //*

    function ZipItemFileField($zip,$item,$data)
    {
        $file=$item[ $data ];

        if (!empty($file))
        {
            if (file_exists($file))
            {
                $path=dirname($file);
                $fname=basename($file);
                $zip->addFile($file); 
            }
            elseif ($this->Sql_Table_Field_Exists($data."_Contents"))
            {
                $contents=
                    $this->DB2FileContents
                    (
                       $this->MySqlItemValue("","ID",$item[ "ID" ],$data."_Contents")
                    );

                if (!empty($contents))
                {
                    $tmpfile="/tmp/".basename($file);

                    file_put_contents($tmpfile,$contents);
                    $zip->addFile($tmpfile,$file);

                    array_push($this->ZipTmpFiles,$tmpfile);
                }
            }
        }
    }

    /* //\* */
    /* //\* function ZipItemFileField, Parameter list: $zip,$item,$data */
    /* //\* */
    /* //\* Will do the actual zipping on $item. */
    /* //\* */

    /* function ZipItemFileField_000($zip,$item,$data) */
    /* { */
    /*     $ftime=$this->MySqlItemValue("","ID",$item[ "ID" ],$data."_Time"); */
    /*     if (empty($ftime)) { return; } */

    /*     $contents=$this->DB2FileContents */
    /*     ( */
    /*        $this->MySqlItemValue("","ID",$item[ "ID" ],$data."_Contents") */
    /*     ); */

    /*     $file=$item[ $data ]; */
    /*     $tmpname="/tmp/".basename($file); */
    /*     file_put_contents($tmpname, $contents); */

    /*     $zip->addFile($tmpname,basename($file));  */

    /*     return $tmpname; */
    /* } */
}

?>