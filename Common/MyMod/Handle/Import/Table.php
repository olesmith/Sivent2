<?php


trait MyMod_Handle_Import_Table
{
    //*
    //* function MyMod_Handle_Import_Items_Table, Parameter list: 
    //*
    //* Generates detected items table.
    //*

    function MyMod_Handle_Import_Items_Table()
    {
        $items=$this->MyMod_Handle_Import_Detect_Items();

        $table=array();

        $buttonrows=
            array
            (
                array($this->MakeHidden("Save",1)),
                array($this->Buttons()),
            );

        $nregistered=0;
        $ninscribed=0;
        $ncerts=0;
        
        $n=1;
        foreach ($items as $email => $ritems)
        {
            $item=array_shift($ritems);
            $item[ "No" ]=$n;
            array_push
            (
                $table,
                $this->MyMod_Handle_Import_Item_Row($item)
            );

            $n++;

            if ( ($n % 10)==1)
            {
                $table=array_merge($table,$buttonrows);
            }

            if ($item[ "Registered" ])  { $nregistered++; }
            if ($item[ "Inscribed" ])   { $ninscribed++; }
            if ($item[ "Certificate" ]) { $ncerts++; }
        }

        if ( ($n % 10)!=1)
        {
            $table=array_merge($table,$buttonrows);
        }
        
        array_unshift
        (
            $table,
            $this->MyMod_Handle_Import_Items_Table_SumsRow
            (
                count($items),
                $nregistered,
                $ninscribed,
                $ncerts
            ),
            $this->MyMod_Handle_Import_Items_Table_AllRow(),
            array()
        );

        return $table;
    }
}
?>