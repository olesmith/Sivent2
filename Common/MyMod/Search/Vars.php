<?php


trait MyMod_Search_Vars
{
    //*
    //* function MyMod_Search_Var_Access, Parameter list: $data
    //*
    //* Detect whether we may search on var. Checks for access method.
    //*

    function MyMod_Search_Var_Access($data)
    {
        $res=True;
        if (!empty($this->ItemData[ $data ][ "SearchAccessMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "SearchAccessMethod" ];
            $res=$this->$method($data);
        }

        return $res;
    }
    
    //*
    //* function MyMod_Search_Vars, Parameter list: $datas=array()
    //*
    //* Detect search vars from ItemData.
    //*

    function MyMod_Search_Vars($datas=array())
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
                    if ($this-> MyMod_Search_Var_Access($data))
                    {
                        array_push($this->SearchVars,$data);
                    }
                }
            }
        }

        return $this->SearchVars;
    }
    

    //*
    //* function MyMod_Search_Var_Add, Parameter list: $data
    //*
    //* Marks $data as search var.
    //*

    function MyMod_Search_Var_Add($data)
    {
        $this->ItemData[ $data ][ "Search" ]=TRUE;
        if (!preg_grep('/^'.$data.'$/',$this->SearchVars)) { array_push($this->SearchVars,$data); }
    }
    
    //*
    //* function MyMod_Search_Var_Remove, Parameter list: $data
    //*
    //* Remove $data from search vars.
    //*

    function MyMod_Search_Var_Remove($data)
    {
        $this->ItemData[ $data ][ "Search" ]=TRUE;
        if (!preg_grep('/^'.$data.'$/',$this->SearchVars)) { array_push($this->SearchVars,$data); }
    }
    
    //*
    //* function MyMod_Search_Vars_Add_2_List, Parameter list: $datas
    //*
    //* Adds search vars to list of datas to read/display.
    //* Stores previous result in $this->MyMod_Search_Res_Vars (hash), and
    //* in case this is set, simply returns it.
    //*

    function MyMod_Search_Vars_Add_2_List($datas)
    {
        if (count($this->MyMod_Search_Res_Vars)>0)
        { 
            return array_merge($datas,$this->MyMod_Search_Res_Vars);
        }

        $searchvars=$this->MyMod_Search_Vars_Hash();

        $ressearchvars=array();
        foreach ($searchvars as $data => $value)
        {
            if (!preg_grep('/^'.$data.'$/',$datas))
            {
                if (empty($this->ItemData[ $data ][ "SqlMethod" ]))
                {
                    array_push($datas,$data);
                    array_push($ressearchvars,$data);
                }
            }
        }

        $this->MyMod_Search_Res_Vars=$ressearchvars;

        return $datas;
    }

    //*
    //* function MyMod_Search_Vars_Pre_Where, Parameter list: 
    //*
    //* Returns hash of pre search vars and their value, that is: 
    //* search vars which are actually INT's: INT and ENUM. These
    //* may be included with initial SELECT statement, as they
    //* are 'exact'.
    //*

    function MyMod_Search_Vars_Pre_Where()
    {
        $searchvars=array();
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            $wheres=array();
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);

                if (!empty($value))
                {
                    $where=$this->MyMod_Search_Var_Where($data,$value);
                    if (!empty($where))
                    {
                        array_push($wheres,$where);
                    }

                    $searchjoined=$this->ItemData($data,"Search_Joined");

                    if (is_array($searchjoined))
                    {
                        foreach ($searchjoined as $rdata)
                        {
                            if (!empty($this->ItemData[ $rdata ]))
                            {
                                array_push
                                (
                                    $wheres,
                                    $this->MyMod_Search_Var_Where($data,$value,$rdata)
                                );
                            }
                        }
                    }

                    $searchvars[ $data ]="(".join(" OR ",$wheres).")";
                }
            }
                    
        }

        return $searchvars;
    }
    
    //*
    //* function MyMod_Search_Vars_Post_Where, Parameter list: 
    //*
    //* Returns hash of pre search vars and their value, that is: 
    //* search vars which are actually INT's: INT and ENUM. These
    //* may be included with initial SELECT statement, as they
    //* are 'exact'.
    //*

    function MyMod_Search_Vars_Post_Where()
    {
        $searchvars=array();
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                if ($this->ItemData[ $data ][ "SqlMethod" ]!="")
                {
                }
                elseif (!preg_match('/^(ENUM|INT)$/',$this->ItemData[ $data ][ "Sql" ]))
                {
                    $rdata=$this->MyMod_Search_CGI_Name($data);
                    $value=$this->GetCGIVarValue($rdata);
                    if (!empty($value))
                    {
                        $searchvars[ $data ]=$this->Html2Sort($value);
                    }
                }
                elseif ($this->ItemData[ $data ][ "SqlTextSearch" ])
                {
                    $value=$this->MyMod_Search_CGI_Text_Value($data);
                    if ($value!='0')
                    {
                        $searchvars[ $data ]=$value;
                    }
                }
            }
        }

        return $searchvars;
    }
}

?>