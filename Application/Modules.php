<?php

class Modules extends Backup
{
    var $AllowedModules=array();
    var $Access=array();
    var $CurrentDBName="";
    var $ModuleLevel=0;
    var $ModuleName="";
    var $ModuleFile="";
    var $Module=NULL;
    var $Modules=array();
    var $MySqlActions=TRUE;
    var $DefaultAction="Search";

    var $LoadMTime,$ExecMTime;
    var $SavePath;
   

    //*
    //* function InitModules, Parameter list: $hash=array()
    //*
    //* Initializes module vars, as in $hash.
    //*

    function InitModules0000($hash=array())
    {
        $this->Hash2Object($hash);
        $this->ModuleFile=$this->ModuleName;
    }




    //*
    //* function PostInit, Parameter list: 
    //*
    //* Container method, for adding last hour application post inits.
    //*

    function PostInit()
    {
    }

    //*
    //* function HasMenuAccess, Parameter list: $menu
    //*
    //* Checks if current user has access to menuitem $menu
    //*

    function HasMenuAccess($menudef)
    {
        $access=FALSE;
        if ($menudef[ $this->LoginType ]!=0)
        {
            $access=TRUE;
        }
        elseif ($menudef[ "ConditionalAdmin" ]==1 && $this->MyApp_Profile_MayBecomeAdmin())
        {
            $access=TRUE;
        }

        return $access;
    }

    /* //\* */
    /* //\* function ReadModuleSetup, Parameter list: $moduleobj */
    /* //\* */
    /* //\* Reads module specific setup. */
    /* //\* */

    /* function ReadModuleSetup($moduleobj) */
    /* { */
    /*     $setupdefs=$this->ReadPHPArray($this->SetupPath."/Modules.Defs.php"); */
    /*     $setupdefs=$this->ReadPHPArray */
    /*     ( */
    /*        $moduleobj->SetupDataPath()."Module.Defs.php", */
    /*        $setupdefs */
    /*     ); */

    /*     $this->MyApp_Setup_ReadFiles($setupdefs,$moduleobj); */

    /*     if (isset($this->Period)) */
    /*     { */
    /*         $moduleobj->Period=$this->Period; */
    /*     } */
    /* } */

}
?>