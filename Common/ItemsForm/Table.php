<?php


trait ItemsFormTable
{
    //*
    //* function ItemsForm_Table, Parameter list:
    //*
    //* Generates table listing, with possible details row.
    //* 
    //*

    function ItemsForm_Table()
    {
        $table=$this->Table_Generate();

        if ($this->Args[ "Edit" ]==1)
        {
            array_unshift
            (
               $table,
               $this->Buttons()
            );
            array_push
            (
               $table,
               $this->Buttons()
            );
        }

        return $table;
    }


}

?>