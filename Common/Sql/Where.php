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
    //*
    //* function Hash2SqlWhere, Parameter list: $hash
    //*
    //* Translates a hash to where clause, padded with AND's.
    //* Reverse: SqlClause2Hash.
    //*
    //* 

    function Hash2SqlWhere($hash,$pre="")
    {
        $where="";
        if (is_array($hash))
        {
            $wheres=array();
            foreach ($hash as $key => $value)
            {
                $prekey=$this->Sql_Table_Column_Name_Qualify($pre.$key);
                
                if (is_array($value))
                {
                    if (isset($value[ "Qualifier" ]))
                    {
                        array_push
                        (
                           $wheres,
                           $prekey.
                           " ".$value[ "Qualifier" ]." ".$value[ "Values" ]
                        );
                    }
                    else
                    {
                        array_push
                        (
                           $wheres,
                           $prekey.
                           " IN ('".join("', '",$value)."')"
                        );
                    }
                }
                elseif (preg_match('/\s*IN\s/i',$value))
                {
                    array_push($wheres,$prekey." ".$value);
                }
                elseif (preg_match('/^__/',$key))
                {
                    array_push($wheres,$value);
                }
                elseif (preg_match('/^\(.+\)$/',$value))
                {
                    array_push($wheres," ".$value);
                }

                
                elseif (preg_match('/\s+LE\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey."<=".$matches[1]);
                }
                elseif (preg_match('/\s+LT\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey."<".$matches[1]);
                }
                elseif (preg_match('/\s+GT\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey.">".$matches[1]);
                }
                elseif (preg_match('/\s+GE\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey.">=".$matches[1]);
                }
                elseif (preg_match('/\s+OR\s+(\S+)/',$value,$matches))
                {
                    array_push($wheres,"(".$value.")");
                }

                //Doesn't work, did above
                elseif (preg_match('/(>=?)\s/',$value,$matches))
                {
                    array_push($wheres,$prekey.$matches[1].$value);
                }
                elseif (preg_match('/(<=?)\s/',$value))
                {
                    array_push($wheres,$prekey.$matches[1].$value);
                }
                elseif (preg_match('/([%_])/i',$value))
                {
                    if (!preg_match('/\bLIKE\b/i',$value))
                    {
                        array_push($wheres,$prekey." LIKE '".$value."'");
                    }
                    else
                    {
                        array_push($wheres,$prekey." ".$value);
                    }
                }
                else
                {
                    array_push($wheres,$prekey."='".$value."'");
                }
            }

            $where=join(" AND ",$wheres);
        }

        return $where;
    }
}
?>