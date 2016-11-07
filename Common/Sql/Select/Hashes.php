<?php

trait Sql_Select_Hashes
{
    var $Sql_Select_Hashes_Unique_Col="ID";
    
    //*
    //* function Sql_Select_Hashes_Query, Parameter list: $where,$fields,$orderby="",$table=""
    //*
    //* Generates the SQL slect hashes query.
    //*
    //* 

    function Sql_Select_Hashes_Query($where="",$fields=array(),$orderby="",$table="",$limit="",$offset="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        if (empty($fields) || $fields=="*")
        {
            $fieldnames=array();
        }
        else
        {
            $fieldnames=$this->Sql_Table_Fields_Exists($fields,$table);
        }

        $type=$this->DB_Dialect();
        $dbstring="";
        if ($type=="mysql")
        {
            $dbstring=
                $this->Sql_Table_Name_Qualify($this->ApplicationObj()->DBHash[ "DB" ]).
                ".";
        }
        
         
        $query=
            'SELECT '.
            $this->Sql_Table_Column_Names_Qualify($fieldnames).
            ' FROM '.
            $dbstring.
            $this->Sql_Table_Name_Qualify($table).
            '';
        
        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }
        if (!empty($orderby))
        {
            $query.=
                ' ORDER BY '.
                $this->Sql_Table_Column_Names_Qualify($orderby);
        }
        
        if (!empty($limit))
        {
            $query.=' LIMIT '.$limit;
        }
        if (!empty($offset))
        {
            $query.=' OFFSET '.$offset;
        }

        return $query;
    }

    //*
    //* function Sql_Select_Hashes_Queries, Parameter list: $where,$fields,$orderby="",$table=""
    //*
    //* Generates several select queries, pone for each clause in $wheres.
    //*
    //* 

    function Sql_Select_Hashes_Queries($wheres,$fieldnames,$orderby="",$table="")
    {
        $queries=array();
        foreach ($wheres as $where)
        {
            array_push
            (
               $queries,
               $this->Sql_Select_Hashes_Query($where,$fieldnames,$orderby,$table)
            );
        }

        return $queries;
    }
    
    
    //*
    //* function Sql_Select_Hashes, Parameter list: $where,$fieldnames,$orderby="",$postprocess=FALSE,$table="",$limit=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_Hashes($where="",$fieldnames=array(),$orderby="",$postprocess=FALSE,$table="",$limit="",$offset="")
    {
        if (!$this->Sql_Table_Exists($table)) { return array(); }
        
        $this->LastSqlWhere=$this->Sql_Select_Hashes_Query($where,$fieldnames,$orderby,$table,$limit,$offset);
        $result = $this->DB_Query_2Assoc_List($this->LastSqlWhere);

        if ($result && $postprocess && method_exists($this,"PostProcessItemList"))
        {
            $this->PostProcessItemList($result);
        }

        return $result;
    }
    //*
    //* function Sql_Select_Hashes_Query, Parameter list: $where,$fields,$orderby="",$table=""
    //*
    //* Generates the SQL slect hashes query.
    //*
    //* 

    function Sql_Select_NHashes_Query($where="",$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $type=$this->DB_Dialect();
        $dbstring="";
        if ($type=="mysql")
        {
            $dbstring=
                $this->Sql_Table_Name_Qualify($this->ApplicationObj()->DBHash[ "DB" ]).
                ".";
        }
        
        //$fieldnames=array($fieldname);
        $query=
            'SELECT '.
            " COUNT(".$this->Sql_Table_Column_Names_Qualify($this->Sql_Select_Hashes_Unique_Col).")".
            ' FROM '.
            $dbstring.
            $this->Sql_Table_Name_Qualify($table).
            '';
        
        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }

        return $query;
    }


    //*
    //* function Sql_Select_NHashes, Parameter list: $where,$fields,$orderby="",$postprocess=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns number of matches aconforming to $where.
    //*
    //* 

    function Sql_Select_NHashes($where="",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        
        $query=$this->Sql_Select_NHashes_Query($where,$table);

        $result = $this->DB_Query_2Assoc_List($query);

        //var_dump($result);
        $this->LastSqlWhere=$query;

        $type=$this->DB_Dialect();
        if ($type=="mysql")
        {
            return $result[0][ 'COUNT('.$this->Sql_Select_Hashes_Unique_Col.')' ];
        }
        elseif ($type=="pgsql")
        {
            return $result[0][ 'count' ];
        }
    }
    
    
    //*
    //* function Sql_Select_Hashes_ByID, Parameter list: $where,$fields,$bykey="ID",$orderby="",$postprocess=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_Hashes_ByID($where="",$fields=array(),$bykey="ID",$orderby="",$postprocess=FALSE,$table="",$limit="",$offset="")
    {
        return $this->MyHash_HashesList_2ID
        (
           $this->Sql_Select_Hashes($where,$fields,$orderby,$postprocess,$table,$limit,$offset),
           $bykey
        );
    }
    
    //*
    //* function Sql_Select_IDs, Parameter list: $ids,$fields,$orderby=",$postprocess=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_IDs($ids,$fields,$orderby="",$postprocess=FALSE,$table="")
    {
        return $this->Sql_Select_Hashes
        (
           array
           (
              "ID" => "IN ('".join("', '",$ids)."')"
           ),
           $fields,
           $orderby,
           $postprocess,
           $table           
        );
    }
    
    //*
    //* function Sql_Select_Hashes_Has, Parameter list: $where,$table=""
    //*
    //* Returns TRUE, if a Select Hashes sdatement returns any hashes.
    //*
    //* 

    function Sql_Select_Hashes_Has($where=array(),$table="")
    {
        $n=$this->Sql_Select_NHashes($where,$table);

        $res=FALSE;
        if ($n>0)
        {
            $res=TRUE;
        }

        return $res;
    }
}
?>