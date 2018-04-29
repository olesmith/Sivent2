<?php

include_once("DB/Fetch.php");
include_once("DB/Method.php");
include_once("DB/MySql.php");
include_once("DB/MySqli.php");
include_once("DB/PDO.php");
include_once("DB/Query.php");

trait MyDB
{
    use
        DB_Fetch,
        DB_Method,
        DB_MySql,
        DB_MySqli,
        DB_PDO,
        DB_Query;

    //*
    //* function DB_Init, Parameter list: 
    //*
    //* Initializes mailing, if no.
    //*

    function DB_Init()
    {
        if ($this->DB && empty($this->DBHash[ "Link" ]))
        {
            $this->DBHash();
            //Moved to DBHash()
            //$this->DB_Connect();
        }
    }

    //*
    //* function DBHash, Parameter list: $key=""
    //*
    //* DBHash accessor. Reads once only.
    //*

    function DBHash($key="")
    {
        if (empty($this->ApplicationObj()->DBHash))
        {
            //Read DB definitions
            $this->ApplicationObj()->DBHash=$this->ReadPHPArray(".DB.php");

            //Then connect - or die
            $this->ApplicationObj()->DB_Connect();
        }

        if (!empty($key)) { return $this->ApplicationObj()->DBHash[ $key ]; }
        else              { return $this->DBHash; }
    }
    //*
    //* function DB_Connect, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function  DB_Connect()
    {
        $this->DBHash=$this->DB_Method_Call("Connect",$this->DBHash);
        $this->DB_Select($this->DBHash[ "DB" ]);

        if (method_exists($this,"PostOpenDB"))
        {
            $this->PostOpenDB();
        }
    }

    //*
    //* function DB_Select, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function  DB_Select()
    {
        if (!$this->Sql_DB_Exists($this->DBHash[ "DB" ]))
        {
            $this->Sql_DB_Create($this->DBHash);
        }

        if (!$this->Sql_DB_Exists($this->DBHash[ "DB" ]))
        {
            die("DB ".$this->DBHash[ "DB" ]." nonexistent or inaccessible");
        }

        $res=$this->DB_Method_Call("Select",$this->DBHash);
        if (!$res)
        {
            $this->DoDie("DB does not exist and unable to create<BR>\n",$this->DBHash);
        }

        return $res;
    }


    //*
    //* function DB_Close, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function  DB_Close()
    {
        $res=$this->DB_Method_Call("Close",$this->DBHash);

        $this->DBHash[ "Link" ]=NULL;
        return $res;
    }

    //*
    //* function DB_FreeResult, Parameter list: $result
    //*
    //* Frees $result.
    //*

    function  DB_FreeResult($result)
    {
        return $this->DB_Method_Call("FreeResult",$result);
    }

    
    //*
    //* function DB_Link, Parameter list: 
    //*
    //* Frees $result.
    //*

    function  DB_Link()
    {
        return $this->DBHash("Link");
    }
    
    //*
    //* function Sql_Dialect, Parameter list: 
    //*
    //* Returns SQL dialect, ie: mysql, pgsql, etc.
    //* 
    //* 

    function DB_Dialect()
    {
        return strtolower($this->DBHash("ServType"));
    }
    
    //*
    //* function Sql_MySql, Parameter list: 
    //*
    //* Returns true if we are mysql.
    //* 
    //* 

    function DB_MySql()
    {
        $res=FALSE;
        if (preg_match('/^mysql$/',$this->DBHash("ServType"))) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* function Sql_PostGres, Parameter list: 
    //*
    //* Returns true if we are postgres.
    //* 
    //* 

    function DB_PostGres()
    {
        $res=FALSE;
        if (preg_match('/^pgsql$/',$this->DBHash("ServType"))) { $res=TRUE; }

        return $res;
    }
}
?>