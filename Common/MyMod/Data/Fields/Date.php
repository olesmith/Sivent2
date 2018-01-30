<?php

trait MyMod_Data_Fields_Date
{
    //*
    //* function MyMod_Data_Field_Date_Edit, Parameter list: ($rdata,$item,$value)
    //*
    //* Creates edit password field.
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Date_Edit($rdata,$item,$value)
    {
        return
            $this->CreateDateField($rdata,$item,$value);
    }        
}

?>