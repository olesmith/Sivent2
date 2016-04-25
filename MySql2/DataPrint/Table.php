<?php


class DataPrintTable extends DataPrintTitles
{
    //*
    //* function DataTable, Parameter list: 
    //*
    //* Creates table for selecting student data to include.
    //*

    function DataTable()
    {
        $table=array();

        $n=1;
        foreach ($this->ItemHashes as $item)
        {
            array_push
            (
               $table,
               $this->DataTableRow($item,$n++)
            );
        }

        return $table;
    }
}

?>