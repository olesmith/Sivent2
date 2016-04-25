<?php


class HtmlCSS extends Log
{
    //*
    //* function ResetCSSClass, Parameter list:,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function ResetCSSClass(&$options)
    {
        $options[ "CLASS" ]="";
    }
 
    //*
    //* function SetCSSClass, Parameter list: $class,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function SetCSSClass($class,&$options)
    {
        $options[ "CLASS" ]=$class;
    }
 
    //*
    //* function AddCSSClass, Parameter list: $class,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function AddCSSClass($class,&$options)
    {
        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array();
        }
        elseif(!is_array($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array($options[ "CLASS" ]);
        }

        array_push($options[ "CLASS" ],$class);

        $options[ "CLASS" ]=join(",",$options[ "CLASS" ]);
    }
   
}


?>