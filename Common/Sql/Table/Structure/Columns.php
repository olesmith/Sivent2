<?php

trait Sql_Table_Structure_Columns
{
    //*
    //* function Sql_Table_Columns_Info_Query, Parameter list: $table,$keys
    //*
    //* Returns info query, fetching info for all columns.
    //* 

    function Sql_Table_Columns_Info_Query($table,$keys)
    {
        if (!is_array($keys)) { $keys=array($keys); }

        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $hash=
            array
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
            $hash[ 'table_catalog' ]=$this->DBHash("DB");
        }

        
        $query=
            "SELECT ".
            " ".join(",",$keys)." ".
            " FROM ".
            "INFORMATION_SCHEMA.COLUMNS WHERE ".
            $this->Sql_Table_Column_Hash_Qualify($hash).
            "";

        return $query;
    }
    
    //*
    //* function Sql_Table_Columns_Hashes, Parameter list: $table,$keys="*"
    //*
    //* Returns all column info hashes from query.
    //* 

    function Sql_Table_Columns_Hashes($table,$keys="*")
    {
        $type=$this->DB_Dialect();

        $lowercasekeys=FALSE;
        if ($type=="mysql") { $lowercasekeys=TRUE; }
        
        $hashes=$this->DB_Query_2Assoc_List($this->Sql_Table_Columns_Info_Query($table,$keys),FALSE,$lowercasekeys);
        $type=$this->DB_Dialect();

          
        /* $this->DB_FreeResult($result); */

        $rhashes=array();
        foreach ($hashes as $id => $hash)
        {
            
            if (!isset($hash[ 'column_name' ])) { var_dump($hash); }
            
            $column=$hash[ 'column_name' ];
            if (empty($hash))
            {
                var_dump("Sql_Table_Column_Hash: Internal error: Col ".$table.".".$column." does not exist");
            }

            $rhashes[ $column ]=array();
            foreach ($hash as $key => $value)
            {
                $rhashes[ $column ][ strtolower($key) ]=$value;
            }
        }

        return $rhashes;
    }
    
    //*
    //* function Sql_Table_Column_Info, Parameter list: $table=""
    //*
    //* Return column info. Unified 'ANSI'.
    //* 

    function Sql_Table_Columns_Info($table="")
    {
        $hashes=array();
        foreach ($this->Sql_Table_Columns_Hashes($table) as $column => $hash)
        {
            foreach ($hash as $key => $value)
            {
                $rkey=$key;
                if (isset($this->Column_2_Info[ $this->DB_Dialect() ][ $key ]))
                {
                    $rkey=$this->Column_2_Info[ $this->DB_Dialect() ][ $key ];
                }

                $hashes[ $column ][ $rkey ]=$value;
            }
        }

        return $hashes;
    }
}
?>