<?php

trait MyApp_Module_Access
{
    //*
    //* function MyApp_Module_Access_Has, Parameter list: $module
    //*
    //* Returns true if access to module allowed.
    //*

    function MyApp_Module_Access_Has($module)
    {
        $res=FALSE;
        if (preg_grep('/^'.$module.'$/',$this->AllowedModules))
        {
            $res=TRUE;
        }

        if ($res)
        {
            $obj=$module."Obj";
            $res=$this->$obj()->MyMod_Access_Has();
        }
        
        return $res;
    }

    //*
    //* function MyApp_Module_Access_Require, Parameter list: $module
    //*
    //* Requires module access - exits if not.
    //*

    function MyApp_Module_Access_Require($module)
    {
        if ($this->MyApp_Module_Access_Has($module))
        {
            return TRUE;
        }

        $this->DoDie("No module access: $module ".$this->LoginType);
    }

}

?>