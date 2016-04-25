<?php


global $DBLinks;
$DBLinks=array();

class MySqlDB extends MySqlSystem
{
    //*
    //* function OpenDB, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function OpenDB()
    {
        return $this->DB_Open();
    }

    //*
    //* function CloseDB, Parameter list: $link
    //*
    //* Closes DB referenced in $link:
    //* 
    //* 

    function CloseDB($link)
    {
        $this->MysqlClose();
    }

    //*
    //* function GetDBList, Parameter list:
    //*
    //* Returns list of avaliable DBs.
    //* 
    //* 

    function GetDBList()
    {
        $result= $this->MysqlListDBs();

        $dbases=array();
        $m=0;
        while ($row = $this->FetchAssoc($result))
        {
            foreach ($row as $key => $value)
            {
                $dbases[$m]=$value;
            }

           $m++;
        }

        $this->FreeResult($result);

        return $dbases;
    }


}

?>