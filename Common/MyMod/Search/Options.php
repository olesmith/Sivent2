<?php

include_once("Options/ShowAll.php");
include_once("Options/DataGroups.php");
include_once("Options/Paging.php");
include_once("Options/Latex.php");
include_once("Options/Tabulator.php");


trait MyMod_Search_Options
{
    use
        MyMod_Search_Options_ShowAll,
        MyMod_Search_Options_DataGroups,
        MyMod_Search_Options_Paging,
        MyMod_Search_Options_Latex,
        MyMod_Search_Options_Tabulator;
    //*
    //* function MyMod_Search_Options_Rows, Parameter list: $omitvars
    //*
    //* Adds the IncludeAll, Output, Paging and Data Group fields.
    //*

    function MyMod_Search_Options_Rows($omitvars)
    {
        return
            array_merge
            (
                array
                (
                    array_merge
                    (
                        $this->MyMod_Search_Options_Show_All_Cells($omitvars),
                        $this->MyMod_Search_Options_Data_Groups_Cells($omitvars)
                    )
                ),
                $this->MyMod_Search_Options_Paging_Rows($omitvars),
                $this->MyMod_Search_Options_Latex_Rows($omitvars,"Plural")
            );
    }
    
    
    
}

?>