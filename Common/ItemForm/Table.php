<?php

trait ItemForm_Table
{
    //*
    //* function ItemForm_Table, Parameter list: $edit,$buttons="",$assessor=array()
    //*
    //* Creates ItemForm_ edit table as matrix.
    //*

    function ItemForm_Table($edit,$item=array())
    {
        if (empty($item)) { $item=$this->Args[ "Item" ]; }
        if (empty($item)) { $item=$this->ItemHash; }

        $groups=$this->ItemForm_SGroups($edit);

        $buttons=$this->Args[ "Buttons" ];
        if (empty($buttons)) {  $buttons=$this->Args[ "RowButtons" ]; }

        $table=$this->MyMod_Item_Group_Tables
        (
            $edit,
            $groups,
            $item,
            $buttons
        );
        
        return $table;
    }
}

?>