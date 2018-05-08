<?php

include_once("Export/CGI.php");
include_once("Export/Data.php");
include_once("Export/Defaults.php");
include_once("Export/Read.php");
include_once("Export/Rows.php");
include_once("Export/Table.php");
include_once("Export/Sort.php");
include_once("Export/Form.php");


trait MyMod_Handle_Export
{
    use
        MyMod_Handle_Export_CGI,
        MyMod_Handle_Export_Data,
        MyMod_Handle_Export_Defaults,
        MyMod_Handle_Export_Read,
        MyMod_Handle_Export_Rows,
        MyMod_Handle_Export_Table,
        MyMod_Handle_Export_Sort,
        MyMod_Handle_Export_Form;
    
    //*
    //* function MyMod_Handle_Export, Parameter list: 
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Export()
    {
        $this->MyMod_Handle_Export_CGI_Fields();
        $this->MyMod_Handle_Export_Form();
    }

    //*
    //* Calls ExportTable to gather the export table, and
    //* prints this in relevant format.
    //*

    function MyMod_Handle_Export_Do()
    {
        $outdoc=$this->ModuleName.".Export";

        $exporttype=$this->MyMod_Handle_Export_CGI_Type();

        $datas=$this->MyMod_Handle_Export_CGI_Fields_Datas();
        
        if ($exporttype=="HTML")
        {
            $this->MyMod_Handle_Export_Html($outdoc,$datas);
        }
        elseif ($exporttype=="CSV")
        {
            $this->MyMod_Handle_Export_CSV($outdoc,$datas);
        }
        elseif ($exporttype=="LaTeX")
        {
            $this->MyMod_Handle_Export_Latex($outdoc,$datas);
        }
        elseif ($exporttype=="SQL")
        {
            $this->MyMod_Handle_Export_SQL($outdoc,$datas);
        }
        elseif ($exporttype=="PDF")
        {
            $this->MyMod_Handle_Export_PDF($outdoc,$datas);
        }
        else
        {
            echo "Unsupported export type: $exporttype";
        }
    }
    
    //*
    //* Exports as HTML.
    //*

    function  MyMod_Handle_Export_Html($outdoc,$datas)
    {
        echo html_entity_decode
        (
            $this->FrameIt
            (
                $this->H(2,$this->MyMod_ItemsName()." Exportados").
                $this->Html_Table
                (
                    $this->MyMod_Handle_Export_Data_Titles($datas),
                    $this->MyMod_Handle_Export_Table($datas)
                )
            )
        );
    }

    //*
    //* Exports as CSV.
    //*

    function MyMod_Handle_Export_CSV($outdoc,$datas,$sep=";")
    {
        $csv=join($sep,$this->MyMod_Handle_Export_Data_Titles($datas))."\n";

        foreach ($this->MyMod_Handle_Export_Table($datas) as $row)
        {
            $csv.=join($sep,$row)."\n";
        }

        $this->MyMod_Doc_Header_Send("csv",$outdoc.".csv","utf-8");
        echo html_entity_decode($csv);
    }

    //*
    //* Exports as Latex.
    //*

    function MyMod_Handle_Export_Latex($outdoc,$datas)
    {
        $this->MyMod_Doc_Header_Send("tex",$outdoc.".tex","utf-8");
        echo
            html_entity_decode
            (
                $this->TrimLatex
                (
                    $this->LatexTable
                    (
                        $this->MyMod_Handle_Export_Table_Data_Titles($datas),
                        $this->MyMod_Handle_Export_Table($datas)
                    )
                )
            );
    }


    //*
    //* Exports as HTML.
    //*

    function MyMod_Handle_Export_PDF($outdoc,$datas)
    {
        $this->LatexPaths=array("System/".$this->ModuleName);
        $titles=$this->MyMod_Handle_Export_Data_Titles($datas);       
        if (count($datas)>5)
        {
            $this->LatexData[ "Head" ]=
                preg_replace
                (
                    '/\.tex$/',
                    ".Land.tex",
                    $this->LatexData[ "Head" ]);
            $this->LatexData[ "NItemsPerPage" ]=30;
        }
        else
        {
            $this->LatexData[ "Head" ]=
                preg_replace
                (
                    '/\.Land\.tex$/',
                    ".tex",
                    $this->LatexData[ "Head" ]);
            $this->LatexData[ "NItemsPerPage" ]=50;
        }

        for ($n=0;$n<count($titles);$n++)
        {
            $titles[$n]=preg_replace('/_/',"\_",$titles[$n]);
        }

        $latex=
            $this->LatexHead().
            "\\begin{center}\n".
            $this->LatexTable
            (
                $titles,
                $this->MyMod_Handle_Export_Table($datas)
            ).
            "\\end{center}\n".
            $this->LatexTail();

        $latex=$this->TrimLatex($latex);
        $latex=$this->Html2Tex($latex);
            
        $texfilename=$outdoc.".tex";
        $this->RunLatexPrint($texfilename,$latex);
    }

    //*
    //* Exports as SQL.
    //*

    function MyMod_Handle_Export_SQL($outdoc,$datas)
    {        
        $sql=array
        (
            "INSERT INTO `".$this->SqlTableName()."`",
            "(`".join("`,`",$datas)."`) VALUES",
        );

        foreach ($this->MyMod_Handle_Export_Table($datas) as $id => $vals)
        {
            $rvalues=array();
            foreach ($vals as $field => $value)
            {
                if ($field==0) { continue; }
                
                $value=addslashes($value);
                $value=preg_replace('/\n/',"\\r\\n",$value);
                $value=preg_replace('/\t/',"\\t",$value);
                array_push($rvalues,$value);
            }

            array_push($sql,"('".join("', '",$rvalues)."'),");
        }

        $sql[ count($sql)-1 ]=preg_replace('/,$/',";",$sql[ count($sql)-1 ]);

        $this->MyMod_Doc_Header_Send("sql",$outdoc.".sql","utf-8");

        echo html_entity_decode(join("\n",$sql));
    }


    


}
?>