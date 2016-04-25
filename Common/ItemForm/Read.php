<?php

trait ItemForm_Read
{
    //*
    //* function ItemForm_Read, Parameter list: 
    //*
    //* Handle  inscription.
    //*

    function ItemForm_Read()
    {
        if (empty($this->Args[ "Item" ]))
        {
            $this->Args[ "Item" ]=$this->SelectUniqueHash("",$this->Args[ "ItemWhere" ]);
        }
    }
}

?>