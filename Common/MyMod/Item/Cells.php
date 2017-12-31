<?php


trait MyMod_Item_Cells
{
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
        elseif (!empty($this->CellMethods[ $data ]))
        {
            $cell=$this->$data($edit,$item,$data);
        }

        return $cell;
    }
    
    //*
    //* Creates item cell: data cell, action cell - or method cell..
    //*

    function MyMod_Item_Action_Cell_Title($data)
    {
        return $this->B($this->MyActions_Entry_Title($data));
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
            $cell=$this->$data(0,array(),$data);
        }

        return $cell;
    }
}

?>