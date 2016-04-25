<?php


class MySqlSelectCalc extends MySqlSelectUnique
{
    ///*
    //* function MySqlSumNEntries, Parameter list: $table,$where,$fields
    //*
    //* Sums entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function MySqlSumNEntries($table,$where,$fields)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $data=$fields;
        if (!is_array($fields))
        {
            $fields=array($fields);
        }

        $items=$this->SelectHashesFromTable($table,$where,$fields);

        $counts=array();
        foreach ($fields as $field) { $counts[ $field ]=0; }

        foreach ($items as $item)
        {
            foreach ($fields as $field)
            {
                $counts[ $field ]+=$item[ $field ];
            }
        }

        if (is_array($data))
        {
            return $counts;
        }

        return $counts[ $data ];
    }

    ///*
    //* function RowAverage, Parameter list: $table,$where,$field
    //*
    //* Uses SQL to obtain average.
    //*
    //* 

    function RowAverage($table,$where,$field)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }
        if (!$this->Sql_Table_Exists($table)) { return NULL; }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $query="SELECT AVG(".$field.") FROM `".$table."` WHERE ".$where;
        $result = $this->QueryDB($query);

        $res=$this->DB_Fetch_FirstEntry($result);

        $this->DB_FreeResult($result);

        return $res;
    }

    ///*
    //* function RowFunc, Parameter list: $function,$table,$where,$field
    //*
    //* Uses SQL to obtain SQL $function value.
    //*
    //* 

    function RowFunc($function,$table,$where,$field)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $query="SELECT ".$function."(".$field.") FROM `".$table."` WHERE ".$where;
        $result = $this->QueryDB($query);

        $res=$this->DB_Fetch_FirstEntry($result);

        $this->DB_FreeResult($result);

        if (empty($res)) { $res=0; }

        return $res;
    }

    ///*
    //* function RowSum, Parameter list: $table,$where,$field
    //*
    //* Uses SQL to obtain sum.
    //*
    //* 

    function RowSum($table,$where,$field)
    {
        //return $this->RowFunc("SUM",$table,$where,$field);


        if ($table=="") { $table=$this->SqlTableName($table); }
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        if (!is_array($field)) { $field=array($field); }

        $sums=array();
        foreach ($field as $rfield) { array_push($sums,"SUM(".$rfield.")"); }


        $query=
            "SELECT ".join("+",$sums).
            " FROM `".$table."` WHERE ".$where;
        $result = $this->QueryDB($query);

        $res=$this->DB_Fetch_FirstEntry($result);

        $this->DB_FreeResult($result);

        if (empty($res)) { $res=0; }

        return $res;
    }

    ///*
    //* function RowMin, Parameter list: $table,$where,$field
    //*
    //* Uses SQL to obtain min value.
    //*
    //* 

    function RowMin($table,$where,$field)
    {
        return $this->RowFunc("MIN",$table,$where,$field);
    }
    ///*
    //* function RowMax, Parameter list: $table,$where,$field
    //*
    //* Uses SQL to obtain max value.
    //*
    //* 

    function RowMax($table,$where,$field)
    {
        return $this->RowFunc("MAX",$table,$where,$field);
    }
}


?>