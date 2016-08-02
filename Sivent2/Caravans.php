<?php

include_once("Caravans/Access.php");
include_once("Caravans/Caravaneers.php");



class Caravans extends CaravansCaravaneers
{
    var $Certificate_Type=5;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Caravans($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Email","TimeLoad","Registration");
        $this->Sort=array("Name");

        $this->SqlWhere=array("Caravans" => 2);
        $this->IncludeAllDefault=TRUE;
    }

    
    //*
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return "System/Caravans/Profiles.php";
    }
    
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Inscriptions",$table);
    }


    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
        //parent::PreProcessItemDataGroups();
        parent::PreActions();
        array_push($this->ActionPaths,"System/Inscriptions","../EventApp/System/Inscriptions");
    }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        parent::PreProcessItemDataGroups();
        //array_push($this->ItemDataGroupPaths,"System/Inscriptions","../EventApp/System/Inscriptions");
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        $this->Load_Other_Data=FALSE;
        
        parent::PreProcessItemData();
        array_push($this->ItemDataPaths,"System/Inscriptions","../EventApp/System/Inscriptions");
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        parent::PostProcessItemData();
    }

    
    
    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit_disabled()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/(Caravans|Friends|Inscriptions)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        //$this->Sql_Select_Hash_Datas_Read($item,array("TimeLoad","Collaboration","Homologated"));

        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>