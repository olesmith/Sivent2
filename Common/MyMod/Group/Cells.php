<?php

trait MyMod_Group_Cells
{
    //*
    //* function MyMod_Group_Cell_Aligned, Parameter list: ($value,$align)
    //*
    //* 
    //* 
    
    function MyMod_Group_Cell_Aligned($value,$align)
    {
        if (!empty($align))
        {
            $value=
                array
                (
                   "Text" => $value,
                   "Options" => array("CLASS" => $align),
                );
        }

        return $value; 
    }

    
    //*
    //* function MyMod_Group_Cell_Align, Parameter list: ($data,$value)
    //*
    //* 
    //* 
    
     function MyMod_Group_Cell_Align($data,$value)
    {
        if (!empty($this->ItemData[ $data ]))
        {
            $align="";
            if (
                  preg_match('/(INT|REAL)/i',$this->ItemData[ $data ][ "Sql" ])
                  &&
                  empty($this->ItemData[ $data ][ "SqlClass" ])
               )
            {
                 $align='right';
            }
            elseif (!empty($this->ItemData[ $data ][ "Align" ]))
            {
                $align=$this->ItemData[ $data ][ "Align" ];
            }
            
            $value=$this->MyMod_Group_Cell_Aligned($value,$align);
        }

        return $value;
    }
    
}

?>