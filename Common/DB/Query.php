<?php


trait DB_Query
{
    //var $DB_Debug=TRUE;
    var $DB_Regex=""; //everything
    var $DB_Queries=array();
    
    //*
    //* function DB Exec, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Performs MySql query, $query. Returns the raw results.
    //* 
    //* 

    function DB_Exec($query,$ignoreerror=FALSE)
    {
        if ($this->ApplicationObj()->DBHash[ "Debug" ] && preg_match('/'.$this->DB_Regex.'/',$query))
        {
            $caller=$this->CallStack_Caller(4);
            array_push
            (
                $this->ApplicationObj()->DB_Queries,
                array
                (
                   $this->ModuleName,
                   $caller[ 'function' ],
                   $query
                )
            );
        }
        
        return $this->DB_Method_Call("Exec",$query,$ignoreerror);
    }
    
    //*
    //* function DB Query, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Performs MySql query, $query. Returns the raw results.
    //* 
    //* 

    function DB_Query($query,$ignoreerror=FALSE)
    {
        if ($this->ApplicationObj()->DBHash[ "Debug" ] && preg_match('/'.$this->DB_Regex.'/',$query))
        {
            $caller=$this->CallStack_Caller(4);
            array_push
            (
                $this->ApplicationObj()->DB_Queries,
                array
                (
                   $this->ModuleName,
                   $caller[ 'function' ],
                   $query
                )
            );
        }
        
        return $this->DB_Method_Call("Query",$query,$ignoreerror);
    }

    //*
    //* function DB Queries_Exec, Parameter list: $queries,$ignoreerror=FALSE
    //*
    //* Just execs queries, $queries. Returns nothing.
    //* 
    //* 

    function DB_Queries_Exec($queries,$ignoreerror=FALSE)
    {
        foreach ($queries as $id => $query)
        {
            $this->DB_Query($query,$ignoreerror);
        }
    }
    
    //*
    //* function DB_Queries, Parameter list: $queries,,$fetch="Assoc_List",$ignoreerror=FALSE
    //*
    //* Performs queries, $queries. Returns the raw results.
    //* 
    //* 

    function DB_Queries($queries,$fetch="Assoc_List",$ignoreerror=FALSE)
    {
        $fetchmethod="DB_Query_2".$fetch;
        
        $res=array();
        foreach ($queries as $id => $query)
        {
            $result = $this->$fetchmethod($query,$ignoreerror);
        }
        
        return $res;
    }

    //*
    //* function DB_Query2Array, Parameter list: $query
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Query_2Array($query,$ignoreerror=FALSE)
    {
        $result = $this->DB_Query($query);
        $res=$this->DB_Fetch_Array($result);

        $this->DB_Method_Call("FreeResult",$result);

        return $res;
    }

    //*
    //* function DB_Query_2Assoc, Parameter list: $query
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Query_2Assoc($query,$ignoreerror=FALSE)
    {
        $result = $this->DB_Query($query);
        $res=$this->DB_Fetch_Assoc($result);

        $this->DB_Method_Call("FreeResult",$result);

        return $res;
    }

    //*
    //* function DB_Query_2Assoc_List, Parameter list: $query
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Query_2Assoc_List($query,$ignoreerror=FALSE)
    {
        $result = $this->DB_Query($query);
        $res=$this->DB_Fetch_Assoc_List($result);

        $this->DB_Method_Call("FreeResult",$result);

        return $res;
    }


    //*
    //* function DB_Query_2Array_List, Parameter list: $query
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Query_2Array_List($query,$ignoreerror=FALSE)
    {
        $result = $this->DB_Query($query);
        $res=$this->DB_Fetch_Array_List($result);

        $this->DB_Method_Call("FreeResult",$result);

        return $res;
    }
}
?>