<?php

include_once("CGIVars/CGI.php");

trait MyApp_CGIVars
{
    use
        MyApp_CGIVars_CGI;
    //*
    //* function MyApp_CGIVars_Get, Parameter list: 
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVars_Get()
    {
        if (method_exists($this,"CGIVars"))
        {
            return $this->CGIVars();
        }

        if (is_string($this->CGIVars))
        {
            $method=$this->CGIVars;
            $this->CGIVars=$this->$method();
        }

        return $this->CGIVars;
    }

    //*
    //* function MyApp_CGIVars_Init, Parameter list: 
    //*
    //* Processes cgi vars.
    //*

    function MyApp_CGIVars_Init()
    {
        $this->MyApp_CGIVars_Inits($this-> MyApp_CGIVars_Get());
    }

    //*
    //* function MyApp_CGIVars_Inits, Parameter list: $defs
    //*
    //* Processes cgi vars.
    //*

    function MyApp_CGIVars_Inits($defs)
    {
        foreach ($defs as $cgivar => $def)
        {
           $this->MyApp_CGIVar_Init($cgivar,$def);
        }
    }

    //*
    //* function MyApp_CGIVar_Init, Parameter list: $cgivar,$def
    //*
    //* GETS global vars system. Hierarquical: calls MyApp_CGIVars_Inits above.
    //*

    function MyApp_CGIVar_Init($cgivar,$def)
    {
        $obj=$def[ "SqlObject" ];

        $this->MyApp_CGIVar_CGI_Read_Def($cgivar,$def);

        if (!empty($def[ "CGIVars" ]))
        {
            $this->MyApp_CGIVars_Inits($def[ "CGIVars" ]);
        }
    }

    //*
    //* function MyApp_CGIVars_Compulsory_Vars, Parameter list: $defs=array()
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVars_Compulsory_Vars($defs=array())
    {
        if (empty($defs)) { $defs=$this->CGIVars; }

        $cgivars=array();
        foreach ($defs as $cgivar => $def)
        {
            if ($def[ "Compulsory" ])
            {
                $cgivars[ $cgivar ]=$this->MyApp_CGIVar_CGI_Value($cgivar,$def);
            }

            if (!empty($def[ "CGIVars" ]))
            {
                $cgivars=array_merge
                (
                   $cgivars,
                   $this->MyApp_CGIVars_Compulsory_Vars($def[ "CGIVars" ])
                );
            }
        }

        return $cgivars;
    }
}

?>