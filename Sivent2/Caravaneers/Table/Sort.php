<?php


class Caravaneers_Table_Sort extends Caravaneers_Table_Rows
{
    //*
    //* function Caravaneers_Table_Sort, Parameter list: $caravaneers
    //*
    //* Puts caravaneers in status and subsequently alphabetical order.
    //*

    function Caravaneers_Table_Sort($caravaneers)
    {
        $sort=$this->MyHash_HashesList_Key($caravaneers,"Status");
        $statuses=array_keys($sort);
        sort($statuses,SORT_NUMERIC);

        $rcaravaneers=array();
        foreach ($statuses as $id => $status)
        {
            $statuscars=$sort[ $status ];

            $statuscars=$this->MyMod_Sort_List($statuscars,array("Name"));
            $rcaravaneers=array_merge($rcaravaneers,$statuscars);
        }
        
        return $rcaravaneers;
    }
}

?>