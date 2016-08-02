<?php

include_once("Sql/DB.php");
include_once("Sql/Table.php");
include_once("Sql/Tables.php");
include_once("Sql/Where.php");
include_once("Sql/Select.php");
include_once("Sql/Insert.php");
include_once("Sql/Update.php");
include_once("Sql/Delete.php");
include_once("Sql/Unique.php");

trait Sql
{
    use
        Sql_DB,
        Sql_Table,
        Sql_Tables,
        Sql_Where,
        Sql_Select,
        Sql_Insert,
        Sql_Update,
        Sql_Unique,
        Sql_Delete;

    //*
    //* function Sql_ShowQuery, Parameter list: $query
    //*
    //* Calls mysql_select_db
    //* 
    //* 

    function Sql_ShowQuery($query)
    {
        $query=preg_replace('/\s(FROM)\s/i',"<BR>$1 ",$query);
        $query=preg_replace('/\s(LEFT|RIGHT)\s/i',"<BR>$1 ",$query);
        $query=preg_replace('/\s(WHERE)\s/i',"<BR>$1 ",$query);
        $query=preg_replace('/\s(AS)\s/i',"<BR>$1 ",$query);
        $query=preg_replace('/,\s*/i'," ",$query);

        return $query;
    }

    
    //*
    //* function Sql_ListToIN, Parameter list: $values
    //*
    //* Creates proper IN SQL where clause part.
    //* 
    //* 

    function Sql_ListToIN($values)
    {
        return
            "IN ('".
            join
            (
               "','",
               $values
            ).
            "')";
    }

    
    //*
    //* function Sql_Log_Query, Parameter list: $query,$moreinfo=""
    //*
    //* Creates proper IN SQL where clause part.
    //* 
    //* 

    function Sql_Log_Query($query,$moreinfo="")
    {
        $type=preg_split('/\s+/',$query);
        $type=array_shift($type);
        $type=ucfirst(strtolower($type));

        if (!empty($moreinfo)) { $moreinfo=": ".$moreinfo; }
        
        $this->MyFile_Append
        (
           "Logs/Sql.".$type.".log",
           $this->TimeStamp2Text().": ".$query.$moreinfo
        );
    }
}
?>