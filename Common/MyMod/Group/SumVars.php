<?php

trait MyMod_Group_SumVars
{
    //*
    //* function MyMod_Group_SumVar_Items_Sum, Parameter list: $items,$data
    //*
    //* Sums the variables.
    //* 

    function MyMod_Group_SumVar_Items_Sum($items,$data)
    {
        $sum=0;
        foreach ($items as $item)
        {
            if (isset($item[ $data ]))
            {
                $sum+=$item[ $data ];
            }
        }

        return $sum;
    }
    
    //*
    //* function MyMod_Group_Items_SumVars_Sum, Parameter list: ($items,$datas=array())
    //*
    //* Sums list of sumvars.
    //* 

    function MyMod_Group_SumVars_Items_Sum($items,$datas=array())
    {
        if (empty($datas)) { $datas=$this->SumVars; }
        
        $sums=array();
        foreach ($datas as $data)
        {
            $sums[ $data ]=$this->MyMod_Group_SumVar_Items_Sum($items,$data);

        }

        return $sums;
    }
    
    //*
    //* function MyMod_Group_SumVars_Row, Parameter list: $datas,$sums
    //*
    //* Creates sumvar row as list. Data summed are listed in $this->SumVars and summed above in $sums.
    //* 

    function MyMod_Group_SumVars_Row($datas,$sums)
    {
        $row=array();
        foreach ($datas as $data)
        {
            $value="&nbsp;";
            if ($data=="No")               { $value=$this->B("&Sigma;"); }
            elseif (isset($sums[ $data ])) { $value=$sums[ $data ]; }
            
            array_push
            (
                $row,
                $this->MyMod_Group_Cell_Align($data,$this->B($value))
            );
        }

        return $row;
    }
    
    //*
    //* function MyMod_Group_SumVars_Rows, Parameter list: $datas,$sums
    //*
    //* Creates sumvar rows as matrix.
    //* 

    function MyMod_Group_SumVars_Rows($datas,$sums)
    {
        return
            array
            (
                $this->MyMod_Group_SumVars_Row($datas,$sums)
            );
    }
}

?>