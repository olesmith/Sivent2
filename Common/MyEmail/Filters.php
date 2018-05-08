<?php

trait MyEmail_Filters
{
    //*
    //* function MyEmail_Field_Filter, Parameter list: $field
    //*
    //* Filters mail field text over global vars.
    //*

    function MyEmail_Field_Filter($field,$filters=array())
    {
        $filters=array_merge
        (
           $filters,
           array
           (
               $this->ApplicationObj()->MyApp_Mail_Info_Get(),
               $this->HtmlSetupHash,
               $this->CompanyHash
           )
        );

        if (method_exists($this,"Unit"))
        {
            $unit=$this->Unit();
            $runit=array();
            foreach ($unit as $key => $value)
            {
                $runit[ "Unit_".$key ]=$value;
            }
            array_push($filters,$runit);
        }

        return $this->FilterHashes
        (
            $this->Html2Text($field),
            $filters
        );
    }
    
     //*
    //* function MyEmail_Hash_Filters, Parameter list: 
    //*
    //* Filters mail $fields text over global vars.
    //*

    function MyEmail_Hash_Filters($hash,$fields,$filters=array())
    {
        foreach ($fields as $field)
        {
            $hash[ $field ]=$this->MyEmail_Field_Filter($hash[ $field ],$filters);
        }

        return $hash;
    }
}
?>