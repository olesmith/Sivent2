<?php

trait Sql_Tables
{
    //*
    //* function Sql_Tables_Select_Hashes, Parameter list: $regexp="",$where=array(),$datas=array()
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned.
    //* 
    //* 

    function Sql_Tables_Select_Hashes($regexp="",$where=array(),$datas=array())
    {
        $sqltables=$this->Sql_Table_Names($regexp);

        $items=array();
        foreach ($sqltables as $sqltable)
        {
            $ritems=$this->Sql_Select_Hashes
            (
               $where,
               $datas,
               "",
               FALSE,
               $sqltable
            );

            foreach (array_keys($ritems) as $id)
            {
                $ritems[ $id ][ "SQLTable" ]=$sqltable;
            }
            
            array_push($items,$ritems);
        }
 
        return $items;
    }
}
?>