<?php

include_once("Table/Data.php");
include_once("Table/Read.php");
include_once("Table/CGI.php");
include_once("Table/Where.php");
include_once("Table/Rows.php");
include_once("Table/Sort.php");
include_once("Table/Table.php");
include_once("Table/Update.php");


class Caravaneers_Table extends Caravaneers_Table_Update
{
    //*
    //* function Caravaneers_Tables, Parameter list: $edit,&$inscription
    //*
    //* Produces list of table. If HTML, a list with one table.
    //* For latex mode, paginates.
    //*

    function Caravaneers_Table_Tables($edit,&$inscription)
    {
        $table=$this->Caravaneers_Table($edit,$inscription);
        if ($this->LatexMode())
        {
            return $this->MyHashes_Page($table,40);
        }
        
        return array($table);
    }

    
    //*
    //* function Caravaneers_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Caravaneers for inscription in .
    //*

    function Caravaneers_Table_Show($edit,&$inscription,$head="")
    {
        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $n=$this->Caravaneers_Table_ReadN($inscription);
        if ($n==0 && $edit!=1) { return ""; }

        $method="Html_Table";
        if ($this->LatexMode()) { $method="Latex_Table"; }

        $text=array();
        foreach ($this->Caravaneers_Table_Tables($edit,$inscription) as $table)
        {
            array_push
            (
                $text,
                $head.
                $this->H(3,$this->MyLanguage_GetMessage("Caravaneers_Table_Title")).
                $buttons.
                $this->$method
                (
                   $this->Caravaneers_Table_Titles(),
                   $table
                ).
                $buttons.
                ""
            );
        }

        $glue="";
        if ($this->LatexMode())
        {
            $glue="\n\n\\clearpage\n\n";
        }
        
        return join($glue,$text);
    }
}

?>