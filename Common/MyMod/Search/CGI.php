<?php

include_once("CGI/Name.php");
include_once("CGI/Text.php");
include_once("CGI/Hash.php");
include_once("CGI/IncludeAll.php");
include_once("CGI/Cookies.php");

trait MyMod_Search_CGI
{
    use
        MyMod_Search_CGI_Name,
        MyMod_Search_CGI_Text,
        MyMod_Search_CGI_Hash,
        MyMod_Search_CGI_IncludeAll,
        MyMod_Search_CGI_Cookies;
    
    //*
    //* function MyMod_Search_CGI_Value_Trim, Parameter list: $value
    //*
    //* Trims the search value read, that is:
    //*
    //* Removes accented characters
    //* Convert everything to lowercase.
    //*

    function MyMod_Search_CGI_Value_Trim($value)
    {
        $value=html_entity_decode($value,ENT_COMPAT,'UTF-8');
        $value=$this->Text2Sort($value);
        $value=strtolower($value);

        $value=
            preg_replace
            (
                '/[^\.]?\*/',
                ".*",
                strtolower
                (
                    $this->Text2Sort
                    (
                        html_entity_decode($value,ENT_COMPAT,'UTF-8')
                    )
                )
            );
        
        return $value;
    }
    

    
    
    //*
    //* function MyMod_Search_CGI_Vars_Defined_Has, Parameter list: 
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Vars_Defined_Has()
    {
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);
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
    //* function MyMod_Search_Vars_Hash, Parameter list: $datas=array()
    //*
    //* Returns list of allowed and defined search vars.
    //* If one or more search vars are defined, sets $this->IncludeAll
    //* to 0, in order NOT to read all items.
    //*

    function MyMod_Search_Vars_Hash($datas=array())
    {
        if (empty($datas)) { $datas=$this->MyMod_Search_Vars(); }

        $searchvars=array();
        foreach ($datas as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);
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
    //*
    //* Trims the search value read, that is:
    //*
    //* Returns CGI search edit value.
    //*

    function MyMod_Search_CGI_Edit_Value()
    {
        $val=$this->CGI_VarValue($this->ModuleName."_Edit");

        $default=1;
        if ($val=="") { $val=$default; }

        return $val;
    }

    //*
    //*
    //* Returns CGI search pressed name.
    //*

    function MyMod_Search_CGI_Pressed_Name()
    {
        return "SearchPressed";
    }
            
    //*
    //*
    //* Trims the search value read, that is:
    //*
    //* Returns CGI search pressed value.
    //*

    function MyMod_Search_CGI_Pressed_Value()
    {
        return
            $this->CGI_POSTint
            (
                $this->MyMod_Search_CGI_Pressed_Name()
            );
    }
    //*
    //*
    //* Trims the search value read, that is:
    //*
    //* Returns CGI search pressed value.
    //*

    function MyMod_Search_CGI_Pressed()
    {
        $searchpressed=$this->MyMod_Search_CGI_Pressed_Value();
        if ($searchpressed==1) { $searchpressed=TRUE; }
        else                   { $searchpressed =FALSE; }

        return $searchpressed;

    }
    
    //*
    //*
    //* Trims the search value read, that is:
    //*
    //* Returns CGI search pressed value.
    //*

    function MyMod_Search_CGI_Pressed_Hidden($value=1)
    {
        return $this->MakeHidden("SearchPressed",$value);            
    }
}

?>