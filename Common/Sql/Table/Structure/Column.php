<?php

include_once("Column/List.php");
include_once("Column/Read.php");
include_once("Column/Rename.php");

trait Sql_Table_Structure_Column
{
    use
        Sql_Table_Structure_Column_List,
        Sql_Table_Structure_Column_Read,
        Sql_Table_Structure_Column_Rename;
    
    var $Column_2_Info=array
    (
       'mysql' => array
       (
       ), 
       'pgsql' => array
       (
       ), 
    );
    
    var $Type_2_ANSI=array
    (
       'mysql' => array
       (
        //"enum" => 'int',
       ),
       'pgsql' => array
       (
          "character varying" => 'varchar',
          "integer" => 'int',
       ), 
    );    
    
    //*
    //* function Sql_Table_Column_Info_Query, Parameter list: $column,$table,$keys
    //*
    //* Returns the data fields in table $table in current DB,
    //* as a hash.
    //* 

    function Sql_Table_Column_Info_Query($column,$table,$keys)
    {
        if (!is_array($keys)) { $keys=array($keys); }

        //We need it here!
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $hash=
            array
            (
               'table_name' => $table,
               'column_name' => $column,
            );
        
        $type=$this->DB_Dialect();

        $query="";
        if ($type=="mysql")
        {
            $hash[ 'table_schema' ]=$this->DBHash("DB");
        }
        elseif ($type=="pgsql")
        {
            $hash[ 'table_catalog' ]=$this->DBHash("DB");
        }

        
        $query=
            "SELECT ".
            " ".join(",",$keys)." ".
            " FROM ".
            "INFORMATION_SCHEMA.COLUMNS WHERE ".
            $this->Sql_Table_Column_Hash_Qualify($hash).
            "";

        return $query;
    }
    
    //*
    //* function Sql_Table_Column_Hash, Parameter list: $column,$table,$keys="*"
    //*
    //* Returns the data fields in table $table in current DB,
    //* as a hash.
    //* 

    function Sql_Table_Column_Hash($column,$table,$keys="*")
    {
        $result=$this->DB_Query
        (
           $this->Sql_Table_Column_Info_Query($column,$table,$keys)
        );

        $hash=$this->DB_Fetch_Assoc($result);
        $this->DB_FreeResult($result);

        if (empty($hash))
        {
            var_dump("Sql_Table_Column_Hash: Internal error: Col ".$table.".".$column." does not exist");
        }

        $rhash=array();
        foreach ($hash as $key => $value)
        {
            $rhash[ strtolower($key) ]=$value;
        }
        
        //print join("<BR>",array_keys($rhash))."<BR><BR>";

        return $rhash;
    }
    
    //*
    //* function Sql_Table_Column_Info, Parameter list: $column,$table=""
    //*
    //* Return column info. Unified 'ANSI'.
    //* 

    function Sql_Table_Column_Info($column,$table="")
    {
        $hash=array();
        foreach ($this->Sql_Table_Column_Hash($column,$table) as $key => $value)
        {
            $rkey=$key;
            if (isset($this->Column_2_Info[ $this->DB_Dialect() ][ $key ]))
            {
                $rkey=$this->Column_2_Info[ $this->DB_Dialect() ][ $key ];
            }

            $hash[ $rkey ]=$value;
        }

        return $hash;
    }
    
    //*
    //* function Sql_Table_Column_Info_2_Default, Parameter list: $hash
    //*
    //* Return column info. Unified 'ANSI'.
    //* 

    function Sql_Table_Column_Info_2_Default($hash)
    {
        $hash[ "column_default" ]=preg_replace('/::.*/',"",$hash[ "column_default" ]);
        $hash[ "column_default" ]=preg_replace('/\'/',"",$hash[ "column_default" ]);

        return $hash[ "column_default" ];
    }

    
    //*
    //* function Sql_Table_Column_Info_2_Type, Parameter list: $hash
    //*
    //* Return column info. Unified 'ANSI'.
    //* 

    function Sql_Table_Column_Info_2_Type($hash)
    {
        return $hash[ "column_type" ];
    }

    //*
    //* function Sql_Table_Column_Info_2_Length, Parameter list: $hash
    //*
    //* Return column info. Unified 'ANSI'.
    //* 

    function Sql_Table_Column_Info_2_Length($hash)
    {
        return $hash[ "character_maximum_length" ];
    }

     
    //*
    //* function Sql_Table_Column_Type, Parameter list: $column,$table=""
    //*
    //* Return standardized colun type, incl. eventual length.
    //* 

    function Sql_Table_Column_Type($column,$table="")
    {
        $dialect=$this->DB_Dialect();
        
        $keys=array("*");
        if ($dialect=="pgsql")
        {
            $keys=array("data_type","character_maximum_length");
        }
        
        $hash=$this->Sql_Table_Column_Hash($column,$table,$keys);

        $type="";
        if ($dialect=="mysql")
        {
            //20160328 $type=$hash[ "Type" ];
            $type=$hash[ "column_type" ];
        }
        elseif ($dialect=="pgsql")
        {
            $type=$hash[ "data_type" ];
        }
        
        $type=strtolower($type);
        if (isset($this->Type_2_ANSI[ $dialect ][ $type ]))
        {
            $type=$this->Type_2_ANSI[ $dialect ][ $type ];
        }

        if (!empty($hash[ "character_maximum_length" ]))
        {
            $type.="(".$hash[ "character_maximum_length" ].")";
        }

        return $type;
    }
}
?>