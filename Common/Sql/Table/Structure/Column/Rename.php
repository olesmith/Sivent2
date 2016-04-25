<?php


trait Sql_Table_Structure_Column_Rename
{
    //*
    //* function Sql_Table_Column_Rename_Query, Parameter list: $name,$newname,$table=""
    //*
    //* Returns query for renaming a column.
    //* 
    //* 

    function Sql_Table_Column_Rename_Query($name,$newname,$table="")
    {
        $dialect=$this->DB_Dialect();
        

        $query="";
        if ($dialect=="mysql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " CHANGE COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($name).
                " ".
                $this->Sql_Table_Column_Name_Qualify($newname).
                " ".
                $oldcolinfo[ "Type" ];
        }
        elseif ($dialect=="pgsql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " RENAME COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($name).
                " TO ".
                $this->Sql_Table_Column_Name_Qualify($newname);
        }

        return $query;
    }

    //*
    //* function Sql_Table_Column_Rename, Parameter list: $name,$newname,$table=""
    //*
    //* Safely rename column in table.
    //* 
    //* 

    function Sql_Table_Column_Rename($name,$newname,$table="")
    {
        $table=$this->SqlTableName($table);
        if (!$this->Sql_Table_Exists($table)) { return; }

        if (!$this->Sql_Table_Field_Exists($newname,$table))
        {
            if ($this->Sql_Table_Field_Exists($name,$table))
            {
                $oldcolinfo=$this->Sql_Table_Column_Info($name,$table);
                $query=$this->Sql_Table_Column_Rename_Query($name,$newname,$table);
                $this->DB_Query($query);
            }
        }
    }
}
?>