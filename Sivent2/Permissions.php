<?php

include_once("../EventApp/MyPermissions.php");

class Permissions extends MyPermissions
{
    //*
    //* function Permissions, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Permissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->Sort=array("Name");
        $this->NonGetVars=array("Event","CreateTable");
    }


    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
        parent::PreActions();
    }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
        parent::PostActions();
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        parent::PreProcessItemDataGroups();
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
         parent::PostProcessItemDataGroups();
   }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        parent::PreProcessItemData();
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

    function PostInit()
    {
        parent::PostInit();
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Permissions")
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