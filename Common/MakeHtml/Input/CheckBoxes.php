<?php


trait Html_Input_CheckBoxes
{
    //*
    //* sub Html_Input_CheckBox_Field, Parameter list: $name,$value=FALSE,$checked=FALSE,$disabled=FALSE,$options=array()
    //*
    //* Create CheckBox of name $name. The box is checked if argument
    //* $checked is defined.
    //*
    //*

    function Html_Input_CheckBox_Field($name,$value=FALSE,$checked=FALSE,$disabled=FALSE,$options=array())
    {
        $options[ "TYPE" ]="checkbox";
        $options[ "NAME" ]=$name;

        if ($value) { $options[ "VALUE" ]=$value; }
        if ($checked) { $options[ "CHECKED" ]=""; }
        if ($disabled) { $options[ "DISABLED" ]=""; }
    
        return $this->HtmlTag
        (
           "INPUT",
           "",
           $options
        )."\n";
    }

}
?>