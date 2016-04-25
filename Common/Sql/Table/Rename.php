<?php

trait Sql_Table_Rename
{
    //*
    //* function Sql_Table_Rename_Query, Parameter list: $oldname,$newname
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Rename_Query($oldtable,$newtable)
    {
        return
            "ALTER TABLE ".
            $this->Sql_Table_Name_Qualify($oldtable).
            " RENAME TO ".
            $this->Sql_Table_Name_Qualify($newtable);
    }

    //*
    //* function Sql_Table_Rename, Parameter list: $oldname,$newname
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Rename($oldtable,$newtable)
    {
        if ($oldtable==$newtable) { return; }
        
        if ($this->Sql_Table_Exists($oldtable))
        {
            if (!$this->Sql_Table_Exists($newtable))
            {
                $this->DB_Query
                (
                   $this->Sql_Table_Rename_Query($oldtable,$newtable)
                );
            }
        }
    }

}
?>