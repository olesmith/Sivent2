<?php


trait MyMod_Search_Vars
{
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
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);

                if (!empty($value))
                {
                    $searchvars[ $data ]=$this->MyMod_Items_Search_Var_Where($data,$value);
                    if (empty($searchvars[ $data ])) { unset($searchvars[ $data ]); }
                    
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
        foreach ($this->MyMod_Items_Search_Vars() as $data)
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