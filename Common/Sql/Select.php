<?php

include_once("Select/Hashes.php");
include_once("Select/Hash.php");
include_once("Select/Values.php");
include_once("Select/Joins.php");
include_once("Select/Calc.php");
include_once("Select/Unique.php");

trait Sql_Select
{
    use
        Sql_Select_Unique,
        Sql_Select_Hashes,
        Sql_Select_Hash,
        Sql_Select_Values,
        Sql_Select_Joins,
        Sql_Select_Calc;
    
}
?>