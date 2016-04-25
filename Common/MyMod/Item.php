<?php


include_once("Item/Form.php");
include_once("Item/Update.php");
include_once("Item/Group.php");
include_once("Item/Table.php");
include_once("Item/Row.php");
include_once("Item/Read.php");
include_once("Item/Data.php");
include_once("Item/Children.php");

trait MyMod_Item
{
    use
        MyMod_Item_Form,
        MyMod_Item_Update,
        MyMod_Item_Group,
        MyMod_Item_Table,
        MyMod_Item_Row,
        MyMod_Item_Read,
        MyMod_Item_Data,
        MyMod_Item_Children;
        
    //*
    //* Creates row with item titles.
    //*

    function MyMod_Item_Titles($datas)
    {
        $row=array();
        foreach ($datas as $data)
        {
            if (!is_array($data)) { $data=array($data); }
            
            $cells=array();
            foreach ($data as $rdata)
            {
                array_push
                (
                   $cells,
                   $this->MyMod_Item_Cell_Title($rdata,FALSE)
                );

                //Take only one title, the first
                break;
            }

            array_push
            (
               $row,
               join($this->BR(),$cells)
            );
        }

        return $row;
    }
    
    var $CellMethods=array();
    
    //*
    //* Registers cell $method with permissions $perms.
    //*

    function MyMod_Item_Cell_AddMethod($method,$perms)
    {
        $this->CellMethods[ $method ]=$perms;
    }

    
    //*
    //* Creates item cell: data cell, action cell - or method cell..
    //*

    function MyMod_Item_Cell($edit,$item,$data,$even=FALSE,$plural=TRUE,$rdata="")
    {
        $cell="";
        $itemdata=$this->ItemData($data);
        $action=$this->Actions($data);
        
        if ($data=="No")
        {
            $cell=$this->B($item[ "No" ]);
        }
        elseif (!empty($itemdata))
        {
            $cell=$this->MyMod_Item_Data_Cell($edit,$item,$data,$plural,$rdata);
        }
        elseif (!empty($action))
        {
            $cell=$this->MyActions_Entry_OddEven($even,$data,$item);
        }
        else
        {
            if (!empty($this->CellMethods[ $data ]))
            {
                $cell=$this->$data($edit,$item,$data);
            }
        }

        return $cell;
    }
    
    //*
    //* Creates item cell: data cell, action cell - or method cell..
    //*

    function MyMod_Item_Cell_Title($data)
    {
        $cell="";
        $itemdata=$this->ItemData($data);
        $action=$this->Actions($data);
        
        if (!empty($itemdata))
        {
            $cell=$this->MyMod_Item_Data_Cell_Title($data);
        }
        elseif (!empty($action))
        {
            //$cell=$this->MyActions_Entry_Title($data,$item);
        }
        elseif (!empty($this->CellMethods[ $data ]))
        {
            $cell=$this->$data();
        }

        return $cell;
    }
}

?>