<?php

include_once("Table/Exists.php");
include_once("Table/Drop.php");
include_once("Table/Create.php");
include_once("Table/Rename.php");
#Maintains the last updated table
include_once("Table/Info.php");
#Maintains indices
include_once("Table/Index.php");
include_once("Table/Structure.php");
include_once("Table/Fields.php");
include_once("Table/Names.php");
include_once("Table/Qualify.php");

trait Sql_Table
{
    use
        Sql_Table_Exists,
        Sql_Table_Drop,
        Sql_Table_Create,
        Sql_Table_Rename,
        Sql_Table_Info,
        Sql_Table_Index,
        Sql_Table_Structure,
        Sql_Table_Fields,
        Sql_Table_Names,
        Sql_Table_Qualify;

    //*
    //* function Sql_Tables_Get, Parameter list: 
    //*
    //* Returns all tables in DB.
    //*

    function Sql_Tables_Get()
    {
        $tables=array();
        foreach ($this->Sql_Tables() as $module => $moduletables)
        {
            foreach ($moduletables as $id => $table)
            {
                array_push($tables,$table);
            }
        }

        sort($tables);

        return $tables;
    }
    
   
    //*
    //* function Sql_Tables_N, Parameter list: 
    //*
    //* Detects number of tables in DB.
    //*

    function Sql_Tables_N()
    {
        return count($this->Sql_Tables_Get());
    }


    
    //*
    //* function Sql_Tables_Empties_Get, Parameter list: 
    //*
    //* Returns list of empty tables in DB.
    //*

    function Sql_Tables_Empties_Get()
    {
        $emptytables=array();
        foreach ($this->Sql_Tables_Get() as $id => $table)
        {
            if ($this->Sql_Table_Empty_Is($table))
            {
                array_push($emptytables,$table);
            }
        }

        return $emptytables;        
    }

    //*
    //* function Sql_Tables_Empties_N, Parameter list: 
    //*
    //* Detects number of tables in DB.
    //*

    function Sql_Tables_Empties_N()
    {
        return count($this->Sql_Tables_Empties_Get());
    }

    
    
    //*
    //* function Sql_Table_NItems, Parameter list: $table
    //*
    //* Returns numer of table entries.
    //*

    function Sql_Table_NItems($table)
    {
        return $this->Sql_Select_NHashes(array(),$table);
    }
    
    //*
    //* function Sql_Table_Empty_Is, Parameter list: $table
    //*
    //* Returns true if $table has zero entries.
    //*

    function Sql_Table_Empty_Is($table)
    {
        $res=TRUE;
        if ($this->Sql_Table_NItems($table)>0)
        {
            $res=FALSE;
        }

        return $res;
    }

}
?>