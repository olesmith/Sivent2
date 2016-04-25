<?php

trait ItemForm_Html
{
    //*
    //* function ItemForm_HtmlTable, Parameter list: $edit,$buttons=FALSE
    //*
    //* Creates Assessment edit table as matrix.
    //*

    function ItemForm_HtmlTable($edit,$buttons=FALSE)
    {
        return
            $this->Html_Table
            (
                "",
                $this->ItemForm_Table($edit,$buttons)
            ).
            "";
    }
}

?>