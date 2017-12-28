<?php

trait MyMod_Handle_Export_Rows
{
    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function MyMod_Handle_Export_Table_Data_Titles($datas)
    {
        return $this->MyMod_Data_Titles($datas);
    }
    
    //*
    //* Gathers the actual export table row.
    //*

    function MyMod_Handle_Export_Row($nn,$datas,&$item)
    {
        $row=array();
        foreach ($datas as $data)
        {
            $cell=$nn;
            if ($data!="No")
            {
                $cell="-";
                if (isset($item[ $data ]))
                {
                    $cell=$item[ $data ];
                }
            }
                
            array_push($row,$cell);
        }

        return $row;
    }
}
?>