<?php

global $Queries;
$Queries=array();
$Queries=NULL;

class MySqlQuery extends MySqlFetch
{
   //*
    //* function MysqlListDBs, Parameter list: 
    //*
    //* Calls mysql_list_dbs.
    //* 
    //* 

    function MysqlListDBs()
    {
        return mysql_list_dbs($this->DBHash[ "Link" ]);
    }

    //*
    //* function GetInsertID, Parameter list: 
    //*
    //* Performs MySql Query, $query. Returns the raw result.
    //* 
    //* 

    function GetInsertID()
    {
        return mysql_insert_id($this->DBHash[ "Link" ]);
    }

    //*
    //* function MySqlError, Parameter list: 
    //*
    //* Prints last mysql erro message.
    //* 
    //* 

    function MySqlError($message)
    {
        die($message.": ".mysql_error());
    }

    //*
    //* function QueryDB, Parameter list: $query,$ignore=FALSE
    //*
    //* Performs MySql Query, $query. Returns the raw result.
    //* 
    //* 

    function QueryDB($query,$ignore=FALSE)
    {
        return $this->DB_Query($query,$ignore);
        /* $query.=";"; */
        /* $result = mysql_query($query,$this->DBHash[ "Link" ]); */

        /* if (!$result && !$ignore) */
        /* { */
        /*     $message  = $this->ModuleName.', Invalid query: ' . mysql_error() . "<BR><BR>\n"; */

        /*     $query=preg_replace('/\s(FROM)\s/i',"<BR>$1 ",$query); */
        /*     $query=preg_replace('/\s(LEFT|RIGHT)\s/i',"<BR>$1 ",$query); */
        /*     $query=preg_replace('/\s(WHERE)\s/i',"<BR>$1 ",$query); */
        /*     $query=preg_replace('/\s(AS)\s/i',"<BR>$1 ",$query); */
        /*     $message .= 'Whole query: ' . $query; */

        /*     $this->Debug=1; */
        /*     if ($this->Debug==1) */
        /*     { */
        /*         $this->ApplicationObj()->CallStack_Show(); */
        /*     } */

        /*     $this->AddMsg($message,10); */
        /*     die($message); */
        /* } */

        /* return $result;  */
    }

    //*
    //* function QueriesDB, Parameter list: $queries
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function QueriesDB($queries)
    {
        $results=array();
        for ($n=0;$n<count($queries);$n++)
        {
            array_push($results,$this->QueryDB($queries[ $n ]));
        }

        return $results;
    }
}

?>