<?php


trait Sql_Where
{
    //*
    //* function Sql_Where_IN, Parameter list: $values
    //*
    //* Formats where clause IN $values component.
    //* 

    function Sql_Where_IN($values)
    {
        if (empty($values)) { return ""; }

        //Remove empty values
        foreach ($values as $id => $value)
        {
            if (empty($value)) { unset($values[ $id ]); }
        }

        if (empty($values)) { return ""; }
        
        return
            "IN (".
            $this->Sql_Table_Column_Values_Qualify($values).
            ")";
        
    }
}
?>