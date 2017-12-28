<?php

include_once("Files/Cells.php");
include_once("Files/Row.php");
include_once("Files/Table.php");
include_once("Files/Form.php");

trait MyMod_Handle_Files
{
    use
        MyMod_Handle_Files_Cells,
        MyMod_Handle_Files_Row,
        MyMod_Handle_Files_Table,
        MyMod_Handle_Files_Form;
    
    var $FilesShowDatas=array("No","Edit","Name");

    //*
    //* function MyMod_Handle_Files, Parameter list: 
    //*
    //* Handles Module file processing
    //*

    function MyMod_Handle_Files()
    {
        return $this->MyMod_Handle_Files_Form();
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