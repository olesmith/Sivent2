<?php


trait ItemsFormRow
{
    //*
    //* function ItemsForm_ItemRows_NCols, Parameter list: 
    //*
    //* Generates table listing, with possible edit row - and add row.
    //* 
    //*

    function ItemsForm_ItemRows_NCols()
    {
        $count=count($this->Args[ "Datas" ])-1;

        if (!empty($this->Args[ "NCols" ]))
        {
            $count=$this->Args[ "NCols" ];
        }
        
        return $count;
    }
    
    //*
    //* function ItemsForm_ItemRows, Parameter list: $edit,$item,$n
    //*
    //* Generates table listing, with possible edit row - and add row.
    //* 
    //*

    function ItemsForm_ItemRows($edit,$item,$n)
    {
        if ($this->ItemsForm_Details_Should($item))
        {
            return $this->ItemsForm_ItemDetails_Rows($edit,$item,$n);
        }
        
        $args=$this->CGI_URI2Hash();
        $args[ $this->Args[ "DetailsCGIVar" ] ]=$item[ $this->Args[ "DetailsItemVar" ] ];
        $rows=$this->Table_Rows($edit,$item,$n);
        
        $rows[0][0].=
            " ".
            $this->ItemsForm_Details_Href($item).
            "";
        
        return $rows;
    }
}

?>