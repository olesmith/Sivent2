<?php

include_once("../Application/DBGroups.php");

class GroupDatas extends DBGroups
{
    //*
    //* function GroupDatas, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function GroupDatas($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Text");
        $this->Sort=array("Text");
    }


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
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->AddUnitEventDefault();
        
        $unitid=$this->GetCGIVarValue("Unit");
        $eventid=$this->GetCGIVarValue("Event");
        
        $this->ItemData[ "Unit" ][ "Default" ]=$unitid;
        $this->ItemData[ "Event" ][ "Default" ]=$eventid;

        parent::PostProcessItemData();
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
        if (!preg_match('/^(DataGroups|Events)$/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        return parent::PostProcess($item);
    }
    
    //*
    //* function EventGroupDatasForm, Parameter list: $event
    //*
    //* Displays event data groups lists.
    //*

    function EventGroupDatasForm($event)
    {
        $this->SetEvent($event);
        return $this->DBGroupsDatasForm();
    }
    
}

?>