<?php


class SqlQuery extends SqlMessages
{
    /* //\* */
    /* //\* function Hash2SqlQuery, Parameter list: $argshash */
    /* //\* */
    /* //\* Deprecated, wrong naming. */
    /* //\* Should be Hash2SqlClause. Just calls this function below. */
    /* //\* */

    /* function Hash2SqlQuery($argshash) */
    /* { */
    /*     return $this->Hash2SqlClause($argshash); */
    /* } */

    //*
    //* function Hash2SqlClause, Parameter list: $argshash
    //*
    //* Creates and SQL query from a hash. Primary key list are
    //* converted to AND clauses - if values are scalars,
    //* just a simple key=val - if values are arrays,
    //* these converts to OR clauses. Fx:
    //* 
    //* Key1 => val1,
    //* Key2 => array(
    //*  val21,
    //*  val22
    //* )
    //*
    //* Converts to:
    //*
    //* Key1='val1' AND (Key2='val21' OR Key2='val22')
    //*

    /* function Hash2SqlClause0000000000($argshash) */
    /* { */
    /*     if (!is_array($argshash)) */
    /*     { */
    /*         $argshash=$this->SqlClause2Hash($argshash); */
    /*     } */

    /*     $ands=array(); */
    /*     foreach ($argshash as $arg => $value) */
    /*     { */
    /*         if (preg_match('/^_/',$arg)) */
    /*         { */
    /*              array_push($ands,$value); */
    /*         } */
    /*         elseif (is_array($value)) */
    /*         { */
    /*             $ors=array(); */
    /*             foreach ($value as $id => $rvalue) */
    /*             { */
    /*                 array_push($ors,$arg."='".$rvalue."'"); */
    /*             } */

    /*             $ors=join(" OR ",$ors); */
    /*             if (count($value)>1) */
    /*             { */
    /*                 $ors="(".$ors.")"; */
    /*             } */
    /*             array_push($ands,$ors); */
    /*         } */
    /*         elseif (!preg_match('/\s*(LIKE|IN)\s/',$value)) */
    /*         { */
    /*             array_push($ands,$arg."='".$value."'"); */
    /*         } */
    /*         else */
    /*         { */
    /*             array_push($ands,$arg." ".$value); */
    /*         } */
    /*     } */

    /*     return join(" AND ",$ands); */
    /* } */

    //*
    //* function SqlClause2Hash, Parameter list: $where
    //*
    //* Takes a simple SQL query and converts it to hash.
    //* Supports just simple list of AND clauses.
    //*

    function SqlClause2Hash($where)
    {
        if (preg_match('/^\((.*)\)$/',$where,$matches))
        {
            $where=$matches[1];
        }
        //23/02/2013 $where=preg_replace('/^\(/',"",$where);
        //23/02/2013 $where=preg_replace('/\)$/',"",$where);
        $ands=preg_split('/\s+AND\s+/',$where);

        $wheres=array();
        $k=0;
        foreach ($ands as $and)
        {
            if (preg_match('/^\(.*\)$/',$and))
            {
                $wheres[ "_".$k ]=$and;
                $k++;
            }
            elseif (!empty($and))
            {
                if (preg_match('/\s+OR\s+/',$and))
                {
                    $wheres[ "_or" ]="(".$and.")";
                }
                elseif (preg_match('/=/',$and))
                {
                    $comps=preg_split('/\s*=\s*/',$and);
                    $wheres[ $comps[0] ]=preg_replace('/\'/',"",$comps[1]);
                }
            }
        }

        return $wheres;
    }

}


?>