<?php


trait MyMod_Items_Post
{
    //*
    //* function MyMod_Items_PostProcess, Parameter list: $ids=array()
    //*
    //* Calls post processor on each $items - or in not given, ItemHashes.
    //*

    function MyMod_Items_PostProcess($items=array())
    {
        if (empty($items)) { $items=$this->ItemHashes; }

        foreach (array_keys($items) as $id)
        {
            $items[$id]=$this->SetItemTime("ATime",$items[$id]);
            $items[$id]=$this->MyMod_Item_PostProcess($items[$id]);
        }

        return $items;
    }
}

?>