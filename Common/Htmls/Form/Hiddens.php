<?php

trait Htmls_Form_Hiddens
{
    //*
    //* function Html_Form_Hiddens, Parameter list:
    //*
    //* Generates a HTML form hidden fields.
    //*

    function Htmls_Form_Hiddens($args)
    {
        $hiddens=array();
        if (!empty($args[ "Hiddens" ])) { $hiddens=$args[ "Hiddens" ]; }

        
        if (!empty($args[ "Save_CGI_Key" ]))
        {
            $value=1;
            if (!empty($args[ "Save_CGI_Value" ])) { $value=$args[ "Save_CGI_Value" ]; }
            $hiddens[   $args[ "Save_CGI_Key" ]   ]=$value;
        }
        
        $rhiddens=array();
        foreach ($hiddens as $key => $value)
        {
            array_push
            (
                $rhiddens,
                $this->MakeHidden($key,$value)
            );
        }

        return $rhiddens;
    }
    
}

?>