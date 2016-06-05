<?php


class SearchVars extends SearchInit
{

   //*
    //* function AddSearchVar, Parameter list: $data
    //*
    //* Marks $data as search var.
    //*

    function AddSearchVar($data)
    {
        $this->ItemData[ $data ][ "Search" ]=TRUE;
        if (!preg_grep('/^'.$data.'$/',$this->SearchVars)) { array_push($this->SearchVars,$data); }
    }

    //*
    //* function RemovesSearchVar, Parameter list: $data
    //*
    //* UnMarks $data as search var.
    //*

    function RemoveSearchVar($data)
    {
        $this->ItemData[ $data ][ "Search" ]=FALSE;
        $this->SearchVars=preg_grep('/^'.$data.'$/',$this->SearchVars,PREG_GREP_INVERT);
    }


    //*
    //* function GetPreSearchVars, Parameter list: 
    //*
    //* Returns list of pre search vars and their value, that is: 
    //* search vars which are actually INT's: INT and ENUM. These
    //* may be included with initial SELECT statement, as they
    //* are 'exact'.
    //*

    function GetPreSearchVars()
    {
        $searchvars=array();
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);

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
    //* function GetPostSearchVars, Parameter list: 
    //*
    //* Returns list of post search vars and their value, that is: 
    //* search vars which are NOT INT's: INT and ENUM. These
    //* should be searched over in SearchItems.
    //*

    function GetPostSearchVars()
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
                    $rdata=$this->GetSearchVarCGIName($data);
                    $value=$this->GetCGIVarValue($rdata);
                    if (!empty($value))
                    {
                        $searchvars[ $data ]=$this->Html2Sort($value);
                    }
                }
                elseif ($this->ItemData[ $data ][ "SqlTextSearch" ])
                {
                    $value=$this->GetTextSearchVarCGIValue($data);
                    if ($value!='0')
                    {
                        $searchvars[ $data ]=$this->GetTextSearchVarCGIValue($data);
                    }
                }
            }
        }
        
        return $searchvars;
    }
    //*
    //* function AddSearchVarsToDataList, Parameter list: $datas
    //*
    //* Adds search vars to list of datas to read/display.
    //* Stores previous result in $this->ResSearchVars (hash), and
    //* in case this is set, simply returns it.
    //*

    function AddSearchVarsToDataList($datas)
    {
        if (count($this->ResSearchVars)>0)
        { 
            return array_merge($datas,$this->ResSearchVars);
        }

        $searchvars=$this->MyMod_Items_Search_Vars_Get();

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

        $this->ResSearchVars=$ressearchvars;

        return $datas;
    }

}


?>