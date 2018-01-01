<?php

include_once("Import/Cells.php");
include_once("Import/Read.php");
include_once("Import/Datas.php");
include_once("Import/Titles.php");
include_once("Import/Row.php");
include_once("Import/Table.php");
include_once("Import/Update.php");
include_once("Import/Menu.php");
include_once("Import/Form.php");
include_once("Import/Handle.php");


trait EventMod_Import
{
    use
        EventMod_Import_Cells,
        EventMod_Import_Read,
        EventMod_Import_Datas,
        EventMod_Import_Titles,
        EventMod_Import_Row,
        EventMod_Import_Table,
        EventMod_Import_Menu,
        EventMod_Import_Update,
        EventMod_Import_Form,
        EventMod_Import_Handle;
        
}

?>