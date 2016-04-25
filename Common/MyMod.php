<?php

include_once("MyFile.php");
include_once("MyDir.php");
include_once("MyHash.php");
include_once("../Common/Accessor.php");
include_once("MyActions.php");
include_once("Sql.php");
include_once("DB.php");
include_once("CallStack.php");

include_once("MyMod/Handle.php");
include_once("MyMod/HorMenu.php");
include_once("MyMod/Module.php");
include_once("MyMod/Modules.php");
include_once("MyMod/SubModules.php");
include_once("MyMod/Actions.php");
include_once("MyMod/Data.php");
include_once("MyMod/Item.php");
include_once("MyMod/Items.php");
include_once("MyMod/Access.php");
include_once("MyMod/Profiles.php");
include_once("MyMod/Setup.php");
include_once("MyMod/Globals.php");
include_once("MyMod/Latex.php");
include_once("MyMod/Language.php");
include_once("MyMod/Mail.php");

trait MyMod
{
    use 
        _accessor_, //see SAdE/index.php
        MyFile,MyDir,MyHash,Accessor,MyActions,Sql,DB,CallStack;

    use
        MyMod_Handle,MyMod_HorMenu,
        MyMod_Modules,MyMod_Module,MyMod_SubModules,
        MyMod_Actions,MyMod_Data,MyMod_Item,
        MyMod_Access,MyMod_Mail,
        MyMod_Items,MyMod_Latex,MyMod_Language,
        MyMod_Profiles,MyMod_Setup,MyMod_Globals;


    var $MyMod_Defaults=array
    (
        "IsMain" => FALSE,

        "Mail" => FALSE,
        "Logging" => FALSE,

        "MessageFiles" => array
        (
        ),

        "DefaultAction" => "Search",
        "SubModules" => array(),
        //"SqlVars" => array(),
        "System" => "System",

        "ActionPaths" => array("../MySql2/Actions","../#System/#Module"),
        "ActionFiles" => array("Actions.php"),
        "Actions" => array(), 

        "ItemDataPaths" => array("../Application/#System","#System"),
        "ItemDataFiles" => array("Data.php"),

        "ItemData" => array(),  
        "ItemDerivers" => array(),  
        "ItemDerivedData" => array(),

        "ItemDataGroupPaths" => array("../Application/#System","#System"),
        "ItemDataGroupFiles" => array("Groups.php"),
        "ItemDataSGroupFiles" => array("SGroups.php"),

        "ItemDataGroups" => array(),
        "ItemDataSGroups" => array(),
        "DataGroupsRead" => FALSE,
        "CurrentDataGroup" => "",
        
        "LatexPaths" => array("#System/../Defs","#System"),
        "LatexFiles" => array("Latex.Data.php"),
    );

    //*
    //* function MyApp_Init, Parameter list: $args=array()
    //*
    //* Module initializer.
    //*

    function MyMod_Init($args=array())
    {
        $this->IsMain=FALSE;

        $this->MyHash_Args2Object($this->MyMod_Defaults,TRUE);
        $this->MyHash_Args2Object($args);
    }

}

?>