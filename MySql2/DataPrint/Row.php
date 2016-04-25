<?php


class DataPrintRow extends DataPrintCells
{
    //*
    //* function DataTableRow, Parameter list: $item,$n=0
    //*
    //* Creates table row with $datas for $item.
    //*

    function DataTableRow($item,$n=0)
    {
        $row=array();

        if (!empty($n)) { array_push($row,sprintf("%02d",$n++)); }
        foreach ($this->ColsDef[ "ColDatas" ] as $data)
        {
            array_push($row,$this->MyMod_Data_Fields_Show($data,$item));
        }

        return $row;
    }
}

?>