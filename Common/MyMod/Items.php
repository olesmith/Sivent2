<?php


include_once("Items/Ors.php"); 
include_once("Items/Row.php"); 
include_once("Items/Table.php"); 
include_once("Items/Search.php"); 

trait MyMod_Items
{
    use
        MyMod_Items_Table,
        MyMod_Items_Row,
        MyMod_Items_Ors,
        MyMod_Items_Search;
        
}

?>