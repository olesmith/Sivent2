<?php

include_once("Table.php");

class Unique extends Table
{
    var $UniqueKeys=array();

    //*
    //* function Unicity, Parameter list: 
    //*
    //* Unicity constructor.
    //*

    function Unique($hash=array())
    {
        $this->InitBase($hash);
    }

    //*
    //* function ReadOrAdd, Parameter list: $where,$hash=array()
    //*
    //* Reads item, if already existent - otherwise adds it.
    //*

    function ReadOrAdd($hash=array())
    {
        $rwhere=array();
        foreach ($this->UniqueKeys as $key) { $rwhere[ $key ]=$hash[ $key ]; }

        $ritem=$this->SelectUniqueHash("",$rwhere,TRUE);
 
        if (empty($ritem))
        {
            $ritem=$hash;
            $res=$this->MySqlInsertItem("",$ritem);
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                if (empty($ritem[ $key ])) { $ritem[ $key ]=$value; }
            }
        }

        return $ritem;
    }
}

?>