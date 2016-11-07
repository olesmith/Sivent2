<?php

include_once("Files/Cells.php");
include_once("Files/Row.php");
include_once("Files/Table.php");
include_once("Files/Form.php");

trait MyMod_Handle_Files
{
    var $FilesShowDatas=array("No","Edit","Name");

    //*
    //* function MyMod_Handle_Files, Parameter list: 
    //*
    //* Handles Module file processing
    //*

    function MyMod_Handle_Files()
    {
        return $this->MyMod_Handle_Files_Form();

        /* $this->ReadItems("",$this->GetFileFieldDatas(),FALSE,FALSE,0,TRUE); */
        /* $title=""; */

        /* //No processing if ($this->GetPOST("Process")==1) */
        /* if (FALSE) */
        /* { */
        /*      $this->DoFiles(); */
        /*      $title="Processar"; */
        /* } */

        /* $datas=array_merge */
        /* ( */
        /*    $this->ZipShowDatas, */
        /*    $this->GetFileFields() */
        /* ); */

        /* echo  */
        /*     $this->SearchVarsTable */
        /*     ( */
        /*        array("DataGroups"), */
        /*        "", */
        /*        "Files", */
        /*        array(), */
        /*        array(), */
        /*        "", */
        /*        "", */
        /*        array */
        /*        ( */
        /*         //No processing $this->Button("submit","Process",array("NAME" => "Process","VALUE" => 1)) */
        /*        ) */
        /*     ). */
        /*     $this->H(1,$title." Arquivos, ".count($this->ItemHashes)." ".$this->ItemsName). */
        /*     $this->PagingHorisontalMenu(). */
        /*     $this->ItemsHtmlTable */
        /*     ( */
        /*        "", */
        /*        0, */
        /*        $datas */
        /*     ). */
        /*     ""; */
    }
    





    //*
    //* function DoFiles, Parameter list: 
    //*
    //* Will do the actual file processing on searched items.
    //*

    function DoFiles()
    {
        $this->ProcessFiles();
    }


    //*
    //* function , Parameter list: 
    //*
    //* Will do the actual zipping on searched items.
    //*

    function ProcessFiles()
    {
        foreach ($this->ItemHashes as $id => $item)
        {
            foreach ($this->GetFileFields() as $filefield)
            {
                $file=$item[ $filefield ];

                if (file_exists($file))
                {
                    $fmtime=filemtime($file);
                    $dbmtime=$this->MySqlItemValue("","ID",$item[ "ID" ],$filefield."_Time");
                    if ($fmtime>$dbmtime)
                    {
                        var_dump($file.": f ".$fmtime.": db ".$dbmtime);
                        $this->MyMod_Data_Fields_File_Contents_Save($item,$file,$filefield);
                    }

                    $rfilefield=$filefield."_Time";
                    $this->MySqlSetItemValue
                        (
                            "",
                            "ID",
                            $item[ "ID" ],
                            $rfilefield,
                            $fmtime
                        );

                    $rfilefield=$filefield."_Size";
                    $this->MySqlSetItemValue
                        (
                            "",
                            "ID",
                            $item[ "ID" ],
                            $rfilefield,
                            filesize($file)
                        );
                }
            }
        }
    }
}

?>