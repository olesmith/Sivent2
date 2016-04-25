<?php

include_once("Structure/Column.php");
include_once("Structure/Update.php");

trait Sql_Table_Structure
{
    use
        Sql_Table_Structure_Column,
        Sql_Table_Structure_Update;
}
?>