<?php

trait ItemForm_Update
{
    //*
    //* function ItemForm_Update, Parameter list: 
    //*
    //* Handle  inscription.
    //*

    function ItemForm_Update()
    {
        if (!empty($this->Args[ "Item" ]))
        {
            $this->Args[ "Item" ]=$this->UpdateItem
            (
               $this->Args[ "Item" ],
               $this->ItemForm_SGroupsDatas(1,TRUE)
            );

            $this->ItemsForm_FromUpdated=$this->FormWasUpdated;
        }
    }
}

?>