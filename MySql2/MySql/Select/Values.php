<?php


class MySqlSelectValues extends MySqlSelectHash
{
    //*
    //* function MySqlItemValue, Parameter list: $table,$idvar,$id,$var,$noecho
    //*
    //* Returns value of var $var of item with key $idvar $id in table $table. 
    //*
    //* 

    function MySqlItemValue($table,$idvar,$id,$var,$noecho=FALSE)
    {
        return $this->Sql_Select_Hash_Value($id,$var,$idvar,$noecho,$table);
    }

    ///*
    //* function MySqlItemValues, Parameter list: $table,$idvar,$id,$vars,$noecho
    //*
    //* Returns values of vars $var of item with key $idvar $id in table $table. 
    //*
    //* 

    function MySqlItemValues($table,$idvar,$id,$vars,$noecho=FALSE)
    {
        return $this->Sql_Select_Hash_Values($id,$vars,$idvar,$noecho,$table);
    }

    ///*
    //* function MySqlItemsValue, Parameter list: $table,$idvar,$ids,$var,$noecho
    //*
    //* Returns a list of hashes of vars $var of item with key $idvar in list $ids in table $table. 
    //*
    //* 

    function MySqlItemsValue($table,$idvar,$ids,$var,$noecho=FALSE)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }

        $values=array();
        foreach ($ids as $id)
        {
            $values[ $id ]=$this->MySqlItemValue($table,$idvar,$id,$var,$noecho);
        }

        return $values;
    }

    ///*
    //* function MySqlItemsValues, Parameter list: $table,$idvar,$ids,$vars,$noecho
    //*
    //* Returns a list of hashes of vars $var of item with key $idvar in list $ids in table $table. 
    //*
    //* 

    function MySqlItemsValues($table,$idvar,$ids,$vars,$noecho=FALSE)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }

        $items=array();
        foreach ($ids as $id)
        {
            $items[ $id ]=$this->MySqlItemValues($table,$idvar,$id,$vars,$noecho);
        }

        return $items;
    }

    ///*
    //* function MySqlNEntries, Parameter list: $table,$where
    //*
    //* Returns number of entries, conforming to $where, in table $table.
    //*
    //* 

    function MySqlNEntries($table="",$where="")
    {
        return $this->Sql_Select_NEntries($where,$table);
    }
}


?>