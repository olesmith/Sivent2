<?php

trait Htmls_Form_Buttons
{
    //*
    //* function Html_Form_Buttons, Parameter list:
    //*
    //* Conditionally generates buttons.
    //*
    
    function Htmls_Form_Buttons($edit,$args)
    {
        $buttons=array();
        if (!empty($args[ "Buttons" ])) { $buttons=$args[ "Buttons" ]; }
        
        $html=array();
        if ($edit==1 && !empty($buttons))
        {
            $html=
                $this->Htmls_Tag
                (
                    "DIV",
                    array($buttons),
                    array("ALIGN" => 'center')
                );
        }

        return $html;
    }
}

?>