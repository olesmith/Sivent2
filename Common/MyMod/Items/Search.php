<?php


trait MyMod_Items_Search
{
    protected $SearchVars=array();

    //*
    //* function MyMod_Items_Search_Vars_Defined, Parameter list: 
    //*
    //* Determines, whether module CGI has search vars defined.
    //*

    function MyMod_Items_Search_Vars_Defined()
    {
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);
                $value=preg_replace('/\s+/',"",$value);
                if (!empty($value))
                {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }
    //*
    //* function MyMod_Items_Search_Vars, Parameter list: $datas=array()
    //*
    //* Detect search vars from ItemData.
    //*

    function MyMod_Items_Search_Vars($datas=array())
    {
        if (empty($this->ModuleName)) { return $this->SearchVars; }
        if (empty($this->SearchVars))
        {
            $this->SearchVars=array();

            if (empty($datas)) { $datas=array_keys($this->ItemData()); }

            foreach ($datas as $data)
            {
                if ($this->MyMod_Data_Field_Is_Search($data))
                {
                    array_push($this->SearchVars,$data);
                }
            }
        }

        return $this->SearchVars;
    }
    
    //*
    //* function MyMod_Items_Search_Vars_Get, Parameter list: $datas=array()
    //*
    //* Returns list of allowed and defined search vars.
    //* If one or more search vars are defined, sets $this->IncludeAll
    //* to 0, in order NOT to read all items.
    //*

    function MyMod_Items_Search_Vars_Get($datas=array())
    {
        if (empty($datas)) { $datas=$this->MyMod_Items_Search_Vars(); }

        $searchvars=array();
        foreach ($datas as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);
                if (is_array($value))
                {
                    if (count($value)>0)
                    {
                        $searchvars[ $data ]=$value;
                    }
                }
                elseif (!empty($value) && $value!=" 0")
                {
                    $searchvars[ $data ]=$value;
                }
            }
        }

        if (count($searchvars)>0)
        {
            $this->IncludeAll=0;
        }

        return $searchvars;
    }

    
    //*
    //* function MyMod_Items_Search_Where, Parameter list: $where=array(),$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=1
    //*
    //* Adds search vars to $where.
    //*

    function MyMod_Items_Search_Where($where=array(),$datas=array(),$nosearches=FALSE,$includeall=1)
    {
        if ($this->NoSearches) { $nosearches=$this->NoSearches; }

        if ($this->MyMod_Items_Search_Vars_Defined()) { $nosearches=FALSE; }
        
        $searchwhere="";
        if (!$nosearches && $includeall!=2)
        {
            $searchwhere=$this->MyMod_Items_Search_Vars_Where();
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
    //* function MyMod_Items_Search_Vars_Where, Parameter list: $searchvars=array()
    //*
    //* Search vars to search values;
    //*

    function MyMod_Items_Search_Vars_Where($searchvars=array())
    {
        $values=$this->GetPreSearchVars();
        if (count($searchvars)==0)
        {
            $searchvars=array_keys($values);
        }

        $wheres=array();
        foreach ($searchvars as $id => $data)
        {
            $where=$this->MyMod_Items_Search_Var_Where($data,$values[ $data ]);
            if (!empty($where))
            {
                $where=preg_replace('/^'.$data.'=?\s+/',"",$where);
            }
            
            $rdata=$this->MyMod_Items_Search_Var_Data($data);

            $wheres[ $rdata ]=$where;
        }

        return $wheres;
    }

    //*
    //* function MyMod_Items_Search_Var_Data, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Items_Search_Var_Data($data,$datavalues=array())
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
    //* function MyMod_Items_Search_Var_Where, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Items_Search_Var_Where($data,$datavalues=array())
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
                    $where=
                        "lower(".
                        $this->Sql_Table_Column_Name_Qualify($data).
                        ") ".
                        "LIKE lower('".$datavalues."')";         
                }
                elseif (!preg_match('/LIKE/',$datavalues))
                {
                    $where=
                        "lower(".
                        $this->Sql_Table_Column_Name_Qualify($data).
                        ") ".
                        "LIKE lower('%".$datavalues."%')";         
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
    //* function MyMod_Items_Search_IncludeAll_Field, Parameter list: 
    //*
    //* Creates the search form include all toggle.
    //*

    function MyMod_Items_Search_IncludeAll_Field()
    {
        if ($this->MyMod_Items_Search_Vars_Defined())
        {
            return $this->B($this->MyLanguage_GetMessage("IncludeAll_Inactive_Message"));
        }
        
        return
            $this->MakeRadioSet //($name,$values,$titles,$selected=-1)
            (
               $this->ModuleName."_IncludeAll",
               array(1,2),
               $this->MyLanguage_GetMessage("NoYes"),
               $this->CGI2IncludeAll()
            ).
            "";
    }
 }

?>