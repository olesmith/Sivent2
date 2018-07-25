<?php

include_once("DBGroups/Access.php");
include_once("DBGroups/Form.php");

class DBGroups extends DBGroupsForm
{
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("GroupDatas",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return join("/",array("..","Application","System","DBGroups","Profiles.php"));
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push($this->ItemDataPaths,"../Application/System/DBGroups");
        $this->Sql_Table_Column_Rename("Candidate","Friend");
    }
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        array_push($this->ItemDataGroupPaths,"../Application/System/DBGroups");
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreActions()
    {
        array_push($this->ActionPaths,"../Application/System/DBData");
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $pertainsnames=array();
        foreach ($this->ApplicationObj()->PertainsSetup as $pertains => $def)
        {
            array_push($pertainsnames,$this->GetRealNameKey($def,"Title"));         
        }

        $this->ItemData[ "Pertains" ][ "Values" ]=$pertainsnames;
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
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        if (count($updatedatas)>0)
        {
            $this->MySqlSetItemValues("",$updatedatas,$item);
        }

        return $item;
    }
}

?>