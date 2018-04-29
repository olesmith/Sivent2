<?php

include_once("../Application/DBData.php");

class Datas extends DBData
{
    //*
    //* function Datas, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Datas($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("SortOrder","Name","SqlKey");
        $this->Sort=array("DataGroup","SortOrder","Name");

    }


    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("Datas",$table);
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        //Don't remove function, since parent would be called instead.
        array_unshift($this->ItemDataPaths,"../Application/System/DBData");
    }

    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $unitid=$this->ApplicationObj->Unit("ID");
        $this->AddDefaults[ "Unit" ]=$unitid;
        $this->AddFixedValues[ "Unit" ]=$unitid;
        $this->ItemData[ "Unit" ][ "Default" ]=$unitid;
        $this->AddFixedValues[ "Friend" ]=3;
        $this->ItemData[ "Friend" ][ "Default" ]=3;

        $eventid=$this->ApplicationObj->Event("ID");
        $this->AddDefaults[ "Event" ]=$eventid;
        $this->AddFixedValues[ "Event" ]=$eventid;

        parent::PostProcessItemData();
    }


    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/^(Datas|Events)$/',$module))
        {
            return $item;
        }

        return parent::PostProcess($item);
    }

    
    //*
    //* function EventDatasForm, Parameter list: $event
    //*
    //* Displays event quest lists.
    //*

    function EventDatasForm($event)
    {
        $this->SetEvent($event);

        return $this->DBDataForm();
    }
}

?>