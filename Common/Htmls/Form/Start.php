<?php

// Form generation.


trait Htmls_Form_Start
{
    //*
    //* function Html_Form_Start, Parameter list:
    //*
    //* Generates a HTML form start tag.
    //*

    function Htmls_Form_Start($id,$action="",$contents=array(),$args=array(),$options=array())
    {
        return
            array
            (
                $this->Htmls_Tag_Start
                (
                    "FORM",
                    "",
                    $this->Htmls_Form_Options
                    (
                        $id,
                        $action,
                        $contents,
                        $args,
                        $options
                    )
                )
            );
    }    
}

?>