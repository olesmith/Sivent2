<?php

include_once("MySql/Select.php");
include_once("MySql/Joins.php");
include_once("MySql/Table.php");
include_once("MySql/Fetch.php");
include_once("MySql/Query.php");
include_once("MySql/Insert.php");
include_once("MySql/Update.php");
include_once("MySql/Delete.php");
include_once("MySql/Structure.php");
include_once("MySql/System.php");
include_once("MySql/DB.php");


class MySql extends MySqlDB
{
    var $DBHash,$SqlTable;
    var $SqlTableVars=array();
    var $SqlWhere="";

    /* //\* */
    /* //\* function InitMySql, Parameter list: $hash */
    /* //\* */
    /* //\* Intializes MySql class. */
    /* //\* */
    /* //\*  */

    /* function InitMySql($hash) */
    /* { */
    /*     if ($this->DBHash[ "DB" ]!="") */
    /*     { */
    /*         $hash[ "DB" ]=$this->DBHash[ "DB" ]; */
    /*     } */

    /*     $this->DBHash=$hash; */

    /*     $this->OpenDB(); */
    /*     $this->PostOpenDB(); */
    /* } */

    /* //\* */
    /* //\* function PostOpenDB, Parameter list: */
    /* //\* */
    /* //\* Does nothing, use for overriding right after connection to DB. */
    /* //\* */
    /* //\*  */

    /* function PostOpenDB() */
    /* { */
    /* } */

    //*
    //* function SetDBName, Parameter list: 
    //*
    //* Sets dtabase name of class.
    //*

    function SetDBName()
    {
        $this->DBName=$this->DBHash[ "DB" ];

        return $this->DBName;
    }

    //*
    //* function Hash2MySql, Parameter list: $wherehash
    //*
    //* Converts hash to key='value''s and joins them with AND.
    //* Depecated? 18/02/2013
    //*
    //* 

    function Hash2MySql($wherehash)
    {
        $sqls=array();
        foreach ($wherehash as $key => $value)
        {
            array_push($sqls,$key."='".$value."'");
        }

        return join(" AND ",$sqls);
    }


    //*
    //* function DBTables, Parameter list: $like=""
    //*
    //* Returns list of tables in DB like $like.
    //*
    //* 

    function DBTables($like="")
    {
        $sql="SHOW TABLES";
        if (!empty($like))
        {
            $sql.=" LIKE '".$like."'";
        }

        $result=$this->QueryDB($sql);
        $res=$this->MySqlFetchResultArray($result,0);

        $this->DB_FreeResult($result);

        return $res;
    }
}

?>