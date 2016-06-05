<?php

trait Sql_Table_Fields_Exists
{
    //*
    //* function Sql_Table_Field_Exists, Parameter list: $data,$table=""
    //*
    //* Returns TRUE if field $data exists in $table.
    //* 
    //*

    function Sql_Table_Field_Exists($data,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $this->Sql_Table_Columns_Read($table);

        $exists=FALSE;
        if (!empty($this->ApplicationObj()->TablesColumns[ $table ][ $data ]))
        {
            $exists=TRUE;
        }
        
        return $exists;
    }

    //*
    //* Returns fields that exists in $datas.
    //* Used to eliminate non-cols, thus avoiding
    //* SQL errors.
    //*

    function Sql_Table_Fields_Exists($datas,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
       
        if ($datas=="*")
        {
            return array_keys($this->ApplicationObj()->TablesColumns[ $table ]);
        }
        
        $rdatas=array();
        foreach ($datas as $data)
        {
            if ($this->Sql_Table_Field_Exists($data,$table))
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }
}


?>