<?php

include_once("Criterias/Access.php");


class Criterias extends CriteriasAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Criterias($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name","Name_UK","Weight");

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
        return $this->ApplicationObj()->SqlEventTableName("Criterias",$table);
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
        if ($module!="Criterias")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        if (empty($item[ "Name_UK" ]))
        {
            $item[ "Name_UK" ]=$item[ "Name" ];
            array_push($updatedatas,"Name_UK");
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
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->ItemExistenceMessage();
        if ($res)
        {
            $res=$this->SubmissionsObj()->ItemExistenceMessage("Submissions");
        }

        return $res;
    }
    
    //*
    //* function Criterias_Read, Parameter list: $datas=array(),$where=array()
    //*
    //* Reads all U nit/Event criterias.
    //*

    function Criterias_Read($datas=array(),$where=array())
    {
        return
            $this->CriteriasObj()->Sql_Select_Hashes
            (
               $this->UnitEventWhere($where),
               $datas
            );
    }
}

?>