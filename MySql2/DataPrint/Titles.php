<?php


class DataPrintTitles extends DataPrintRow
{
    //*
    //* function DataTableTitleRow, Parameter list: 
    //*
    //* Creates table title row with $datas.
    //*

    function DataTableTitleRow($numbercol=TRUE)
    {
        $titles=$this->MyMod_Data_Titles
        (
           $this->ColsDef[ "ColDatas" ]
        );

        if ($numbercol)
        {
            array_unshift($titles,"No.");
        }


        return $titles;
    }
}

?>