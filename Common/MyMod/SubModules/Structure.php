<?php

trait MyMod_SubModules_Structure
{
    //*
    //* function MyMod_SubModule_Load, Parameter list: $submodule
    //*
    //* Lods $submodule.
    //*

    function MyMod_SubModule_Structure_Init($submodule)
    {
        $method=$this->ApplicationObj()->SubModulesVars[ $submodule ][ "SqlClass" ]."Obj";

        $this->ApplicationObj()->$method()->MyMod_SubModule_Structure_Update();
    }


    //*
    //* function UpdateTableStructure, Parameter list: 
    //*
    //* Does actual Table structure updating.
    //*

    function MyMod_SubModule_Structure_Update()
    {
        $this->Sql_Table_Structure_Update
        (
           $this->DataKeys(),
           $this->ItemData,
           TRUE,
           $this->SqlTableName()
        );
    }

    //*
    //* function MyMod_SubModule_Structure_Updates, Parameter list: $classes
    //*
    //* Update table structures for $classes.
    //*

    function MyMod_SubModule_Structure_Updates($classes)
    {
        foreach ($classes as $class)
        {
            $obj=$class."Obj";
            $this->$obj()->SqlTable=$this->SqlTableName($class);
            $this->$obj()->MyMod_SubModule_Structure_Update();
        }
    }

 }


?>