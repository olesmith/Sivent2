<?php

trait MyMod_Handle_Export_Sort
{
    //*
    //* Detect sorter.
    //*

    function MyMod_Handle_Export_Sorts_Get()
    {
        $sorts=array();
        $n=0;
        foreach ($this->MyMod_Handle_Export_Table_Datas() as $data)
        {
            if (!empty($this->Fields[ $n ][ "Sort" ]))
            {
                if (!preg_grep('/^'.$data.'$/',$sorts))
                {
                    array_push($sorts,$data);
                }
            }
            
            $n++;
        }
      
        return $sorts;
    }
    
    //*
    //* Do Sort
    //*

    function MyMod_Handle_Export_Sort_Do()
    {
        $this->MyMod_Sort_Items
        (
            $this->MyMod_Handle_Export_Sorts_Get(),
            $this->MyMod_Handle_Export_CGI_Reverse()
        );
    }
}
?>