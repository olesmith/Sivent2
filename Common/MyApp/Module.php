<?php

include_once("Module/Load.php");
include_once("Module/Access.php");
include_once("Module/Groups.php");

trait MyApp_Module
{
    use 
        MyApp_Module_Load,
        MyApp_Module_Access,
        MyApp_Module_Groups;

    //*
    //* function MyApp_Module_Init, Parameter list: $args=array(),$initdbtable=TRUE
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_Init($args=array(),$initdbtable=TRUE)
    {
        if (!$this->Module)
        {
            if (empty($this->ModuleFile)) { $this->ModuleFile=$this->ModuleName; }

            if (!preg_grep('/^'.$this->ModuleName.'$/',$this->AllowedModules))
            {
                $this->DoDie("Module access not permitted",$this->ModuleName);
            }

            $this->LoadMTime=time();
            if (file_exists($this->MyMod_Setup_ItemDataFile($this->ModuleName)))
            {
               $this->MyMod_SubModules_Load();
            }
        }

        if (method_exists($this->Module,"PostInit"))
        {
            $this->Module->PostInit();
        }

        $this->PostInit();
        $this->ModuleName=$this->Module->ModuleName;
    }


    //*
    //* function MyApp_Module_GetObject, Parameter list: $module
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_GetObject($module)
    {
        $accessor=$this->SubModulesVars[ $module ][ "SqlClass" ]."Obj";
        return $this->$accessor();
    }
    
    //*
    //* function MyApp_Modules_Get, Parameter list:
    //*
    //* Returns list of application modules.
    //*

    function MyApp_Modules_Get()
    {
        return array_keys($this->SubModulesVars);
    }
}

?>