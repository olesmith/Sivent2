<?php


trait Sql_Table_Create
{
    //*
    //* function Sql_Table_Create_Query, Parameter list: $table=""
    //*
    //* Returns reate db query.
    //*
    //* 

    function Sql_Table_Create_Query($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $type=$this->DB_Dialect();

        $query="";
        if ($type=="mysql")
        {
            $query=
                "CREATE TABLE ".
                 $this->Sql_Table_Name_Qualify($table).
                 " (".
                $this->Sql_Table_Column_Name_Qualify("ID").
                " INT PRIMARY KEY NOT NULL AUTO_INCREMENT".
                ")";
        }
        elseif ($type=="pgsql")
        {
             $query=
                "CREATE TABLE ".
                 $this->Sql_Table_Name_Qualify($table).
                 " (".
                 $this->Sql_Table_Column_Name_Qualify("ID").
                 " SERIAL PRIMARY KEY NOT NULL".
                 ")";
       }

        return $query;
    }

    
    //*
    //* function Sql_Table_Create, Parameter list: $table=""
    //*
    //* Creates Table according to SQL specification in $vars,
    //* if it does not exist already.
    //*
    //* 

    function Sql_Table_Create($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if ($this->Sql_Table_Exists($table))
        {
            return;
        }

        
        if (!empty($table))
        {
            $query=$this->Sql_Table_Create_Query($table);

            $this->QueryDB($query);
            $this->ApplicationObj()->AddPostMessage("Table $table created: ".$query);
            
            if (
                  $this->ModuleName!="Logs"
                  &&
                  !preg_match('/(Sessions|__Table__)$/',$table)
                  &&
                  method_exists($this,"LogsObj")
               )
            {
                //$this->LogsObj(TRUE)->ApplicationObj()->LogMessage("Create Table","SQL Table $table created");
            }

        }
    }
}
?>