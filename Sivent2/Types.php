<?php

include_once("Types/Access.php");


class Types extends Types_Access
{
    var $Types=array();
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Types($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("ID");
        
        $this->Coordinator_Type=8;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Types",$table);
    }


    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->PostProcessUnitData();
        $this->PostProcessEventData();
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
        if ($module!="Types")
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
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->Item_Existence_Message();
        if ($res)
        {
            $res=$this->LotsObj()->Item_Existence_Message("Lots");
        }

        return $res;
    }

    
    //*
    //* function Types_Read, Parameter list: 
    //*
    //* Reads all event types.
    //*

    function Types_Read()
    {
        if (empty($this->Types))
        {
            $this->Types=$this->Sql_Select_Hashes($this->UnitEventWhere());
        }
        
    }
}

?>