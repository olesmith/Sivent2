<?php

class FileFieldsStructure extends TimeFields
{
    /* var $FileFieldData=array */
    /* ( */
    /*    "Empty" => array */
    /*    ( */
    /*       "Sql" => "VARCHAR(256)", */
    /*    ), */
    /*    "OrigName" => array */
    /*    ( */
    /*       "Sql" => "VARCHAR(256)", */
    /*    ), */
    /*    "Contents" => array */
    /*    ( */
    /*       "Sql" => "MEDIUMBLOB", */
    /*    ), */
    /*    "Time" => array */
    /*    ( */
    /*       "Sql" => "INT", */
    /*    ), */
    /*    "Size" => array */
    /*    ( */
    /*       "Sql" => "INT", */
    /*    ), */
    /* ); */

    
    //*
    //* function AddDBFileField, Parameter list: $table,$data,$datadef)
    //*
    //* Adds file field of name $data to table.
    //* 
    //*

    function AddDBFileField($table,$data,$datadef)
    {
        $this->Sql_Table_Field_Add_File($data,$datadef,$table);
    }
}

?>