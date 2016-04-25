<?php

include_once("DataPrint/CGI.php");
include_once("DataPrint/Cells.php");
include_once("DataPrint/Row.php");
include_once("DataPrint/Titles.php");
include_once("DataPrint/Table.php");
include_once("DataPrint/Include.php");

class DataPrint extends DataPrintInclude
{
    var $ColsDef=array
    (
       "NCols" => 0,
       "DefaultCols" => array(),
       "CGIPre" => "", //Prekey in form, allows multiple modules/objects

       "Datas"        => array(), //all or given data
       "AllowedDatas" => array(), //allowed data
       "ColDatas"     => array(),  //data to include

       "NColTitle" => "Nº de Colunas:",
       "ColTitle" => "Coluna",

       "SelectNames"  => array(), //names in SELECT
       "SelectTitles" => array(), //titles in SELECT


       "Orientation" => 2, //landscape
       "NStudentsPP" => array
       (
          1 => 45,
          2 => 30,
       )
    );

    //*
    //* function InitDataPrintTitles, Parameter list: 
    //*
    //* Sets DataPrint variables from calling parameters.
    //*

    function InitDataPrintTitles()
    {
        $titles=array();
        foreach ($this->ColsDef[ "AllowedDatas" ] as $data)
        {
            $titles[ $this->GetDataTitle($data) ]=$data;
        }

        $names=array_keys($titles);
        sort($names);

        $this->ColsDef[ "SelectNames" ]=array(0);
        $this->ColsDef[ "SelectTitles" ]=array("");

        foreach ($names as $name)
        {
            array_push($this->ColsDef[ "SelectNames" ],$name);
            array_push($this->ColsDef[ "SelectTitles" ],$titles[ $name ]);
        }
    }

    //*
    //* function InitDataPrint, Parameter list:
    //*
    //* Sets DataPrint variables from calling parameters.
    //*

    function InitDataPrint($colsdef)
    {
        foreach ($colsdef as $key =>$value)
        {
            $this->ColsDef[ $key ]=$value;
        }

        //Allowed datas
        $this->ColsDef[ "AllowedDatas" ]=$this->FindAllowedData(0,$this->ColsDef[ "Datas" ]);

        //Set titles for generating include data selects
        $this->InitDataPrintTitles();

        //Read CGI
        $this->CGI2NColsValue();
        $this->CGI2ColDatas();


    }
}

?>