<?php


class InputPassword extends SelectFields
{
    
    //*
    //* function MakePasswordField, Parameter list: $data,$value="
    //*
    //* Based on profile, generates suitable sql where clause.
    //*

    function MakePasswordField($data,$value="")
    {
        $size=8;
        if ($this->ItemData[ $data ][ "Size" ]) { $size=$this->ItemData[ $data ][ "Size" ]; }

        return $this->MakePassword($data,$value,$size);
    }
    
    //*
    //* function ShowPasswordField, Parameter list: $data,$value="
    //*
    //* Based on profile, generates suitable sql where clause.
    //*

    function ShowPasswordField($data,$value="")
    {
        return "**********";
    }
}

?>