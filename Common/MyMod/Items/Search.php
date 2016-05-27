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
        if (empty($this->SearchVars))
        {
            $this->SearchVars=array();

            if (empty($datas)) { $datas=array_keys($this->ItemData); }

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

        $searchvars=$this->MyMod_Items_Search_Vars_Get($datas);
        if ($includeall==2) { $searchvars=array(); }

        $searchwhere="";
        if (!$nosearches && $includeall!=2)
        {
            $searchwhere=$this->GetSearchVarsWhere();
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
    //* function MyMod_Items_Search_IncludeAll_Field, Parameter list: 
    //*
    //* Creates the search form include all toggle.
    //*

    function MyMod_Items_Search_IncludeAll_Field()
    {
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