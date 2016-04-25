<?php

class SearchWheres extends SearchTable
{
    //*
    //* function GetSearchVarWhere, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, based on $data and 
    //*

    function GetSearchVarWhere($data,$datavalues=array())
    {
        $where="";
        if (!empty($this->ItemData[ $data ][ "SqlMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "SqlMethod" ];
            $where=$this->$method($data,$datavalues);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            if ($this->ItemData[ $data ][ "SearchCheckBox" ])
            {
                if (!empty($datavalues))
                {
                    $where=$datavalues;
                }
            }
            else
            {
                $where=$datavalues;
            }
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $delta=0;
            if ($datavalues==1)
            {
                $delta=60;                
            }
            elseif ($datavalues==2)
            {
                $delta=60*60;                
            }
            elseif ($datavalues==3)
            {
                $delta=60*60*24;                
            }
            elseif ($datavalues==4)
            {
                $delta=60*60*24*7;                
            }
            elseif ($datavalues==5)
            {
                $delta=60*60*24*30;                
            }
            elseif ($datavalues==6)
            {
                $delta=60*60*24*365;                
            }

            if ($delta>0)
            {
                $delta=time()-$delta;
                $where.=" LE '".$delta."'";
            }
        }
        elseif (preg_match('/^(ENUM|INT)$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
            $datavalues=intval($datavalues);
            if (!empty($datavalues))
            {
                $where=$datavalues;
                if (preg_match('/[_%]/',$datavalues))
                {
                    $where=" LIKE '".$datavalues."'";
                }
            }
        }
        elseif ($this->ItemData[ $data ][ "SearchCompound" ])
        {
            if (!empty($this->ItemData[ $data ][ "Var" ]))
            {
                $var=$this->ItemData[ $data ][ "Var" ];

                $ors=array();
                for ($i=1;$i<=$this->ItemData[ $data ][ "NVars" ];$i++)
                {
                    array_push($ors,$var.$i."='".$datavalues."'");
                }
            }
            elseif (!empty($this->ItemData[ $data ][ "Vars" ]))
            {
                foreach ($this->ItemData[ $data ][ "Vars" ] as $var)
                {
                    array_push($ors,$var."='".$datavalues."'");
                }
            }

            $where="(".join(" OR ",$ors).")";
        }
        else
        {
            if (is_array($datavalues))
            {
                if (count($datavalues)>0)
                {
                    $ors=array();
                    foreach ($datavalues as $no => $val)
                    {
                        array_push($ors,$data."='".$val."'");
                    }

                    $orwhere=join(" OR ",$ors);
                    if (count($ors)>1)
                    {
                        $orwhere="(".$orwhere.")";
                    }
                    $where=$orwhere;
                }
            }
            elseif (!preg_match('/LIKE/',$datavalues))
            {
                if (preg_match('/[_%]/',$datavalues))
                {
                    $where=" LIKE '".$datavalues."'";         
                }
                elseif (!preg_match('/LIKE/',$datavalues))
                {
                    $where=" LIKE '%".$datavalues."%'";         
                }
            }
            else
            {
                $where=$datavalues;         
            }
        }

        return $where;
    }


   //*
    //* function GetSearchVarsWhere, Parameter list: $searchvars=array()
    //*
    //* Generates pre sql search vars where, that is for  all data in
    //* $searchvars (or all search data, if empty), $data=$value
    //* pairs for all ENUM and SQL types.
    //*

    function GetSearchVarsWhere($searchvars=array())
    {
        $values=$this->GetPreSearchVars();
        if (count($searchvars)==0)
        {
            $searchvars=array_keys($values);
        }
        
        $wheres=array();
        foreach ($searchvars as $id => $data)
        {
            $where=$this->GetSearchVarWhere($data,$values[ $data ]);
            if (!empty($where))
            {
                $where=preg_replace('/^'.$data.'=?\s+/',"",$where);
                /* if (preg_match('/\s(OR|LIKE)\s/',$where)) */
                /* { */
                /*     $wheres[ "__".$data ]=$where; */
                /* } */
                /* else */
                /* { */
                    $wheres[ $data ]=$where;
                /* } */

            }
        }

        return $wheres;
    }
}


?>