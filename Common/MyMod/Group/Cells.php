<?php

trait MyMod_Group_Cells
{
    //*
    //* function MyMod_Group_Cell_Data, Parameter list: ($edit,$item,$data,$value="",$even=False,$tabindex=0)
    //*
    //* Creates group data cell.
    //* 
    
    function MyMod_Group_Cell_Data($edit,$item,$data,$value="",$even=False,$tabindex=0)
    {
        if (empty($value) && !empty($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        
        if (preg_match('/^text\_/',$data))
        {
            $value=preg_replace('/^text\_/',"",$data);
            $value=$this->Span($value,array("CLASS" => 'Bold Right'));
        }
        elseif (!isset($this->ItemData[ $data ]) && isset($this->Actions[ $data ]))
        {
            if ($even)
            {
                $this->Actions[ $data ][ "Icon" ]=
                    preg_replace
                    (
                        '/_light./',
                        "_dark.",
                        $this->Actions[ $data ][ "Icon" ]
                    );
            }
            else
            {
                $this->Actions[ $data ][ "Icon" ]=
                    preg_replace
                    (
                        '/_dark./',
                        "_light.",
                        $this->Actions[ $data ][ "Icon" ]
                    );
            }

            $value=$this->MyActions_Entry($data,$item);
            if (!empty($this->Actions[ $data ][ "Icon" ]))
            {
                $value=$this->Center($value);
            }
        }
        elseif
            (
                preg_match('/\S+\_\S+/',$data)
                &&
                empty($this->ItemData[ $data ])
                &&
                isset($item[ $data ])
            )
        {
            $value=$item[ $data ];
        }
        elseif (!empty($this->ItemData[ $data ]))
        {
            $value=$this->MyMod_Data_Fields($edit,$item,$data,TRUE,$tabindex);//TRUE for plural
                
            if (empty($value)) { $value="&nbsp;"; }
        }
        elseif (method_exists($this,$data))
        {
            $value=$this->Span($this->$data($item,$edit),array("CLASS" => 'data'));
        }
        else
        {
            $value=$this->MakeField($edit,$item,$data,TRUE,$tabindex);//TRUE for plural
                
            if (!preg_match('/\S/',$value)) { $value="&nbsp;"; }
        }

        if
            (
                $edit==1
                &&
                $this->Profile!="Public"
                &&
                isset($item[ $data."_Message" ])
                &&
                $item[ $data."_Message" ]!=""
            )
        {
            $value.=$this->Font($item[ $data."_Message" ],array("CLASS" => 'errors'));
        }

        $value=$this->MyMod_Group_Cell_Align($data,$value);

        return $value;
    }
    
     //*
    //* function MyMod_Group_Cell_Aligned, Parameter list: ($value,$align)
    //*
    //* Aligns cell.
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
    //* Do alignment, if supposed to.
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