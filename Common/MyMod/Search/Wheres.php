<?php


trait MyMod_Search_Wheres
{
    //*
    //* function MyMod_Search_Where, Parameter list: $where=array(),$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=1
    //*
    //* Adds search vars to $where.
    //*

    function MyMod_Search_Where($where=array(),$datas=array(),$nosearches=FALSE,$includeall=1)
    {
        if ($this->NoSearches) { $nosearches=$this->NoSearches; }

        if ($this->MyMod_Search_CGI_Vars_Defined_Has()) { $nosearches=FALSE; }
        
        $searchwhere="";
        if (!$nosearches && $includeall!=2)
        {
            $searchwhere=$this->MyMod_Search_Vars_Where();
        }
        
        if ($includeall!=2)
        {
            foreach ($where as $key => $value)
            {
                $searchwhere[ $key ]=$value;
            }
        }

        return $searchwhere;
    }
    
    //*
    //* function MyMod_Search_Vars_Where, Parameter list: $searchvars=array()
    //*
    //* Search vars to search values;
    //*

    function MyMod_Search_Vars_Where($searchvars=array())
    {
        $values=$this->MyMod_Search_Vars_Pre_Where();
        if (count($searchvars)==0)
        {
            $searchvars=array_keys($values);
        }

        $wheres=array();
        foreach ($searchvars as $id => $data)
        {
            $where=$this->MyMod_Search_Var_Where($data,$values[ $data ]);
            if (!empty($where))
            {
                $where=preg_replace('/^'.$data.'=?\s+/',"",$where);
            }
            
            $rdata=$this->MyMod_Search_Var_Data($data);

            $wheres[ $rdata ]=$where;
        }

        

        return $wheres;
    }
    
    //*
    //* function MyMod_Search_Var_Data, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Data($data,$datavalues=array())
    {
        $rdata=$data;
        if (!empty($this->ItemData[ $data ][ "SqlMethod" ]))
        {
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
        }
        elseif (preg_match('/^(ENUM|INT)$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
        }
        elseif ($this->ItemData[ $data ][ "SearchCompound" ])
        {
        }
        else
        {
            $rdata="__".$data;
            if (is_array($datavalues))
            {
            }
            elseif (!preg_match('/LIKE/',$datavalues))
            {
            }
        }

        return $rdata;
    }

    
    //*
    //* function MyMod_Search_Var_Where, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Where($data,$datavalues=array(),$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
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
                    array_push
                    (
                        $ors,
                        $this->Sql_Table_Column_Name_Qualify($var).$i.
                        "='".$datavalues."'"
                    );
                }
            }
            elseif (!empty($this->ItemData[ $data ][ "Vars" ]))
            {
                foreach ($this->ItemData[ $data ][ "Vars" ] as $var)
                {
                    array_push
                    (
                        $ors,
                        $this->Sql_Table_Column_Name_Qualify($var).
                        "='".$datavalues."'"
                    );
                }
            }

            $where=$this->Sql_Where_Ors($ors);
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
                        array_push
                        (
                            $ors,
                            $this->Sql_Table_Column_Name_Qualify($rdata).
                            "='".$val."'"
                        );
                    }

                    $where=$this->Sql_Where_Ors($ors);
                }
            }
            elseif (!preg_match('/LIKE/',$datavalues))
            {
                if (preg_match('/[_%]/',$datavalues))
                {
                    $where=
                        "lower(".
                        $this->Sql_Table_Column_Name_Qualify($rdata).
                        ") ".
                        "LIKE lower('".$datavalues."')";         
                }
                elseif (!preg_match('/LIKE/',$datavalues))
                {
                    $where=
                        "lower(".
                        $this->Sql_Table_Column_Name_Qualify($rdata).
                        ") ".
                        "LIKE lower('%".$datavalues."%')";         
                }

                if (!empty($this->ItemData[ $data ][ "Languaged" ]))
                {
                    $rwheres=array($where);
                    foreach ($this->MyMod_Languaged_Data_Get($data) as $langdata)
                    {
                         array_push
                        (
                            $rwheres,
                            preg_replace('/lower\('.$data.'\)/','lower('.$langdata.')',$where)
                        );
                    }
                    
                    foreach ($this->MyMod_Languaged_Data_Get($rdata) as $langdata)
                    {
                         array_push
                        (
                            $rwheres,
                            preg_replace('/lower\('.$rdata.'\)/','lower('.$langdata.')',$where)
                        );
                    }

                    $where=$this->Sql_Where_Ors($rwheres);
                }
            }
            else
            {
                $where=$datavalues;         
            }
        }

        return $where;
    }
}

?>