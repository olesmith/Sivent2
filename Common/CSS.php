<?php

trait CSS
{
    //*
    //* function CSS, Parameter list: $name,$hash
    //*
    //* Generates CSS entrey, named $name.
    //*

    function CSS($name,$hash)
    {
        $comps=array();
        foreach ($hash as $key => $value)
        {
            array_push($comps,"   ".$key.": ".$value.";");
        }

        return
            $name."\n".
            "{\n".
            join("\n",$comps).
            "\n}\n";
    }

}
?>