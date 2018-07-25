<?php

include_once("Group/Cells.php");
include_once("Group/Titles.php");
include_once("Group/Row.php");
include_once("Group/Rows.php");
include_once("Group/Table.php");
include_once("Group/SumVars.php");
include_once("Group/Html.php");
include_once("Group/Form.php");


trait MyMod_Group
{
    use
        MyMod_Group_Cells,
        MyMod_Group_Titles,
        MyMod_Group_Row,
        MyMod_Group_Rows,
        MyMod_Group_Table,
        MyMod_Group_SumVars,
        MyMod_Group_Html,
        MyMod_Group_Form;
}

?>