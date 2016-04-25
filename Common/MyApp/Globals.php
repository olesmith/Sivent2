<?php



trait MyApp_Globals
{
    //*
    //* function ActiveModule, Parameter list: 
    //*
    //* Returns (name of) active module.
    //*

    function ActiveModule()
    {
        if (!empty($this->Module))
        {
            return $this->Module->ModuleName;
        }

        return "";
    }
}

?>