<?php

trait MakeOptions
{    
    //*
    //* sub Option_Name, Parameter list: $option
    //*
    //* Preprocesses $option name: strtolower
    //*
    //*

    function Option_Name($option)
    {
        return strtolower($option);
    }

    //*
    //* sub Option_Value, Parameter list: $value
    //*
    //* Preprocesses option value.
    //*
    //*

    function Option_Value($value)
    {
        return preg_replace('/"/',"",$value);

    }

    //*
    //* sub Option_String, Parameter list: $option,$value
    //*
    //* Returns option $option='$value'..
    //*
    //*

    function Option_String($option,$value)
    {
        return
            $this->Option_Name($option).
            "=\"".
            $this->Option_Value($value).
            "\"";
    }

    //*
    //* sub Option_String, Parameter list: $option
    //*
    //* Converts an associative array to an options string.
    //* As in HTML entities OPTION1='value1',... .
    //*
    //*

    function Option_2_String($option,$value)
    {
        $optionstring="";
        if (preg_match('/^\s+$/',$option))
        {
            $optionstring=$value;
        }
        elseif (preg_match('/^\d+$/',$option))
        {
            $optionstring=$this->Option_String($option,$value);
        }
        elseif (empty($value))
        {
            if (!preg_match('/^(CLASS|TITLE)$/i',$option))
            {
                $optionstring=$this->Option_Name($option);
            }
        }
        else
        {
            $optionstring=
                strtolower($option)."=\"".
                preg_replace('/"/',"",$value).
                "\"";
        }

        return $optionstring;
    }

    
    //*
    //* sub Options_FromHash, Parameter list: $options
    //*
    //* Converts an associative array to an options string.
    //* As in HTML entities OPTION1='value1',... .
    //*
    //*

    function Options_FromHash($options)
    {
        $optionstrings=array();
        foreach ($options as $option => $value)
        {
            array_push
            (
                $optionstrings,
                $this->Option_2_String($option,$value)
            );
        }
        
        return " ".join(" ",$optionstrings); 
    }
}
?>