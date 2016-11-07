<?php

trait MyMod_Handle_Export_Defaults
{    
    var $Export_Defaults=
        array
        (
            "NFields" => 3,
            "Data" => array
            (
                1 => "No",
                2 => "ID",
                3 => "Name",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "0",
                3 => "1",
            ),
                
        );
    
    //*
    //* function MyMod_Handle_Export_Defaults, Parameter list: 
    //*
    //* Defaults variables for Export form.
    //*

    function MyMod_Handle_Export_Defaults($type="",$n=0)
    {
        if (!empty($type))
        {
            if (!empty($n))
            {
                if (!empty($this->Export_Defaults[ $type ][ $n ]))
                {
                    return $this->Export_Defaults[ $type ][ $n ];
                }
                else { return ""; }
                
            }
            
            if (!empty($this->Export_Defaults[ $type ]))
            {
                return $this->Export_Defaults[ $type ];
            }
            else { return ""; }
        }

        return $this->Export_Defaults;
    }
}
?>