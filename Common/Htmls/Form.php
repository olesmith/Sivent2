<?php

include_once("Form/Buttons.php");
include_once("Form/Hiddens.php");
include_once("Form/Start.php");
include_once("Form/End.php");
include_once("Form/Options.php");
include_once("Form/Args.php");
include_once("Form/Action.php");

trait Htmls_Form
{
    use
        Htmls_Form_Buttons,
        Htmls_Form_Hiddens,
        Htmls_Form_Start,
        Htmls_Form_End,
        Htmls_Form_Options,
        Htmls_Form_Args,
        Htmls_Form_Action;
    //*
    //* function Htmls_Form, Parameter list:
    //*
    //* Generates a HTML form as listed html.
    //*

    function Htmls_Form($edit,$id,$action="",$contents=array(),$args=array(),$options=array())
    {
        if ($edit==1)
        {
            return
                array_merge
                (
                    $this->Htmls_Form_Start
                    (
                        $id,
                        $action,
                        $contents,
                        $args,
                        $options
                    ),
                    array
                    (
                        $this->Htmls_Frame
                        (
                            array
                            (
                                $contents,
                                $this->Htmls_Form_Hiddens($args),
                                $this->Htmls_Form_Buttons($edit,$args)
                            )
                        )
                    ),
                    $this->Htmls_Form_End()
                );
        }

        return $contents;    
    }
}

?>