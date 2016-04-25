<?php

include_once("MakeForm.php");
include_once("MakeTable.php");
include_once("MyTime.php");

include_once("ItemsForm/Sort.php");
include_once("ItemsForm/Read.php");
include_once("ItemsForm/Contents.php");
include_once("ItemsForm/Table.php");
include_once("ItemsForm/Row.php");
include_once("ItemsForm/Details.php");
include_once("ItemsForm/Add.php");
include_once("ItemsForm/Update.php");
include_once("ItemsForm/Message.php");

trait ItemsForm 
{
    var $ItemsForm_ItemAdded=FALSE;

    use MakeForm,MakeTable,MyTime,
        ItemsFormSort,ItemsFormRead,ItemsFormContents,ItemsFormTable,
        ItemsFormUpdate,
        ItemsFormRow,ItemsFormDetails,ItemsFormAdd,ItemsFormMessage;

    //* Generates Items listings, optionally with one item details link,
    //* and add item row.
    //* Combines use of MakeForm and MakeTable traits.
    //* 

    //*
    //* function ItemsForm_Defaults, Parameter list: $rargs
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemsForm_Defaults($rargs)
    {
        $this->Args=array
        (
           //Form
           "ID"         => $this->Form_Number,
           "Name"       => "Name-me...",
           "FormTitle"       => "",
           "Method"     => "post",
           "Action"     => "",
           "Anchor"     => "",
           "Uploads" => FALSE,
           "CGIGETVars" => array(),
           "CGIPOSTVars" => array(),

           "Options"    => array(),
           "StartButtons"   => "",
           "EndButtons"   => "",
           "Buttons"   => "",
           "Hiddens"   => array(),

           "Edit"   => 0,
           "Update" => 0,

           "ReadMethod" => "",
           "UpdateMethod" => "",

           "IgnoreGETVars" => array(),
           "UpdateCGIVar" => "",
           "UpdateCGIValue" => 1,
           //"UpdateItems"   => array(),

           "DefaultSorts"   => array("ID"),
           
           "Contents"   => "ItemsForm_Contents",
           "ContentsHtml" => "",
           "ContentsLatex" => "",

           "ReadMethod" => "ItemsForm_Read",
           "ReadWhere"   => array(),

           //Table
           "Title"       => "",
           "Edit"       => 0,

           "UpdateMethod" => "ItemsForm_Update",
           "UpdateCGIVar" => "Update",
           "UpdateCGIValue" => 1,

           "Options"    => array(),
           "RowOptions"    => array(),
           "CellOptions"    => array(),

           "Datas" => array(),
           "NCols" => 0,
           "GroupsMenu" => TRUE,
           "Group" => "Basic",


           "Items" => array(),
           "TableMethod" => "ItemsForm_Table",

           "RowMethod"   => "",
           "RowsMethod"   => "ItemsForm_ItemRows",
           "TitleRowMethod"   => "",
           "TitleRowsMethod"   => "Table_TitleRows",

           //Rows repeating themselves periodically, ex each 10 rows
           "Period"         => 0,
           "PeriodRows"   => array(),
           //"PostRowsMethod"   => "ItemsForm_AddRows",

           //Add row, if activated
           "AddGroup" => "",
           "AddItem" => array(),
           "AddDatas" => array(),
           "UniqueDatas" => array(),

           //Item Details
           "DetailsObject"   => $this,
           "DetailsDefault"   => 0,
           "DetailsMethod"   => "ItemsForm_ItemDetailsCell",
           "DetailsSGroups"   => array(array("Basic" => 1)),
           "DetailsCGIVar" => $this->ModuleName,
           "DetailsIncludeDataRow" => FALSE,
           "DetailsItemVar" => "ID",
           "DetailsAddVars" => array(),
           "DetailsCGIVars" => array(),
        );

        foreach ($rargs as $key => $value)
        {
            $this->Args[ $key ]=$value;
        }
    }

    //*
    //* function ItemsForm_Run, Parameter list: $rargs
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemsForm_Run($rargs)
    {
        $this->ItemsForm_Defaults($rargs);

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