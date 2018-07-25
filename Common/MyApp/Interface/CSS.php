<?php

include("CSS/InLine.php");
include("CSS/OnLine.php");


trait MyApp_Interface_CSS
{
    use
        MyApp_Interface_CSS_InLine,
        MyApp_Interface_CSS_OnLine;

    var $MyApp_Interface_CSS_Path="CSS";
    
    
    //*
    //* sub MyApp_Interface_CSS_Path, Parameter list:
    //*
    //*  MyApp_Interface_CSS_Path accessor.
    //*
    //*

    function MyApp_Interface_CSS_Path()
    {
        return $this->MyApp_Interface_CSS_Path;
    }
}

?>