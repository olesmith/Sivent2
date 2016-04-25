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
        return
            "IN (".
            $this->Sql_Table_Column_Values_Qualify($values).
            ")";
        
    }
}
?>