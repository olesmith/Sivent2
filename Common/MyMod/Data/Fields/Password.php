<?php

trait MyMod_Data_Fields_Password
{
    //*
    //* function MyMod_Data_Field_Password_Edit, Parameter list: $data,$item,$rdata=""
    //*
    //* Creates edit password field.
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Password_Edit($data,$value,$rdata="")
    {
        $size=8;
        if ($this->ItemData[ $data ][ "Size" ]) { $size=$this->ItemData[ $data ][ "Size" ]; }

        if (empty($rdata)) { $rdata=$data; }
        
        return $this->Html_Password($rdata,$value,$size);
    }        
}

?>