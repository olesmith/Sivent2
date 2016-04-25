<?php


trait Sql_Table_Exists
{
    //*
    //* function Sql_Table_Exists_Query, Parameter list: $table=""
    //*
    //* Creates Table according to SQL specification in $vars,
    //* if it does not exist already.
    //*
    //* 

    function Sql_Table_Exists_Query($table="")
    {
        $type=$this->DB_Dialect();
        $query="";
        if ($type=="mysql")
        {
            $query=
                'SELECT 1 FROM '.
                $this->Sql_Table_Name_Qualify($this->DBHash[ "DB" ]).
                ".".
                $this->Sql_Table_Name_Qualify($table);
        }
        elseif ($type=="pgsql")
        {
            $query=
                'SELECT 1 FROM '.
                $this->Sql_Table_Name_Qualify($table);
        }
        
        return $query;
    }
    
    //*
    //* function Sql_Table_Exists, Parameter list: $table=""
    //*
    //* Tests whether sql table exists.
    //*
    //* 

    function Sql_Table_Exists($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        if (!empty($this->ApplicationObj()->Tables[ $table ])) { return TRUE; }
        
        $query=$this->Sql_Table_Exists_Query($table);
        
        $res=FALSE;
        try
        {
            $res=$this->DB_Query($query,TRUE);
        }
        catch (Exception $e)
        {
            // We got an exception == table not found
            $res=FALSE;
        }

        if ($res) { $this->ApplicationObj()->Tables[ $table ]=TRUE; }
        
        return $res;
    }
    
    //*
    //* function Sql_Tables_Exists, Parameter list: $tables=array()
    //*
    //* Returns existen tables in $table. $table may be one table, a scalar.
    //*
    //* 

    function Sql_Tables_Exists($tables=array())
    {
        if (!is_array($tables)) { $tables=array($tables); }
        
        $rtables=array();
        foreach ($tables as $table)
        {
            if ($this->Sql_Table_Exists($table))
            {
                array_push($rtables,$table);
            }
        }

        return $rtables;
    }
}
?>