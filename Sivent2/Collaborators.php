<?php

include_once("Collaborators/Access.php");
include_once("Collaborators/Table.php");



class Collaborators extends CollaboratorsTable
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Collaborators($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","TimeLoad");
        $this->Sort=array("Name");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Collaborators",$table);
    }


    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
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

        if (preg_match('/(Coordinator|Admin)/',$this->Profile()))
        {
            $this->AddDefaults[ "Homologated" ]=2;
        }
        else
        {
            $this->AddDefaults[ "Homologated" ]=1;
        }
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
        if (!preg_match('/(Collaborators|Friends)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        $this->Sql_Select_Hash_Datas_Read($item,array("TimeLoad","Collaboration","Homologated"));
        if (
              empty($item[ "TimeLoad" ])
              &&
              !empty($item[ "Collaboration" ])
           )
        {
            $item[ "TimeLoad" ]=
                $this->CollaborationsObj()->Sql_Select_Hash_Value
                (
                   $item[ "Collaboration" ],
                   "TimeLoad"
                );

            array_push($updatedatas,"TimeLoad");
        }
            
        if (empty($item[ "Homologated" ]))
        {
            $item[ "Homologated" ]=1;
            array_push($updatedatas,"Homologated");
        }
 
        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>