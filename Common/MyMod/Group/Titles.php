<?php

trait MyMod_Group_Titles
{
    //*
    //* function MyMod_Data_Group_Titles, Parameter list: 
    //*
    //* Creates plural group items table title row.
    //*

    function MyMod_Data_Group_Titles($group,$datas=array(),$titles=array())
    {
        if (empty($titles))
        {
            $titles=$datas;
        }

        if (
            isset($this->ItemDataGroups[ $group ][ "NoTitleRow" ])
            &&
            $this->ItemDataGroups[ $group ][ "NoTitleRow" ]
           )
        {
            $titles=array();
        }

        return $titles;
    }
}

?>