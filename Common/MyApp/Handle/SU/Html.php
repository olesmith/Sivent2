<?php

trait MyApp_Handle_SU_Html
{
    //*
    //* function MyApp_Handle_SU_Form, Parameter list:
    //*
    //* SU html table.
    //*

    function MyApp_Handle_SU_Html()
    {
        return
            $this->Htmls_Table
            (
                "",
                $this->MyApp_Handle_SU_Table()
            );
    }
}

?>