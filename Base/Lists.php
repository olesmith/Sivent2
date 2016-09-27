<?php

class Lists extends SqlQuery
{
    //*
    //* function MakeSureIsValue, Parameter list: &$list,$key,$value
    //*
    //* If not isset $list[ $key ], sets it to $value.
    //*

    function MakeSureIsValue(&$list,$key,$value)
    {
        if (!isset($list[ $key ]))
        {
            $list[ $key ]=$value;
        }
    }

    //*
    //* function SplitListPerKey, Parameter list: $list,$key
    //*
    //* Splits a list in sublists, using key $key
    //* 
    //*

    function SplitListPerKey($list,$key)
    {
        $sublists=array();
        foreach ($list as $id => $item)
        {
            $value=$item [ $key ];
            if (empty($sublists[ $value ]))
            {
                $sublists[ $value ]=array();
            }

            array_push($sublists[ $value ],$item);
        }

        return $sublists;
    }

    //*
    //* function ListKeyValues, Parameter list: $list,$key1,$key2=""
    //*
    //* Retrieves $key1 values of list of hashes.
    //* If $key2 given, descends two levels.
    //*

    function ListKeyValues($list,$key1,$key2="")
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            if (empty($key2))
            {
                $rlist[ $id ]=$list[ $id ][ $key1 ];
            }
            else
            {
                $rlist[ $id ]=$list[ $id ][ $key1 ][ $key2 ];
            }
        }

        return $rlist;
    }

    //*
    //* function ListUniqueValues, Parameter list: $list
    //*
    //* Returns unique values in $list.
    //*

    function ListUniqueValues($list)
    {
        $rlist=array();
        foreach ($list as $item) { $rlist[ $item ]=1; }

        return array_keys($rlist);
    }


    //*
    //* function ListKeyUniqueValues, Parameter list: $list,$key1,$key2=""
    //*
    //* Retrieves $key1 values of list of hashes, uniquely.
    //* If $key2 given, descends in two levels.
    //*

    function ListKeyUniqueValues($list,$key1,$key2="")
    {
        return $this->MyHash_HashesList_Values($list,$key1,$key2);
    }

    //*
    //* function ListByID, Parameter list: $list,$key1="ID",$key2=""
    //*
    //* Order list by ID $key1 values.
    //* If $key2 given, descends in two levels.
    //*

    function ListByID($list,$key1="ID",$key2="")
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            $rid=NULL;
            if (empty($key2))
            {
                $rid=$list[ $id ][ $key1 ];
            }
            else
            {
                $rid=$list[ $id ][ $key1 ][ $key2 ];
            }

            $rlist[ $rid ]=$list[ $id ];
        }

        return $rlist;
    }

    //*
    //* function ListsByID, Parameter list: $list,$key="ID"
    //*
    //* Order list in sublists by ID $key values.
    //*

    function ListsByID($list,$key="ID")
    {
        return $this->MyHash_HashesList_2IDs($list,$key);
    }

    //*
    //* function SublistKeyEqValue, Parameter list: $list,$key,$value
    //*
    //* Returns elements in $list, where $key eq $value.
    //* Maintains $list ids.
    //*

    function SublistKeyEqValue($list,$key,$value)
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            if ($list[ $id ][ $key ]==$value)
            {
                $rlist[ $id ]=$list[ $id ];
            }
        }

        return $rlist;
    }

    //*
    //* function PreKeyHashValues, Parameter list: $hash,$prekey,$rhash=array()
    //*
    //* Prepends $prekey to all $hash keys. Returns modified hash.
    //*

    function PreKeyHashValues($hash,$prekey,$rhash=array())
    {
        foreach (array_keys($hash) as $key)
        {
            $rhash[ $key ]=$prekey.$hash[ $key ];
        }

        return $rhash;
    }

    //*
    //* function PreKeyHash, Parameter list: $hash,$prekey,$rhash=array()
    //*
    //* Prepends $prekey to all $hash keys. Returns modified hash.
    //*

    function PreKeyHash($hash,$prekey,$rhash=array())
    {
        foreach (array_keys($hash) as $key)
        {
            $rhash[ $prekey.$key ]=$hash[ $key ];
        }

        return $rhash;
    }

    //*
    //* function HashByValue, Parameter list: $hash,$rhash=array()
    //*
    //* Returns hashed values.
    //*

    function HashByValue($hash,$rhash=array())
    {
        foreach (array_keys($hash) as $key)
        {
            $rhash[ $key ]=1;
        }

        return $rhash;
    }

    //*
    //* function JoinTables, Parameter list: $table1,$table2
    //*
    //* Tries to create a joined table, uniting rows.
    //*

    function JoinTables($table1,$table2)
    {
        $rows=array();
        $rows=$this->HashByValue($table1,$rows);
        $rows=$this->HashByValue($table2,$rows);
        $rows=array_keys($rows);

        $max1=$max2=0;
        foreach ($rows as $row)
        {
            if (!empty($table1[ $row ]))
            {
                $max1=$this->Max($max1,count($table1[ $row ]));
            }

            if (!empty($table2[ $row ]))
            {
                $max2=$this->Max($max2,count($table2[ $row ]));
            }
        }

        $table=array();
        foreach ($rows as $row)
        {
            $rrow=array();
            if (!empty($table1[ $row ]))
            {
                $rrow=array_merge($rrow,$table1[ $row ]);
            }
            else
            {
                array_push($rrow,$this->MultiCell("",$max1));
            }

            if (!empty($table2[ $row ]))
            {
                $rrow=array_merge($rrow,$table2[ $row ]);
            }
            else
            {          
                array_push($rrow,$this->MultiCell("",$max2));
            }
            array_push($table,$rrow);
        }

        return $table;
    }

    //*
    //* function PageArray, Parameter list: $list,$nlines,$leadingrows=array()
    //*
    //* Splits a list in sublists, with max of $nlines per item.
    //* Elements in $leadingrows is prepended in each sublists.
    //*

    function PageArray($list,$nlines,$leadingrows=array())
    {
        $lists=array(array());
        $nlists=0;
        foreach ($list as $item)
        {
            //if (!isset($lists[ $nlists ])) { $lists[ $nlists ]=array(); }

            array_push($lists[ $nlists ],$item);
            if (count($lists[ $nlists ])>=$nlines)
            {
                $nlists++;
                $lists[ $nlists ]=array();
            }
        }

        foreach ($lists as $id => $list)
        {
            array_splice($lists[ $id ],0,0,$leadingrows);
        }

        return $lists;
    }

     //*
    //* function BoldTableEvenCols, Parameter list: $table
    //*
    //* Assumes table with odd number of items, boldfaces even columns: 0,2,4.
    //*

    function BoldTableEvenCols($table)
    {
        foreach (array_keys($table) as $rid)
        {
            $bold=TRUE;
            foreach (array_keys($table[ $rid ]) as $cid)
            {
                if ($bold)
                {
                    $table[ $rid ][ $cid ]=$this->B($table[ $rid ][ $cid ]);
                    $bold=FALSE;
                }
                else
                {
                    $bold=TRUE;
                }
            }
        }

        return $table;
    }
}
?>