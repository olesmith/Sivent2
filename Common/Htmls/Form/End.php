<?php


trait Htmls_Form_End
{
    //*

      //*
    //* function Html_Form_End, Parameter list:
    //*
    //* Generates a HTML form end tag.
    //*

    function Htmls_Form_End()
    {
        return array($this->Htmls_Tag_Close("FORM"));
    }
    
}

?>