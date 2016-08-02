<?php


include_once("Items/Ors.php"); 
include_once("Items/Row.php"); 
include_once("Items/Table.php"); 
include_once("Items/Group.php"); 
include_once("Items/Search.php"); 
include_once("Items/PHP.php"); 
include_once("Items/Print.php"); 
include_once("Items/Latex.php"); 

trait MyMod_Items
{
    use
        MyMod_Items_Table,
        MyMod_Items_Group,
        MyMod_Items_Row,
        MyMod_Items_Ors,
        MyMod_Items_Search,
        MyMod_Items_PHP,
        MyMod_Items_Print,
        MyMod_Items_Latex;
        
}

?>