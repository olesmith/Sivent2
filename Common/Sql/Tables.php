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

            if (count($ritems)>0)
            {
                foreach (array_keys($ritems) as $id)
                {
                    $ritems[ $id ][ "SQLTable" ]=$sqltable;
                }
            
                array_push($items,$ritems);
            }
        }
 
        return $items;
    }
    
    //*
    //* function Sql_Tables_Items_Copy, Parameter list:)
    //*
    //* Copies all $items in $table.
    //* 
    //* 

    function Sql_Tables_Items_Copy($items,$table)
    {
        var_dump("SQL table: ".$table);
        foreach ($items as $item)
        {
            $this->Sql_Tables_Item_Copy($item,$table);
        }
    }
    
    //*
    //* function Sql_Tables_Item_Copy, Parameter list: 
    //*
    //* Copy $item into table.
    //* 
    //* 

    function Sql_Tables_Item_Copy($item,$table)
    {
        $ritem=$this->Sql_Select_Hash(array("ID" => $item[ "ID" ]));

        if (empty($ritem))
        {
            var_dump("Create: ".$item[ "ID" ]);
            var_dump($this->Sql_Insert_Item($item,$table,TRUE));
        }
        else
        {
            var_dump("Update: ".$item[ "ID" ]);
        }
        
    }
}
?>