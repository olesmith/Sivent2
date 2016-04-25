<?php


class MySqlSelectUnique extends MySqlSelectWhere
{
    //*
    //* function MySqlUniqueColValues, Parameter list: $table,$col,$where="",$groupby="",$orderby=""
    //*
    //* Returns a list of unique column values in table $table. 
    //*
    //* 

    function MySqlUniqueColValues($table,$col,$where="",$groupby="",$orderby="")
    {
        return $this->Sql_Select_Unique_Col_Values($col,$where,$orderby,$table);
    }
}


?>