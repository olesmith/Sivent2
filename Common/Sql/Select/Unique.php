<?php


trait Sql_Select_Unique
{
    //*
    //* function Sql_Select_Unique_Col_Values_Query, Parameter list: $col,$where=array(),$orderby="",$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_Values_Query($col,$where=array(),$orderby="",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return ""; }

        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $query=
            "SELECT ".
            $this->Sql_Table_Column_Name_Qualify($col).
            " FROM ".
            $this->Sql_Table_Name_Qualify($table);

        if (!empty($where)) { $query.=" WHERE ".$where; }
        
        if (!empty($orderby))
        {
            $query.=
                " ORDER BY ".
                $this->Sql_Table_Column_Names_Qualify($orderby);
        }
        
        return $query;
    }

    //*
    //* function Sql_Select_Unique_Col_Values, Parameter list: $col,$where=array(),$orderby="",$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_Values($col,$where=array(),$orderby="",$table="")
    {
        $query=$this->Sql_Select_Unique_Col_Values_Query($col,$where,$orderby,$table);

        $values=array();
        if (!empty($query))
        {
            $res=$this->DB_Query($query);
            foreach ($this->DB_Query_2Assoc_List($query) as $item)
            {
                $values[ $item[ $col ] ]=1;
            }
        }
        
        return array_keys($values);
    }

    
    //*
    //* function Sql_Select_Unique_Col_NValues, Parameter list: $col,$where,$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_NValues($col,$where,$table="")
    {
        return count
        (
            $this->Sql_Select_Unique_Col_Values($col,$where,"ID",$table)
        );
    }
}
?>