<?php

trait MyApp_Handle_SU_Table
{
    //*
    //* function MyApp_Handle_SU_Table, Parameter list:
    //*
    //* Creates the SU table.
    //*

    function MyApp_Handle_SU_Table()
    {
        return
            array_merge
            (
                $this->MyApp_Handle_SU_Profiles_Table(),
                array
                (
                    array
                    (
                        $this->MakeHidden("Shift",1).
                        $this->Button("submit","GO")
                    ),
                )
            );
    }
}

?>