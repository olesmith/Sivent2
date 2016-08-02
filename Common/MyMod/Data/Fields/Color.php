<?php


trait MyMod_Data_Fields_Color
{
    //*
    //* Generates color edit field.
    //*

    function MyMod_Data_Fields_Color_Field($data,$item,$edit,$rdata="")
    {
        if ($edit==1)
        {
            if (empty($rdata)) { $rdata=$data; }
           
            return
                $this->Html_Input
                (
                   "COLOR",
                   $rdata,
                   $item[ $data ]//,
                   //array("SIZE" => $this->ItemData[ $data ][ "Size" ])
                );
        }
        else
        {
            return
                $this->Html_Tags
                (
                   "FONT",
                   $item[ $data ],
                   array
                   (
                    //"COLOR" => $item[ $data ],
                   )
                );
        }
    }
}

?>