<?php

include_once("Table.php");

class Unicity extends Table
{    
    //*
    //* function Unicity, Parameter list: 
    //*
    //* Unicity constructor.
    //*

    function Unicity($hash=array())
    {
        $this->InitBase($hash);
    }

    //*
    //* function TestUnicity, Parameter list: 
    //*
    //* Tests unicity. Generates where clause with keys as in $uniquekeys and
    //* values as in $item. If there's another item satisfying this where,
    //* returns FALSE, TRUE otherwise.
    //*
    function TestUnicity($uniquekeys,$item)
    {
        $wheres=array();
        foreach ($uniquekeys as $key)
        {
            array_push($wheres,$key."='".$item[ $key ]."'");
        }

        $where=join(" AND ",$wheres);

        $ritems=$this->SelectHashesFromTable
        (
           "",
           $where,
           $uniquekeys
        );

        if (count($ritems)==0)
        {
            return TRUE;
        }

        return FALSE;
    }
}

?>