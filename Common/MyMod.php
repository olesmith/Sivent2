<?php

include_once("CSS.php");
include_once("MyFile.php");
include_once("MakeLatex.php");
include_once("MyDir.php");
include_once("MySort.php");
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
include_once("MyMod/Group.php");
include_once("MyMod/Item.php");
include_once("MyMod/Items.php");
include_once("MyMod/Search.php");
include_once("MyMod/Paging.php");
include_once("MyMod/Access.php");
include_once("MyMod/Profiles.php");
include_once("MyMod/Setup.php");
include_once("MyMod/Sort.php");
include_once("MyMod/Globals.php");
include_once("MyMod/Latex.php");
include_once("MyMod/Language.php");
include_once("MyMod/Mail.php");
include_once("MyMod/Messages.php");

trait MyMod
{    
    use 
        _accessor_, //see #SystemRoot#/index.php
        CSS,
        MyFile,
        MySort,
        MakeLatex,
        MyDir,
        MyHash,
        Accessor,
        MyActions,
        Sql,
        DB,
        CallStack;

    use
        MyMod_Handle,MyMod_HorMenu,
        MyMod_Modules,MyMod_Module,MyMod_SubModules,
        MyMod_Actions,MyMod_Data,MyMod_Group,MyMod_Item,
        MyMod_Access,MyMod_Mail,
        MyMod_Items,MyMod_Search,MyMod_Paging,
        MyMod_Latex,MyMod_Language,
        MyMod_Profiles,MyMod_Setup,MyMod_Sort,MyMod_Globals,MyMod_Messages;

    var $Application="";
    
    //From Mysql2/Items.php
    var $ItemHashes=array();
    var $ActionButtons=FALSE;
    var $ActionButtonActions=array();

    var $ItemActions=array();
    var $ItemsActions=array();
    var $SumVars=array();
    var $ConditionalShow="";
    var $IncludeAll=0;
    var $IncludeAllDefault=TRUE;
    var $NoPaging=FALSE;
    var $NoSearches=FALSE;
    var $ShowAll=FALSE;
    var $AddCheckBox2ItemTable=FALSE;
    var $UniquenessData=array();
    var $LastWhereClause=NULL;
    var $OnlyReadIDs=NULL;

    var $ExtraData=array();
    var $ItemDataGroupsCommon=array();
    var $ItemDataGroupNames=array();

    var $ItemDataSGroupsCommon=array();
    var $ItemDataSGroupNames=array();


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
    //* function MyMod_Init, Parameter list: $args=array()
    //*
    //* Module initializer.
    //*

    function MyMod_Init($args=array())
    {
        $this->IsMain=FALSE;

        $this->MyHash_Args2Object($this->MyMod_Defaults,TRUE);
        $this->MyHash_Args2Object($args);

        foreach (array("ItemName","ItemsName","ItemNamer") as $attr)
        {
            foreach ($this->ApplicationObj()->LanguageKeys as $lkey)
            {
                $rattr=$attr.$lkey;
                //$this->$rattr="";
            }
        }
    }

    //*
    //* function MyMod_ItemName, Parameter list: $key="ItemName"
    //*
    //* Returns item name, according to active language.
    //*

    function MyMod_ItemName($key="ItemName")
    {
        $lkey=$key.$this->ApplicationObj()->MyLanguage_GetLanguageKey();
        if (!property_exists($this,$lkey))
        {
            $lkey=$key;
        }

        return $this->$lkey;
    }

    //*
    //* function MyMod_ItemsName, Parameter list: 
    //*
    //* Returns items name, according to active language.
    //*

    function MyMod_ItemsName()
    {
        return $this->MyMod_ItemName("ItemsName");
    }

}

?>