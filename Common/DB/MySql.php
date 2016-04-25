<?php

trait DB_MySql
{
    //*
    //* function DB_MySql_Connect, Parameter list: $dbhash
    //*
    //* Connects to db
    //* 
    //* 

    function DB_MySql_Connect(&$dbhash)
    {
        $link=mysql_connect
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
    //* function DB_MySql_Close, Parameter list: $dbhash
    //*
    //* Close db.
    //* 
    //* 

    function DB_MySql_Close($dbhash)
    {
        mysql_close($dbhash[ "Link" ]);
    }

    //*
    //* function DB_MySql_Select, Parameter list: $dbhash
    //*
    //* Calls mysql_select_db
    //* 
    //* 

    function DB_MySql_Select($dbhash)
    {
        return mysql_select_db($dbhash[ "DB" ],$dbhash[ "Link" ]);
    }

    //*
    //* function DB_MySql_Query, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Calls mysql_select_db
    //* 
    //* 

    function DB_MySql_Query($query,$ignoreerror=FALSE)
    {
        $query.=";";
        $result = mysql_query($query,$this->DBHash[ "Link" ]);

        if (!$result && !$ignoreerror)
        {
            $message=
                $this->ModuleName.', Invalid query: ' . mysql_error() . "<BR><BR>\n".
                'Whole query: ' . $this->Sql_ShowQuery($query);

            $this->DoDie($message,$query);
        }

        return $result; 
     }

    //*
    //* function DB_MySql_Exec, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Calls mysql_select_db
    //* 
    //* 

    function DB_MySql_Exec($query,$ignoreerror=FALSE)
    {
        $this->DB_MySql_Query($query,$ignoreerror);
        
        return $this->DB_MySql_Update_NChanges(); 
     }


    //*
    //* function DB_MySql_FreeResult, Parameter list: $result
    //*
    //* Frees $result.
    //* 
    //* 

    function DB_MySql_FreeResult($result)
    {
        return mysql_free_result($result);
    }


    //*
    //* function DB_MySql_Fetch_Array, Parameter list: $result
    //*
    //* Fetches array.
    //* 
    //* 

    function DB_MySql_Fetch_Array($result)
    {
        return mysql_fetch_array($result);
    }


    //*
    //* function DB_MySql_Fetch_Assoc, Parameter list: $result
    //*
    //* Fetches associative array.
    //* 
    //* 

    function DB_MySql_Fetch_Assoc($result)
    {
        return mysql_fetch_assoc($result);
    }

    //*
    //* function DB_MySql_Fetch_Num_Rows, Parameter list: $result
    //*
    //* Calls num_rows.
    //* 
    //* 

    function DB_MySql_Fetch_Num_Rows($result)
    {
        return mysql_num_rows($result);
    }
    
    //*
    //* function DB_MySql_Fetch_Num_Fields, Parameter list: $result
    //*
    //* Calls num_rows.
    //* 
    //* 

    function DB_MySql_Fetch_Num_Fields($result)
    {
        return mysql_num_fields($result);
    }
        
    //*
    //* function DB_MySql_Fetch_Field, Parameter list: $result,$i
    //*
    //* Fetches array
    //* 
    //* 

    function DB_MySql_Fetch_Field($result,$i)
    {
        return mysql_fetch_field($result,$i);
    }


    //*
    //* function DB_MySql_Fetch_Assoc_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function DB_MySql_Fetch_Assoc_list($result,$byid=FALSE)
    {
        $items=array();

        if (is_bool($result)) { return $items; }
        
        $m=0;
        while ($row=mysql_fetch_assoc($result))
        {
            $item=array();
            $id=0;
            $n=0;

            foreach ($row as $key => $value)
            {
                $item[ $key ]=$value;
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
    //* function DB_MySql_Fetch_Array_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as arrays.
    //* 
    //* 

    function DB_MySql_Fetch_Array_list($result)
    {
        $items=array();
        $m=0;
        while ($row=mysql_fetch_array($result))
        {
            $items[$m]=$row;

            $m++;
        }

        return $items;
    }

    
    //*
    //* function DB_MySql_Insert_LastID(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_MySql_Insert_LastID()
    {
        return mysql_insert_id($this->DBHash[ "Link" ]);
    }
    
    //*
    //* function DB_MySql_Update_NChanges(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_MySql_Update_NChanges()
    {
        return mysql_affected_rows($this->DBHash[ "Link" ]);
    }
    
    //*
    //* function DB_MySql_Fetch_FirstEntry, Parameter list: $result
    //*
    //* Returns first entry in $result.
    //* 
    //* 

    function DB_MySql_Fetch_FirstEntry($result)
    {
        $result=mysql_fetch_array($result);
        return $result[0];
    }
}

?>