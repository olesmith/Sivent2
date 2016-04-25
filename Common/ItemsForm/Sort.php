<?php

trait ItemsFormSort
{
    //*
    //* function ItemsForm_Sort, Parameter list:
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemsForm_Sort()
    {
        $sorts=$this->CGI_GET($this->ModuleName."_Sort");

        if (empty($sorts)) { $sorts=array(); }
        else               { $sorts=array($sorts); }

        $sorts=array_merge($sorts,$this->Args[ "DefaultSorts" ]);

        return $sorts;
    }

    //*
    //* function ItemsForm_SortItems, Parameter list:
    //*
    //* Returns hash with defaults for items form generation.
    //* 
    //*

    function ItemsForm_SortItems()
    {
        $reverse=$this->CGI_GET($this->ModuleName."_Reverse");
        $sorts=$this->ItemsForm_Sort();
        if (empty($sorts)) { return; }

        $filter="";
        foreach ($sorts as $sort)
        {
            if ($this->ItemData[ $sort ][ "Sql" ]=="INT")
            {
                $filter.=".#{%08d}".$sort."";
            }
            else
            {
                $filter.=".#".$sort."";
            }
        }

        $items=$this->Args[ "Items" ];

        $ritems=array();
        foreach ($this->Args[ "Items" ] as $item)
        {
            $sortkey=$this->FilterHash($filter,$item);
            $ritems[ $sortkey ]=$item;
        }

        $sortkeys=array_keys($ritems);
        sort($sortkeys);

        $this->Args[ "Items" ]=array();;
        foreach ($sortkeys as $sortkey)
        {
            array_push($this->Args[ "Items" ],$ritems[ $sortkey ]);
        }

        if ($reverse==1)
        {
            $this->Args[ "Items" ]=array_reverse($this->Args[ "Items" ]);
        }
    }
}

?>