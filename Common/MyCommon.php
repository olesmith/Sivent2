<?php

include_once("MyEmail.php");
include_once("ItemForm.php");
include_once("MyLanguage.php");
include_once("MyLatex.php");


trait MyCommon
{
    use MyEmail,ItemForm,MyLanguage,MyLatex;
    //*
    //* function Caller, Parameter list: $level=1
    //*
    //* Returns function caller.
    //*

    function Caller($level=1)
    {
        $trace=debug_backtrace();
        return $trace[ $level+1 ][ 'function' ];
    }

    
}

?>