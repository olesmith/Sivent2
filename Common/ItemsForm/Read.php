<?php


trait ItemsFormRead
{
    //*
    //* function ItemsForm_Read, Parameter list:
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemsForm_Read()
    {
        if (empty($this->Args[ "Items" ]))
        {
            $sort=join(",",$this->ItemsForm_Sort());
            $this->Args[ "Items" ]=$this->Sql_Select_Hashes
            (
               $this->Args[ "ReadWhere" ],
               array_keys($this->ItemData),
               $sort,
               TRUE
            );

            $this->ItemsForm_SortItems();
        }
    }
}

?>