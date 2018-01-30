<?php

trait MyMod_Data_Fields_Hour
{
    //*
    //* function MyMod_Data_Field_Hour_Edit, Parameter list: ($rdata,$item,$value)
    //*
    //* Creates edit password field.
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Hour_Edit($rdata,$item,$value)
    {
        return
            $this->CreateHourSelectFields($rdata,$item,$value);
    }        
}

?>