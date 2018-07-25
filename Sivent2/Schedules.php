<?php

include_once("Schedules/Access.php");
include_once("Schedules/Times.php");
include_once("Schedules/Dates.php");
include_once("Schedules/Rooms.php");
include_once("Schedules/Places.php");
include_once("Schedules/Submissions.php");
include_once("Schedules/Schedule.php");
include_once("Schedules/Schedules.php");
include_once("Schedules/Speaker.php");
include_once("Schedules/Update.php");
include_once("Schedules/Statistics.php");
include_once("Schedules/Handle.php");



class Schedules extends Schedules_Handle
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Schedules($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Event","Name","Date","Time","Room","Submission");
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");

        $this->Coordinator_Type=5;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Schedules",$table);
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
        foreach (array("Dates","Times","Places","Rooms","Areas","Submissions") as $module)
        {
            $module.="Obj";
            $this->$module()->Sql_Table_Structure_Update();
        }
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Schedules")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        //Keep date updated
        $date=$this->TimesObj()->Sql_Select_Hash_Value($item[ "Time" ],"Date");
        
        if ($item[ "Date" ]!=$date)
        {
            $item[ "Date" ]=$date;
            array_push($updatedatas,"Date");
        }
        
        //Keep place updated
        $place=$this->RoomsObj()->Sql_Select_Hash_Value($item[ "Room" ],"Place");
        
        if ($item[ "Place" ]!=$place)
        {
            $item[ "Place" ]=$place;
            array_push($updatedatas,"Place");
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages for nonexisting entries.
    //*

    function PostInterfaceMenu($args=array())
    {
        return
            $this->AreasObj()->PostInterfaceMenu()
            &&
            $this->PlacesObj()->PostInterfaceMenu()
            &&
            $this->DatesObj()->PostInterfaceMenu();
    }
        
    //*
    //* function Module_CSS, Parameter list: 
    //*
    //* Generates Areas CSS.
    //*

    function Module_CSS_InLine()
    {
        $where=$this->UnitEventWhere();

        $css="\n";
        foreach ($this->AreasObj()->Sql_Select_Hashes($where,array("ID","Color","Background")) as $area)
        {
            $csshash=
                array
                (
                   "text-align" => 'center',
                   "vertical-align" => 'middle',
                   "color" => $area[ "Color" ],
                   "background-color" => $area[ "Background" ],
                );
            
            $css.=$this->CSS("*.Area".$area[ "ID" ],$csshash);
        }

        return $css;
    }
}

?>