<?php


class MySqlSelectHashes extends Actions
{
    //*
    //* function SelectHashesFromTable, Parameter list: $table,$where,$fieldnames,$byid=FALSE,$orderby="",$postprocess=FALSE
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fieldnames or all data if $fieldnames is not an array.
    //*
    //* 

    function SelectHashesFromTable($table="",$where="",$fieldnames=array(),$byid=FALSE,$orderby="",$postprocess=FALSE)
    {
        return $this->Sql_Select_Hashes($where,$fieldnames,$orderby,$postprocess,$table);
        
        /* if (is_array($where)) { $where=$this->Hash2SqlWhere($where); } */
        /* if (empty($table)) { $table=$this->SqlTableName($table); } */

        /* $rfieldnames=$this->($table,$fieldnames); */

        /* if (is_array($rfieldnames)) { $rfieldnames=join(",",$rfieldnames); } */

        /* $rquery='SELECT '.$rfieldnames.' FROM `'.$table.'`'; */
        /* if (preg_match('/\S/',$where)) { $rquery.=' WHERE '.$where; } */
        /* if (preg_match('/\S/',$orderby)) { $rquery.=' ORDER BY '.$orderby; } */

        /* $result = $this->QueryDB($rquery); */

        /* $res=$this->MySqlFetchResultAssoc($result,$byid); */

        /* $this->DB_FreeResult($result); */

        /* if ($postprocess) */
        /* { */
        /*     $this->PostProcessItemList($res); */
        /* } */

        /* return $res; */
    }




    //*
    //* function MySqlRightJoin, Parameter list: $table,$where,$fieldnames,$byid=FALSE,$orderby="",$postprocess=FALSE
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fieldnames or all data if $fieldnames is not an array.
    //*
    //* 

    function MySqlRightJoin($table="",$where="",$fieldnames=array(),$byid=FALSE,$orderby="",$postprocess=FALSE,$joins=FALSE)
    {
        $table=$this->SqlTableName($table);

        $where=$this->MySqlJoinsSubstWhere($table,$where,$fieldnames);
        $orderby=$this->MySqlJoinsSubstString($table,$orderby,$fieldnames);

        $rfieldnames=$this->MySqlJoinsDataFields($this->ModuleName,$table,$fieldnames);
        $joins=$this->MySqlDataJoins($this->ModuleName,$table,$fieldnames);

        if (!is_array($rfieldnames)) { $rfieldnames=array($rfieldnames); }

        $rquery=
            'SELECT '.join(", ",$rfieldnames).' FROM `'.$table.'` '.$this->ModuleName.
            "\n".
            join("\n",$joins);

        if (preg_match('/\S/',$where)) { $rquery.=' WHERE '.$where; }
        if (preg_match('/\S/',$orderby)) { $rquery.=' ORDER BY '.$orderby; }

        $result = $this->QueryDB($rquery);

        $res=$this->MySqlFetchResultAssoc($result,$byid);

        $this->DB_FreeResult($result);

        if ($postprocess)
        {
            $this->PostProcessItemList($res);
        }

        return $res;
    }
}

?>