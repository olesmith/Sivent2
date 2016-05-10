<?php


trait Sql_Select_Calc
{
    //*
    //* function Sql_Select_Calc_Query, Parameter list: $where,$fields,$function="Sum",$table=""
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Calc_Query($where,$fields,$function="Sum",$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (!is_array($fields)) { $fields=array($fields); }
        
        foreach (array_keys($fields) as $id)
        {
            $fields[ $id ]=
                $function.
                "(".
                $this->Sql_Table_Column_Name_Qualify($fields[ $id ]).
                ")";
            
        }
        
        $query=
            'SELECT '.
            join(",",$fields).
            ' FROM '.
            $this->Sql_Table_Name_Qualify($table);
                                                 
        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }
       
        return $query;
    }
    
    //*
    //* function Sql_Select_Calc, Parameter list: $where,$fields,$function="Sum",$table=""
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Calc($where,$fields,$function="Sum",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        
        $single=FALSE;
        if (!is_array($fields)) { $fields=array($fields); $single=TRUE; }

        $res=$this->DB_Query_2Assoc_List($this->Sql_Select_Calc_Query($where,$fields,$function,$table));

        if (!empty($res)) { $res=array_shift($res); }

        $result=array();
        foreach ($fields as $field)
        {
            $rfield=
                $function.
                "(".
                //$this->Sql_Table_Name_Qualify
                //(.
                 $field.
                //).
                ")";
           if (!empty($res[ $rfield ]))
            {
                $result[ $field ]=$res[ $rfield ];
            }
        }

        if ($single) { $result=array_shift($result); }
           
        return $result;
    }
    ///*
    //* function Sql_Select_Calcs, Parameter list: $wheres,$fields,$table=""
    //*
    //* Sums entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Calcs($wheres,$fields,$function="Sum",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return array(); }

        $counts=array();
        
        foreach ($wheres as $wid => $where)
        {
            $counts[ $wid ]=$this->Sql_Select_Calc($where,$fields,$function,$table);
        }
        
        return $counts;
    }
}
?>