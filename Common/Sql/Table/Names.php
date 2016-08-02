<?php

trait Sql_Table_Names
{
    //*
    //* function Sql_Table_Names_Query, Parameter list: 
    //*
    //* Returns list with the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Table_Names_Query()
    {
        $type=$this->DB_Dialect();
        $query="";
        if ($type=="mysql")
        {
            $query=
                "SELECT table_name FROM information_schema.tables WHERE ".
                "table_schema=".
                $this->Sql_Table_Column_Value_Qualify($this->DBHash[ "DB" ]);           }
        elseif ($type=="pgsql")
        {
            $query=
                "SELECT tablename FROM pg_tables WHERE ".
                "tablename NOT LIKE 'pg_%'";
        }
        
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
        $type=$this->DB_Dialect();
        $namekey='table_name';
        if ($type=="pgsql")
        {
            $namekey='tablename';
        }
        
        $query=$this->Sql_Table_Names_Query();

        $results=$this->DB_Query_2Assoc_List($query);

        $tables=array();
        foreach ($results as $result)
        {
            if (preg_match('/^sql_/',$result[ $namekey ])) { continue; }
            
            array_push($tables,$result[ $namekey ]);
        }

        if (!empty($regexp))
        {
            $tables=preg_grep('/'.$regexp.'/',$tables);
        }

        sort($tables);
        array_reverse($tables);


        return array_reverse($tables);
    }
}
?>