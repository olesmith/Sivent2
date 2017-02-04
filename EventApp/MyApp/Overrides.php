<?php

class MyEventApp_Overrides extends MyEventApp_Access
{
   //*
    //* function Latex_PDF, Parameter list: $file,$latex
    //*
    //* Filters out Unit and Event and calls parent Latex_PDF.
    //*

    function Latex_PDF($file,$latex, $printpdf = true, $runbibtex = false, $copypdfto = false)
    {
        $latex=$this->FilterHash($latex,$this->Unit(),"Unit_");
        $latex=$this->FilterHash($latex,$this->Event(),"Event_");
        
        $latex=$this->TrimLatex($latex);
        
        return parent::Latex_PDF($file,$latex,$printpdf,$runbibtex,$copypdfto);
    }
}
?>
