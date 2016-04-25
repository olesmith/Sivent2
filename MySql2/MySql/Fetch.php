<?php

class MySqlFetch extends MySqlTable
{
    //*
    //* function MySqlFetchArray, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchArray($result)
    {
        return mysql_fetch_array($result);
    }

    //*
    //* function MySqlFetchAssoc, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchAssoc($result)
    {
        return mysql_fetch_assoc($result);
    }


    //*
    //* function MySqlFetchResultArray, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchResultArray($result,$rowno=-1)
    {
        $res=array();
        while ($row = mysql_fetch_array($result))
        {
            if ($rowno>=0)
            {
               array_push($res,$row[$rowno]);
            }
            else
            {
               array_push($res,$row);
            }
        }
        
        return $res;
    }

    //*
    //* function MySqlFetchResultAssocList, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchResultAssocList($result,$fieldnames=array(),$byid=FALSE)
    {
        $rows=array();
        $m=0;
        while ($row = mysql_fetch_array($result))
        {
            $names[$m]=$row;
       
           $m++;
        }

        return $rows;
    }

    //*
    //* function MySqlFetchResultAssoc, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function MySqlFetchResultAssoc($result,$byid=FALSE)
    {
        $items=array();
        $m=0;
        while ($row=mysql_fetch_assoc($result))
        {
            $item=array();
            $id=0;
            $n=0;

            foreach ($row as $key => $value)
            {
                $item[ $key ]=$value;
                if ($key=="ID") { $id=$row[$key]; }
                $n++;
            }
      
            if ($byid)
            {
                $items[ $id ]=$item;
            }
            else
            {
                $items[$m]=$item;
            }

            $m++;
        }

        return $items;
    }

    //*
    //* function MySqlFetchResultAssocColumns, Parameter list: $result,$col
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchResultAssocColumns($result,$col)
    {
        $rows=array();
        $m=0;
        while ($row = mysql_fetch_assoc($result))
        {
            if (isset($row[ $col ]))
            {
                array_push($rows,$row[ $col ]);
            }
        }

        return $rows;
    }

    //*
    //* function MySqlFetchFirstEntry, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchFirstEntry($result)
    {
        $result=mysql_fetch_array($result);
        return $result[0];
    }

    //*
    //* function MySqlFetchNumFields, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function MySqlFetchNumFields($result)
    {
        return mysql_num_fields($result);
    }

    /* //\* */
    /* //\* function MySqlFetchField, Parameter list: $result,$i */
    /* //\* */
    /* //\* Performs MySql Queries, $query. Returns the raw results. */
    /* //\*  */
    /* //\*  */

    /* function MySqlFetchField($result,$i) */
    /* { */
    /*     return mysql_fetch_field($result,$i); */
    /* } */

}

?>