<?php


trait MyApp_Interface_Head_Styles
{
    //*
    //* sub MyApp_Interface_STYLEs, Parameter list:
    //*
    //* Returns interface header style section
    //*
    //*

    function MyApp_Interface_STYLEs()
    {
        return
            array_merge
            (
                $this->MyApp_Interface_Styles_InLine(),
                $this->MyApp_Interface_Styles_OnLine()
            );
    }
    
    //*
    //* sub MyApp_Interface_STYLEs_InLine, Parameter list:
    //*
    //* Returns interface header styles inline section
    //*
    //*

    function MyApp_Interface_STYLEs_InLine()
    {
        return
            array
            (
                $this->MyApp_Interface_CSS_InLine()
            );
    }
     //*
    //* sub MyApp_Interface_STYLEs_OnLine, Parameter list:
    //*
    //* Returns interface header styles online section
    //*
    //*

    function MyApp_Interface_STYLEs_OnLine()
    {
        return array();
    }
}

?>