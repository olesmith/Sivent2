<?php

trait DB_PDO
{
    //*
    //* function DB_PDO_Connect, Parameter list: $dbhash
    //*
    //* Connects to db
    //* 
    //* 

    function DB_PDO_Connect(&$dbhash)
    {
        $link=FALSE;
        try
        {
            $link=
                new PDO
                (
                    $dbhash[ "ServType" ].":".
                    "host=".$dbhash[ "Host" ].";".
                    "dbname=".$dbhash[ "DB" ].";",
                    $dbhash[ "User" ],
                    $dbhash[ "Password" ]
               );
        }

        catch (Exception $e)
        {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
            exit(1);
        }

        if (!$link)
        {
            $this->DoDie('PDO: Could not connect to server: '.$dbhash[ "Host" ]);
        }

        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbhash[ "Link" ]=$link;

        return $dbhash;
    }



    //*
    //* function DB_PDO_Closes, Parameter list: $dbhash
    //*
    //* Closes to db
    //* 
    //* 

    function DB_PDO_Close($dbhash)
    {
        $dbhash[ "Link" ]=NULL;
        unset($dbhash[ "Link" ]);
    }

    //*
    //* function DB_PDO_Select, Parameter list: $dbhash
    //*
    //* Calls mysqli_select_db
    //* 
    //* 

    function DB_PDO_Select($dbhash)
    {
        $query="";
        if ($dbhash[ "ServType" ]=="mysql")
        {
            $query="USE ".$dbhash[ "DB" ]."";            
        }
        elseif ($dbhash[ "ServType" ]=="pgsql")
        {
            $query="CONNECT '".$dbhash[ "DB" ]."'";
        }
        
        return $query;
    }

    //*
    //* function DB_PDO_Exec, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Executes mysql_select_db, returns no of changes.
    //* 
    //* 

    function DB_PDO_Exec($query,$ignoreerror=FALSE)
    {
        $query.=";";

        if ($ignoreerror) { return $this->DB_Link()->exec($query); }
        
        try
        {
            $result = $this->DB_Link()->exec($query);
        }
        
        catch (Exception $e)
        {
            $this->DoDie($this->ModuleName.', Invalid query #1:',$query,$this->DB_Link()->errorinfo());
        }

        return $result; 
     }
    
    //*
    //* function DB_PDO_Query_Html, Parameter list: $query
    //*
    //* Shows query, HTML.
    //* 
    //* 

    function DB_PDO_Query_Html($query)
    {
        $query=preg_replace('/\s*(UPDATE|SELECT|INSERT|DELETE|WHERE|SET|IN)\s*/i'," $1<BR>",$query);
        $query=preg_replace('/\s*,\s*/',"$1,<BR>",$query);
        $query=preg_replace('/\s*\(\s*/',"(<BR>",$query);
        $query=preg_replace('/\s*\)\s*/',"<BR>)",$query);
        $query=preg_replace('/(\S+)=/',"&nbsp;&nbsp;&nbsp;$1=",$query);

        return $query."<BR>";
    }
    
    //*
    //* function DB_PDO_Query, Parameter list: $query,$ignoreerror=FALSE
    //*
    //* Calls mysqli_select_db
    //* 
    //* 

    function DB_PDO_Query($query,$ignoreerror=FALSE)
    {
        $query.=";";

        if ($ignoreerror) { return $this->DB_Link()->query($query); }
        
        try
        {
            $result = $this->DB_Link()->query($query);
        }
        
        catch (Exception $e)
        {
            $this->CallStack_Show();
            echo
               $this->ModuleName.', Invalid query #2:<BR>'.
               $this->BR().$query.$this->BR().$this->BR().
               $this->DB_PDO_Query_Html($query).
                "";
                
            $this->DoDie
            (
               $this->ModuleName.', Invalid query #2',
               $this->DB_Link()->errorinfo()
            );
        }

        return $result; 
     }


    //*
    //* function DB_PDO_FreeResult, Parameter list: $result
    //*
    //* Frees $result.
    //* 
    //* 

    function DB_PDO_FreeResult($result)
    {
        return $result=NULL;
    }


    //*
    //* function DB_PDO_Fetch_Num_Rows, Parameter list: $result
    //*
    //* Calls num_rows.
    //* 
    //* 

    function DB_PDO_Fetch_Num_Rows($result)
    {
        return $result->rowCount();
    }
    
    //*
    //* function DB_PDO_Fetch_Num_Fields, Parameter list: $result
    //*
    //* Returns number of rows.
    //* 
    //* 

    function DB_PDO_Fetch_Num_Fields($result)
    {
        return $result->columnCount();
    }
    
    //*
    //* function DB_PDO_Fetch_Array, Parameter list: $result
    //*
    //* Fetches array.
    //* 
    //* 

    function DB_PDO_Fetch_Array($result)
    {
        return $result->fetch(PDO::FETCH_NUM);
    }


    //*
    //* function DB_PDO_Fetch_Assoc, Parameter list: $result
    //*
    //* Fetches associative array.
    //* 
    //* 

    function DB_PDO_Fetch_Assoc($result)
    {
        return $result->fetch(PDO::FETCH_ASSOC);
    }


    //*
    //* function DB_PDO_Fetch_Field, Parameter list: $result,$i
    //*
    //* Fetches array
    //* 
    //* 

    function DB_PDO_Fetch_Field($result,$i)
    {
        return $result->fetch(PDO::FETCH_OBJ,PDO::FETCH_ORI_NEXT,$i);
    }


    //*
    //* function DB_PDO_Fetch_Assoc_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function DB_PDO_Fetch_Assoc_list($result,$byid=FALSE,$lowercasekeys=FALSE)
    {
        $items=array();

        if (is_bool($result)) { return $items; }
        
        $m=0;
        while ($row=$result->fetch(PDO::FETCH_ASSOC))
        {
            $item=array();
            $id=0;
            $n=0;

            foreach ($row as $key => $value)
            {
                $rkey=$key;
                if ($lowercasekeys) { $rkey=strtolower($key); }
                
                $item[ $rkey ]=preg_replace('/ +/'," ",$value);
                $item[ $rkey ]=preg_replace('/^\s+/',"", $item[ $rkey ]);
                $item[ $rkey ]=preg_replace('/\s+$/',"", $item[ $rkey ]);
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
    //* function DB_PDO_Fetch_Array_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as arrays.
    //* 
    //* 

    function DB_PDO_Fetch_Array_list($result)
    {
        $items=array();
        $m=0;
        while ($row=$result->fetch(PDO::FETCH_NUM))
        {
            $items[$m]=$row;

            $m++;
        }

        return $items;
    }

    
    //*
    //* function DB_PDO_Insert_LastID(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_PDO_Insert_LastID()
    {
        $table=$this->SqlTableName();
        if (empty($table)) { return 0; }
        
        $table=$this->Sql_Table_Name_Qualify($table.'_ID_seq');
        return $this->DB_Link()->lastInsertId($table);
    }
    
    //*
    //* function DB_PDO_Update_NChanges(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_PDO_Update_NChanges()
    {
        return $this->DB_Link()->rowCount();
    }

    
    //*
    //* function DB_PDO_Fetch_FirstEntry, Parameter list: $result
    //*
    //* Returns first entry in $result.
    //* 
    //* 

    function DB_PDO_Fetch_FirstEntry($result)
    {
        $result=$result->fetch(PDO::FETCH_NUM);
        return $result[0];
    }
}

?>