<?php


trait Sql_DB
{
    var $DBs=array();
    
    //*
    //* function Sql_DBs_Get_Query, Parameter list: 
    //*
    //* Returns query for extracting databases on server.
    //* 

    function Sql_DBs_Get_Query()
    {
        $type=$this->DB_Dialect();

        $query="";
        if ($type=="mysql")
        {
            $query=
                "SHOW DATABASES";
        }
        elseif ($type=="pgsql")
        {
            $query=
                "SELECT datname FROM pg_database WHERE datistemplate = false;";
        }

        return $query;
    }

    //*
    //* function Sql_DBs_Get, Parameter list: 
    //*
    //* Return list of databases on server.
    //* 

    function Sql_DBs_Get()
    {
        if (empty($this->ApplicationObj()->DBs))
        {
            $query=$this->Sql_DBs_Get_Query();

            $results=$this->DB_Query_2Assoc_List($query);

            $this->ApplicationObj()->DBs=array();
            foreach ($results as $result)
            {
                foreach ($result as $key => $value)
                {
                    array_push($this->ApplicationObj()->DBs,$value);
                }
            }
        }
        
        return $this->ApplicationObj()->DBs;
    }


    //*
    //* function DB_Create_Query, Parameter list: 
    //*
    //* SQL query to create a DB.
    //*

    function  Sql_DB_Create_Query($db="")
    {
        if (empty($db)) { $db=$this->DBHash[ "DB" ]; }
        
        return "CREATE DATABASE IF NOT EXISTS ".$db;
    }
    

    //*
    //* function Sql_DB_Create, Parameter list: 
    //*
    //* Creates a DB.
    //*

    function  Sql_DB_Create($db="")
    {
        $query=$this->DB_Create_Query($db);
        $this->DB_Query($query);
    }
    
    //*
    //* function DB_Delete_Query, Parameter list: 
    //*
    //* SQL query to create a DB.
    //*

    function  Sql_DB_Delete_Query($db="")
    {
        if (empty($db)) { $db=$this->DBHash[ "DB" ]; }
        
        $query="DROB DATABASE IF EXISTS ".$db;
        return $query;
    }
    

    //*
    //* function Sql_DB_Delete, Parameter list: 
    //*
    //* Creates a DB.
    //*

    function  Sql_DB_Delete($db="")
    {
        $query=$this->DB_Delete_Query($db);
        $this->DB_Query($query);
    }
    
    
    //*
    //* function Sql_DB_Exists, Parameter list: $db=""
    //*
    //* Returns TRUE if $db exists and is acessible on server.
    //* 

    function Sql_DB_Exists($db="")
    {
        if (empty($db)) { $db=$this->DBHash[ "DB" ]; }

        $dbs=$this->Sql_DBs_Get();

        $res=FALSE;
        if (preg_grep('/^'.$db.'$/',$this->Sql_DBs_Get())) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* function Sql_DB_Info_Query, Parameter list: $table,$keys
    //*
    //* Returns query for extracting table info.
    //* 

    function Sql_DB_Info_Query($table,$keys=array("*"))
    {
        if (!is_array($keys)) { $keys=array($keys); }

        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        $query=
            "SELECT ".
            " ".join(",",$keys)." ".
            " FROM ".
            "INFORMATION_SCHEMA.TABLES WHERE ".
            "table_schema=".
            $this->Sql_DB_Column_Value_Qualify($this->DBHash[ "DB" ]).
            " AND ".
            "table_name=".
            $this->Sql_DB_Column_Value_Qualify($table).
            "";
        
        return $query;
    }
    
    //*
    //* function Sql_DB_Info, Parameter list: $table,$keys
    //*
    //* Returns query for extracting table info.
    //* 

    function Sql_DB_Info($table,$keys=array("*"))
    {
        $query=$this->Sql_DB_Info_Query($table,$keys);

        $result=$this->DB_Query
        (
           $this->Sql_DB_Info_Query($table,$keys)
        );
        
        $hash=$this->DB_Fetch_Assoc($result);
        $this->DB_FreeResult($result);

        $rhash=array();
        foreach ($hash as $key => $value)
        {
            $rhash[ strtolower($key) ]=$value;
        }

        return $rhash;
    }


    //*
    //* function Sql_DB_Info_Set_Time_Query, Parameter list: $table
    //*
    //* Returns query for extracting table info.
    //* 

    function Sql_DB_Info_Set_Time_Query($table)
    {
        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }
        $dialect=$this->DB_Dialect();
        

        $query="";
        if ($dialect=="mysql")
        {
            $query=
                "ALTER TABLE ".$table." COMMENT '".$this->MyMod_Data_Files_MTime()."'";
        }
        elseif ($dialect=="pgsql")
        {
            $query=
                "COMMENT ON TABLE ".$table." IS '".$this->MyMod_Data_Files_MTime()."'";
        }
        
        return $query;
    }
    
    //*
    //* function Sql_DB_Info_Set_Time, Parameter list: $table
    //*
    //* Updates $table info with data files mtime.
    //* 

    function Sql_DB_Info_Set_Time($table)
    {
        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }
        $query=$this->Sql_DB_Info_Set_Time_Query($table);
        
        $result=$this->DB_Query($query);
                
        return $this->MyMod_Data_Files_MTime();
    }
    
    
    
}
?>