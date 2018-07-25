<?php

// Table generation.


trait MakeHtml_CSS
{
    //*
    //* function Html_CSS_Reset, Parameter list:,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function Html_CSS_Reset(&$options)
    {
        $options[ "CLASS" ]="";
    }
 
    //*
    //* function Html_CSS_Set, Parameter list: $class,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function Html_CSS_Set($class,&$options)
    {
        $options[ "CLASS" ]=$class;
    }
 
    //*
    //* function Html_CSS_Add, Parameter list: $class,&$options
    //*
    //* Adds class $class to $options[ "Class" ].
    //*

    function Html_CSS_Add($class,&$options)
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