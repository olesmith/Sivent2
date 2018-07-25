<?php

include_once("MySponsors/Access.php");
include_once("MySponsors/Table.php");


class MySponsors extends MySponsors_Table
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function MySponsors($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->Sort=array("Name");
        $this->NonGetVars=array("Event","CreateTable");

        $this->AddDefaults[ "Event" ]=$this->Event("ID");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName("Sponsors",$table);
    }

    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function MyMod_Data_Upload_Path()
    {
        $path="Uploads/".$this->Unit("ID")."/Sponsors";
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }

    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
       array_push($this->ActionPaths,"../EventApp/System/Sponsors");
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
        array_unshift($this->ItemDataGroupPaths,"../EventApp/System/Sponsors");
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
        array_unshift($this->ItemDataPaths,"../EventApp/System/Sponsors");
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $unit=$this->ApplicationObj->Unit("ID");

        $this->AddDefaults[ "Unit" ]=$unit;
        $this->AddFixedValues[ "Unit" ]=$unit;
        $this->ItemData[ "Unit" ][ "Default" ]=$unit;
    }

    
    
    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
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
        if ($module!="Sponsors")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>