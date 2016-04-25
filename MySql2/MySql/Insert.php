<?php

class MySqlInsert extends MySqlQuery
{
    //*
    //* function InsertItem, Parameter list: $table,$item
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 
    //* 

    function MySqlInsertItem($table,&$item)
    {
        return $this->Sql_Insert_Item($item,$table);
    }

    //*
    //* function MySqlInsertUnique, Parameter list: $table,$where,&$item,$namekey="ID"
    //*
    //* Testt whether $item should be added or updated:
    //* If $this->SelectUniqueHash() returns an empty set, inserts.
    //* 

    function MySqlInsertUnique($table,$where,&$item,$namekey="ID")
    {
        return $this->Sql_Insert_Unique($where,$item,$table);
    }
}

?>