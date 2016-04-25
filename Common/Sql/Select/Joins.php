<?php


trait Sql_Select_Joins
{
    //*
    //* function Sql_Select_Join_Right, Parameter list: $where,$fields,$orderby="",$postprocess=FALSE
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //*
    //* 

    function Sql_Select_Join_Right($where="",$fields=array(),$orderby="",$postprocess=FALSE,$joins=FALSE)
    {
        $table=$this->SqlTableName();

        $where=$this->MySqlJoinsSubstWhere($table,$where,$fields);
        $orderby=$this->MySqlJoinsSubstString($table,$orderby,$fields);

        $rfieldnames=$this->MySqlJoinsDataFields($this->ModuleName,$table,$fields);
        $joins=$this->MySqlDataJoins($this->ModuleName,$table,$fields);

        if (!is_array($rfieldnames)) { $rfieldnames=array($rfieldnames); }

        $query=
            'SELECT '.
            join
            (
               ", ",
               $this->Sql_Table_Column_Names_Qualify($rfieldnames)
            ).
            ' FROM '.
            $this->Sql_Table_Name_Qualify($table).
            $this->ModuleName.
            "\n".
            join("\n",$joins);

        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }
        if (preg_match('/\S/',$orderby)) { $query.=' ORDER BY '.$orderby; }

        $result = $this->DB_Query_2Assoc_List($query);

        if ($result && $postprocess)
        {
            $this->PostProcessItemList($result);
        }

        return $result;
    }
}
?>