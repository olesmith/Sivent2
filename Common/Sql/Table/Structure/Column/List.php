<?php


trait Sql_Table_Structure_Column_List
{     
    //*
    //* function Sql_Table_Structure_Columns_Get, Parameter list: $table=""
    //*
    //* Returns list of column names in $table. Protected read.
    //* 

    function Sql_Table_Structure_Columns_Get($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (empty($this->ApplicationObj()->TablesColumns[ $table ]))
        {
            $this->Sql_Table_Columns_Read($table);
        }

        return array_keys($this->ApplicationObj()->TablesColumns[ $table ]);
    }
    

    //*
    //* function Sql_Table_Columns_Names_Where, Parameter list:
    //*
    //* Returns where for column names in $table.
    //* 

    function Sql_Table_Columns_Names_Where($table="")
    {
        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        $hash=array
        (
           'table_name' => $table,
        );
        
        $type=$this->DB_Dialect();

        $query="";
        if ($type=="mysql")
        {
            $hash[ 'table_schema' ]=$this->DBHash("DB");
        }
        elseif ($type=="pgsql")
        {
            //$hash[ 'table_catalog' ]=$this->DBHash("DB");
        }

        return $hash;
    }

    
    //*
    //* function Sql_Table_Columns_Names_Query, Parameter list: $table
    //*
    //* Returns query for column names in $table.
    //* 

    function Sql_Table_Columns_Names_Query($table)
    {
         return
            "SELECT ".
            " column_name ".
            " FROM ".
            "INFORMATION_SCHEMA.COLUMNS".
            " WHERE ".
            $this->Sql_Table_Column_Hash_Qualify
            (
               $this->Sql_Table_Columns_Names_Where($table)
            ).
            "";
        
        return $query;
    }
    
    //*
    //* function Sql_Table_Columns_Names, Parameter list: $table=""
    //*
    //* Returns list of column names in $table.
    //* 

    function Sql_Table_Columns_Names($table="")
    {
        $query=$this->Sql_Table_Columns_Names_Query($table);
        $result=$this->DB_Query($query);

        $fieldnames=array();
        while ($row=$this->DB_Fetch_Assoc($result))
        {
            array_push($fieldnames,$row[ "column_name" ]);
        }  

        $this->DB_FreeResult($result);

        return $fieldnames;
    }
}
?>