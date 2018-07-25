<?php

trait MyApp_Handle_SU_Form
{
    //*
    //* function MyApp_Handle_SU_Form, Parameter list:
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_SU_Form()
    {
        return
            $this->Htmls_Form
            (
                1,
                "SU",
                $action="",
                array
                (
                    $this->H
                    (
                        1,
                        $this->GetRealNameKey($this->Actions("SU"),"Title")
                    ),
                    $this->H
                    (
                        2,
                        $this->Language_Message("SU_Form_Title")
                    ),
                    $this->MyApp_Handle_SU_Message_Or_Do(),
                    $this->MyApp_Handle_SU_Html(),
                ),
                $args=array
                (
                    "Hiddens" => array
                    (
                        "Shift" => 1,
                    ),
                ),
                $options=array()
            );
    }
}

?>