<?php

trait Sql_Table_Drop
{
    //*
    //* function Sql_Table_Drop_Query, Parameter list: $table=""
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Drop_Query($table="")
    {
        $query=
            "DROP TABLE ".$this->Sql_Table_Name_Qualify($table);
        
        return $query;
    }
    
    //*
    //* function Sql_Table_Drop, Parameter list: $table=""
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Drop($table="")
    {
        if ($this->Sql_Table_Exists($table)>0)
        {
            $this->QueryDB
            (
               $this->Sql_Table_Drop_Query($table)
            );
            $this->AddMsg("Table ".$table." has been dropped");
        }
    }
}
?>