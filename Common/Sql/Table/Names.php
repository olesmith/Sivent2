<?php

trait Sql_Table_Names
{
    //*
    //* function Sql_Table_Names_Query, Parameter list: 
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Names_Query()
    {
        $query=
            "SELECT table_name FROM information_schema.tables WHERE ".
            "table_schema=".
            $this->Sql_Table_Column_Value_Qualify($this->DBHash[ "DB" ]);        
        return $query;
    }
    
    //*
    //* function Sql_Table_Names, Parameter list:$regexp=""
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Names($regexp="")
    {
        $query=$this->Sql_Table_Names_Query();

        $results=$this->DB_Query_2Assoc_List($query);

        $tables=array();
        foreach ($results as $result)
        {
            
            array_push($tables,$result[ "table_name" ]);
        }

        if (!empty($regexp))
        {
            $tables=preg_grep('/'.$regexp.'/',$tables);
        }

        return $tables;
    }
}
?>