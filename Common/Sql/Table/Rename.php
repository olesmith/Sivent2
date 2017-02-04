<?php

trait Sql_Table_Rename
{
    //*
    //* function Sql_Table_Rename_Query, Parameter list: $oldname,$newname
    //*
    //* Generates table rename query.
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
    //* Tries to rename $oldtable to $newtable.
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