<?php

include_once("ItemsForm.php");
include_once("ItemForm/Read.php");
include_once("ItemForm/Table.php");
include_once("ItemForm/Form.php");
include_once("ItemForm/Contents.php");
include_once("ItemForm/Update.php");
include_once("ItemForm/Html.php");
include_once("ItemForm/SGroups.php");

trait ItemForm 
{
    var $ItemFormMessage="";

    use ItemsForm,
        ItemForm_Read,ItemForm_Table,ItemForm_Form,ItemForm_Contents,
        ItemForm_Update,ItemForm_Html,ItemForm_SGroups;

    //* Generates Item form with update.
    //* Combines use of MakeForm and MakeTable traits.
    //* 

    //*
    //* function ItemForm_Defaults, Parameter list: $rargs
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemForm_Defaults($rargs)
    {
        $this->Args=array
        (
           //Form
           "ID"         => $this->Form_Number,
           "Name"       => "Name-me...",
           "Method"     => "post",
           "Action"     => "",
           "Anchor"     => "",
           "Uploads" => FALSE,
           "CGIGETVars" => array(),
           "CGIPOSTVars" => array(),

           "Contents"   => "",
           "Options"    => array(),
           
           "StartButtons"   => "",
           "EndButtons"   => "",
           "RowButtons"   => "",
           "Buttons"   => "",
           
           "Hiddens"   => array(),

           "Edit"   => 0,
           "Update" => 0,

           "ReadMethod" => "",
           "UpdateMethod" => "",
           "ContentsHtml" => "",
           "ContentsLatex" => "",

           "IgnoreGETVars" => array(),
           "UpdateCGIVar" => "",
           "UpdateCGIValue" => 1,
           //"UpdateItems"   => array(),

           "Contents"   => "ItemForm_Contents",

           "UpdateMessages" => array
           (
              "Dados Atualizado",
              "Erro Atualizando Dados"
           ),
           "ReadMethod" => "ItemForm_Read",
           "ReadWhere"   => array(),

           "UpdateMethod" => "ItemForm_Update",
 
           "UpdateCGIVar" => "Update",
           "UpdateCGIValue" => 1,
           "SGroups" => array(),
           "SGroupsDatas" => array(),
           "SGroupsNCols" => 2,

           //Table
           "Title"       => "",
           "Edit"       => 0,

           "Options"    => array(),
           "RowOptions"    => array(),
           "CellOptions"    => array(),

           "Datas" => array(),
           "Item" => array(),
           "ItemWhere" => array(),

           "Edit"   => 0,

           "Items" => array(),
           "TableMethod" => "ItemForm_Table",

           "UniqueDatas" => array(),
        );

        foreach ($rargs as $key => $value)
        {
            $this->Args[ $key ]=$value;
        }
    }

    //*
    //* function ItemForm_Run, Parameter list: $rargs
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemForm_Run($rargs)
    {
        $this->ItemForm_Defaults($rargs);

        $html=
            $this->Form_Run($this->Args).
            "";

        if (!empty($this->Args[ "AddGroup" ]))
        {
            $html.=
                "<HR>".
                $this->ItemsForm_AddItemForm();
        }

        return $html;
    }
}

?>