<?php

//include_once("Sql/Select.php");

trait Sql_Table_Fields_File
{
    //*
    //* function Sql_Table_Fields_File_Datas, Parameter list: $data=""
    //*
    //* Returns datas associated with file field.
    //* 
    //*

    function Sql_Table_Fields_File_Datas($data="")
    {
        $dialect=$this->DB_Dialect();
        $type="MEDIUMBLOB";
        if ($dialect=="pgsql") { $type="TEXT"; }
    
        $defs=array
        (
           "Empty" => array
           (
              "Sql" => "VARCHAR(256)",
           ),
           "OrigName" => array
           (
              "Sql" => "VARCHAR(256)",
           ),
           "Contents" => array
           (
            //"Sql" => "MEDIUMBLOB",
              "Sql" => $type,
           ),
           "Time" => array
           (
              "Sql" => "INT",
           ),
           "Size" => array
           (
              "Sql" => "INT",
           ),
        );
        
        return $defs;
    }
}


?>