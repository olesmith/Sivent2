<?php

trait Sql_Select_Hashes
{
    //*
    //* function Sql_Select_Hashes_Query, Parameter list: $where,$fields,$orderby="",$table=""
    //*
    //* Generates the SQL slect hashes query.
    //*
    //* 

    function Sql_Select_Hashes_Query($where="",$fields,$orderby="",$table="",$limit="")
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
            $query.=
                ' LIMIT '.$limit;
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

    function Sql_Select_Hashes($where="",$fieldnames=array(),$orderby="",$postprocess=FALSE,$table="",$limit="")
    {
        if (!$this->Sql_Table_Exists($table)) { return array(); }
        
        $this->LastSqlWhere=$this->Sql_Select_Hashes_Query($where,$fieldnames,$orderby,$table,$limit);
        $result = $this->DB_Query_2Assoc_List($this->LastSqlWhere);

        if ($result && $postprocess)
        {
            $this->PostProcessItemList($result);
        }

        return $result;
    }
    //*
    //* function Sql_Select_Hashes, Parameter list: $where,$fields,$orderby="",$postprocess=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_NHashes($where="",$table="")
    {
        $query=$this->Sql_Select_Hashes_Query($where,array("ID"),"",$table);
        
        $result = $this->DB_Query_2Assoc_List($query);
        $this->LastSqlWhere=$query;

        return count($result);
    }
    
    
    //*
    //* function Sql_Select_Hashes_ByID, Parameter list: $where,$fields,$bykey="ID",$orderby="",$postprocess=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_Hashes_ByID($where="",$fields=array(),$bykey="ID",$orderby="",$postprocess=FALSE,$table="")
    {
        return $this->MyHash_HashesList_2ID
        (
           $this->Sql_Select_Hashes($where,$fields,$orderby,$postprocess,$table),
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
}
?>