<?php

trait Sql_Table_Qualify
{
    //*
    //* function Sql_Table_Name_Qualify, Parameter list: $table=""
    //*
    //* Quotes sql table name according to sql dialect.
    //*
    //* 

    function Sql_Table_Name_Qualify($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        $type=$this->DB_Dialect();
        
        $res=$table;
        if ($type=="mysql")
        {
            $res="`".$table."`";
        }
        elseif ($type=="pgsql" && preg_match('/[A-Z]/',$table))
        {
            $res='"'.$table.'"';
        }

        return $res;
   }
    
    //*
    //* function Sql_Table_Names_Qualify, Parameter list: $datas
    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Names_Qualify($tables)
    {
        if (!is_array($tables)) { $tables=array($tables); }
        
        $rtables=array();
        foreach ($tables as $table)
        {
            array_push($rtables,$this->Sql_Table_Name_Qualify($table));
        }

        return join(" ",$rtables);
   }
    
     //*
    //* function Sql_Table_Column_Name_Qualify, Parameter list: $data
    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Name_Qualify($data)
    {
        $type=$this->DB_Dialect();
        
        $res=$data;
        if ($type=="mysql")
        {
            $res=$data;
        }
        elseif ($type=="pgsql")
        {
            $res='"'.$data.'"';
        }

        return $res;
    }
    
    //*
    //* function Sql_Table_Column_Names_Qualify_List, Parameter list: $datas
    //*
    //* Quotes sql column name according to sql dialect, a.
    //* 
    //*
    //* 

    function Sql_Table_Column_Names_Qualify_List($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            array_push($rdatas,$this->Sql_Table_Column_Name_Qualify($data));
        }

        return $rdatas;
    }
    //*
    //* function Sql_Table_Column_Names_Qualify, Parameter list: $datas
    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Names_Qualify($datas)
    {
        if (empty($datas)) { return "*"; }
        
        if (!is_array($datas)) { $datas=preg_split('/\s*,\s*/',$datas); }
        
        return
            join
            (
               ", ",
               $this->Sql_Table_Column_Names_Qualify_List($datas)
            );
    }
    
    
    //*
    //* function Sql_Table_Column_Value_Qualify, Parameter list: $value
    //*
    //* Quotes sql column value according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Value_Qualify($value)
    {
        $type=$this->DB_Dialect();
        
        $res=$value;
        if ($type=="mysql")
        {
            $res="'".$value."'";
        }
        elseif ($type=="pgsql")
        {
            $res="'".$value."'";
        }

        return $res;
    }
    
    //*
    //* function Sql_Table_Column_Values_Qualify, Parameter list: $datas
    //*
    //* Quotes sql column values according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Values_Qualify($values)
    {
        if (!is_array($values)) { $values=array($values); }
        
        $rvalues=array();
        foreach ($values as $value)
        {
            array_push($rvalues,$this->Sql_Table_Column_Value_Qualify($value));
        }

        return join(", ",$rvalues);
   }
    
    
    //*
    //* function Sql_Table_Column_Name_Value_Qualify, Parameter list: $data,$value
    //*
    //* Quotes sql column $data=$value qualified according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Name_Value_Qualify($data,$value)
    {
        return
            $this->Sql_Table_Column_Name_Qualify($data).
            "=".
            $this->Sql_Table_Column_Value_Qualify($value);
    }
    
    //*
    //* function Sql_Table_Column_Hash_Qualify, Parameter list: $hash,$glue=" AND "
    //*
    //* Quotes sql column $data=$value qualified according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Hash_Qualify($hash,$glue=" AND ")
    {
        $wheres=array();
        foreach ($hash as $data => $value)
        {
            array_push($wheres,$this->Sql_Table_Column_Name_Value_Qualify($data,$value));
        }

        return join($glue,$wheres);
    }
    
}
?>