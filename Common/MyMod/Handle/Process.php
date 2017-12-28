<?php


trait MyMod_Handle_Process
{
    //*
    //* function MyMod_Handle_Process, Parameter list: 
    //*
    //* Application processor. 
    //*

    function MyMod_Handle_Process()
    {
        return $this->ApplicationObj()->MyApp_Handle_Process();
    }
}

?>