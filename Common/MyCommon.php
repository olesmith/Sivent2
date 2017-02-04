<?php

include_once("MyEmail.php");
include_once("ItemForm.php");
include_once("MyLanguage.php");
include_once("MyLatex.php");
include_once("Cookies.php");


trait MyCommon
{
    use MyEmail,ItemForm,MyLanguage,MyLatex,Cookies;
    
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

    
    //*
    //* function TableMethod, Parameter list: 
    //*
    //* Returns proper table generating method: Html or Latex.
    //* More versions implementable.
    //*

    function TableMethod()
    {
        $method="Html_Table";
        if ($this->LatexMode())
        {
            $method="LatexTable";
        }

        return $method;
    }

    
}

?>