<?php

class SubModules extends Session
{
    //*
    //* function SubModuleLoad, Parameter list: $module,$updatestructure=FALSE
    //*
    //* Centralized submodule loader.
    //*

    function SubModuleLoad($module,$updatestructure=FALSE,$readitemdata=TRUE,$readitemgroupdata=TRUE,$readactions=TRUE)
    {
        $this->MyMod_SubModule_Load($module,$updatestructure,$readitemdata,$readitemgroupdata,$readactions);
        
        $objkey=$this->SubModulesVars[ $module ][ "SqlObject" ];

        /* if (empty($this->$objkey) || $updatestructure) */
        /* { */
        /*     $this->MyMod_SubModule_Load($module,$updatestructure,$readitemdata,$readitemgroupdata,$readactions); */
        /* } */

        /* if (empty($this->$objkey)) */
        /* { */
        /*     die("ModuleLoad::Unable to load ".$module." object, objkey: ".$objkey); */
        /* } */

        return $this->$objkey;
    }
}
?>