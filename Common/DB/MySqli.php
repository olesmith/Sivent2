<?php

trait DB_MySqli
{
    //*
    //* function DB_MySqli_Connect, Parameter list: $dbhash
    //*
    //* Connects to db
    //* 
    //* 

    function DB_MySqli_Connect(&$dbhash)
    {
        $link=mysqli_connect
        (
           $dbhash[ "Host" ],
           $dbhash[ "User" ],
           $dbhash[ "Password" ]
        );

        if (!$link)
        {
            $this->DoDie('Could not connect to server: '.$dbhash[ "Host" ]);
        }

        $dbhash[ "Link" ]=$link;

        return $dbhash;
    }

    //*
    //* function DB_MySqli_Create, Parameter list: $dbhash
    //*
    //* Creates DB in $dbhash, tries to at the least.
    //* 
    //* 

    function DB_MySqli_Create($dbhash)
    {
        if (!$this->DB_MySqli_Exists($dbhash))
        {
            $query="CREATE DATABASE IF NOT EXISTS ".$dbhash[ "DB" ];
            $res=$this->QueryDB($query);

            if ($this->DB_MySqli_Exists($dbhash))
            {
                $res=TRUE;
            }
            else
            {
                $this->DoDie("No DB and unable to create!",$dbhash);
            }

            return $res;
        }
    }

    //*
    //* function DB_MySqli_Exists, Parameter list: $dbhash
    //*
    //* Tests if DB $dbname exists.
    //* 
    //* 

    function DB_MySqli_Exists($dbhash)
    {
        $query="SHOW DATABASES LIKE '".$dbhash[ "DB" ]."'";
        $result=$this->QueryDB($query);
        $res=$this->DB_Fetch_Assoc($result);

        $this->DB_MySqli_FreeResult($result);

        return $res;
    }

    //*
    //* function DB_MySqli_Closes, Parameter list: $dbhash
    //*
    //* Closes to db
    //* 
    //* 

    function DB_MySqli_Close($dbhash)
    {
        $this->DB_Link()->close();
    }

    //*
    //* function DB_MySqli_Select, Parameter list: $dbhash
    //*
    //* Calls mysqli_select_db
    //* 
    //* 

    function DB_MySqli_Select($dbhash)
    {
        return $this->DB_Link()->select_db($dbhash[ "DB" ]);
    }

    //*
    //* function DB_MySqli_Query, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Calls mysqli_select_db
    //* 
    //* 

    function DB_MySqli_Query($query,$ignoreerror=FALSE)
    {
        $query.=";";
        $result = $this->DB_Link()->query($query);

        if (!$result && !$ignoreerror)
        {
            $message=
                $this->ModuleName.', Invalid query: ' . mysqli_error($this->DB_Link()) . "<BR><BR>\n".
                'Whole query: ' . $this->Sql_ShowQuery($query);

            $this->DoDie($message,$query);
        }

        return $result; 
     }


    //*
    //* function DB_MySqli_FreeResult, Parameter list: $result
    //*
    //* Frees $result.
    //* 
    //* 

    function DB_MySqli_FreeResult($result)
    {
        return $result->free_result();
    }


    //*
    //* function DB_MySqli_Fetch_Num_Rows, Parameter list: $result
    //*
    //* Calls num_rows.
    //* 
    //* 

    function DB_MySqli_Fetch_Num_Rows($result)
    {
        return $result->num_rows;
    }
    
    //*
    //* function DB_MySqli_Fetch_Num_Fields, Parameter list: $result
    //*
    //* Returns number of rows.
    //* 
    //* 

    function DB_MySqli_Fetch_Num_Fields($result)
    {
        return $result->num_fields;
    }
    
    //*
    //* function DB_MySqli_Fetch_Array, Parameter list: $result
    //*
    //* Fetches array.
    //* 
    //* 

    function DB_MySqli_Fetch_Array($result)
    {
        return $result->fetch_array();
    }


    //*
    //* function DB_MySqli_Fetch_Assoc, Parameter list: $result
    //*
    //* Fetches associative array.
    //* 
    //* 

    function DB_MySqli_Fetch_Assoc($result)
    {
        return $result->fetch_assoc();
    }


    //*
    //* function DB_MySqli_Fetch_Field, Parameter list: $result,$i
    //*
    //* Fetches array
    //* 
    //* 

    function DB_MySqli_Fetch_Field($result,$i)
    {
        return $result->fetch_field($i);
    }


    //*
    //* function DB_MySqli_Fetch_Assoc_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function DB_MySqli_Fetch_Assoc_list($result,$byid=FALSE,$lowercasekeys=FALSE)
    {
        $items=array();

        if (is_bool($result)) { return $items; }
        
        $m=0;
        while ($row=$result->fetch_assoc())
        {
            $item=array();
            $id=0;
            $n=0;

            foreach ($row as $key => $value)
            {
                $rkey=$key;
                if ($lowercasekeys) { $rkey=strtolower($key); }
                
                $item[ $rkey ]=$value;
                if ($key=="ID") { $id=$row[$key]; }
                $n++;
            }
      
            if ($byid)
            {
                $items[ $id ]=$item;
            }
            else
            {
                $items[$m]=$item;
            }

            $m++;
        }

        return $items;
    }


    //*
    //* function DB_MySqli_Fetch_Array_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as arrays.
    //* 
    //* 

    function DB_MySqli_Fetch_Array_list($result)
    {
        $items=array();
        $m=0;
        while ($row=$this->DB_Link()->fetch_array($result))
        {
            $items[$m]=$row;

            $m++;
        }

        return $items;
    }

    
    //*
    //* function DB_MySqli_Insert_LastID(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_MySqli_Insert_LastID()
    {
        return $this->DB_Link()->insert_id;
    }
    
    //*
    //* function DB_MySqli_Update_NChanges(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_MySqli_Update_NChanges()
    {
        return $this->DB_Link()->affected_rows;
    }

    
    //*
    //* function DB_MySqli_Fetch_FirstEntry, Parameter list: $result
    //*
    //* Returns first entry in $result.
    //* 
    //* 

    function DB_MySqli_Fetch_FirstEntry($result)
    {
        $result=$result->fetch_array();
        return $result[0];
    }
}

?>