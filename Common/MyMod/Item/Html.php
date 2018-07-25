<?php


trait MyMod_Item_Html
{
    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function MyMod_Item_Table_Html($edit,$item,$datas,$plural=FALSE,$includename=FALSE,$includecompulsorymsg=FALSE,$toptions=array(),$troptions=array(),$tdoptions=array())
    {
        return
            $this->Htmls_Table
            (
               "",
               $this->MyMod_Item_Table
               (
                   $edit,
                   $item,
                   $datas,
                   $plural,
                   $includename,
                   $includecompulsorymsg
               ),
               $toptions,$troptions,$tdoptions
            );
    }    
}

?>