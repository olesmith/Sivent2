<?php

include_once("Sort/Titles.php");
include_once("Sort/Items.php");
include_once("Sort/List.php");

trait MyMod_Sort
{
    use
        MyMod_Sort_Titles,
        MyMod_Sort_Items,
        MyMod_Sort_List;
    
    var $Sort=array("Name");
    var $Reverse=FALSE;

    //*
    //* function MyMod_Sort_Detect, Parameter list: $group=""
    //*
    //* Consider $group in detecting $sort value to use.
    //*

    function MyMod_Sort_Detect($group="")
    {
        $sort="";
        $reverse=$this->Reverse;

        if ($this->CGI_VarValue($this->ModuleName."_Sort")!="")
        {
            $sort=$this->CGI_VarValue($this->ModuleName."_Sort");
            $reverse=$this->CGI_VarValue($this->ModuleName."_Reverse");
        }

        if ($sort=="" && $group!="")
        {
            if (!empty($this->ItemDataGroups[ $group ][ "Sort" ]))
            {
                $sort=$this->ItemDataGroups[ $group ][ "Sort" ];
                $reverse=$this->ItemDataGroups[ $group ][ "Reverse" ];
            }
        }

        if ($sort) { $this->MyMod_Sort_Add($sort); }

        $this->Reverse=$reverse;

        return array($sort,$reverse);
    }

    //*
    //* function MyMod_Sort_Vars2Data, Parameter list: $datas=array()
    //*
    //* Returns effective search vars data list, adding to $datas.
    //* Uses $this->Sort, as string or list.
    //*

    function MyMod_Sort_Vars2Data($datas=array())
    {
        if (!is_array($this->Sort))
        {
            $this->Sort=array($this->Sort,"ID");
        }

        foreach ($this->Sort as $data)
        {
            if (!preg_grep('/^'.$data.'$/',$datas))
            {
                array_push($datas,$data);
            }
        }

        return $datas;
    }
    
    //*
    //* function MyMod_Sort_Add, Parameter list: $sort
    //*
    //* Unshifts $sort onto array $this->Sort - unless already in array.
    //*

    function MyMod_Sort_Add($sort)
    {
        if (!is_array($sort)) { $sort=array($sort); }

        foreach ($sort as $rsort)
        {
            if (!preg_grep('/'.$rsort.'/',$this->Sort))
            {
                array_unshift($this->Sort,$rsort);
            }
        }
    }
    
    //*
    //*
    //* function MyMod_Sort_Get, Parameter list: $sort=""
    //*
    //* Looks at $sort and cgivalue of Module sort var,
    //* returns first defined value - should be and array!
    //*

    function MyMod_Sort_Get($sort="")
    {
        if ($sort=="")
        {
            $sort=$this->Sort;
            $value=$this->CGI_VarValue($this->ModuleName."_Sort");
            if (!empty($value))
            {
                $sort=$value;
            }
        }

        return $sort;
    }
    
    //*
    //*
    //* function MyMod_Sort_Reverse_Get, Parameter list: $sort=""
    //*
    //* As GetSort, but reads cgivalue of module Reverse.
    //*

    function MyMod_Sort_Reverse_Get($reverse="")
    {
        $reverse=$this->Reverse;
        if ($reverse=="")
        {
            if ($this->GetCGIVarValue($this->ModuleName."_Reverse")!="")
            {
                $reverse=$this->GetCGIVarValue($this->ModuleName."_Reverse");
            }
            else
            {
                $reverse=FALSE;
            }
        }

        return $reverse;
    }
}

?>