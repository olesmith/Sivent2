<?php


trait MyMod_Search_Options_DataGroups
{
    //*
    //* function MyMod_Search_Options_Show_All_Cells, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Data_Groups_Cells($omitvars)
    {
        $row=array();
        if (!preg_grep('/^DataGroups/',$omitvars))
        {
            $field=$this->DataGroupsSearchField();
            if (!empty($field))
            {
                array_push
                ( 
                   $row,
                   $this->Htmls_DIV
                   (
                       $this->MyLanguage_GetMessage("DataGroupsTitle").":",
                       array("CLASS" => 'searchtitle')
                   ),
                   $field
                );
            }
        }

        return $row;
    }
    
}

?>