<?php

include_once("Caravaneers/Access.php");
include_once("Caravaneers/Table.php");
include_once("Caravaneers/Certificate.php");



class Caravaneers extends Caravaneers_Certificate
{
    var $Certificate_Type=2;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Caravaneers($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Email","TimeLoad","Registration","Certificate","Certificate_CH");
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
        return $this->ApplicationObj()->SqlEventTableName("Caravaneers",$table);
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
        if (!preg_match('/(Caravaneers|Caravans|Inscriptions)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        if (!empty($item[ "Email" ]))
        {
            $friend=$this->FriendsObj()->Sql_Select_Hash(array("Email" => $item[ "Email" ],array("ID")));
            if (!empty($friend) && $item[ "Registration" ]!=$friend[ "ID" ])
            {
                $item[ "Registration" ]=$friend[ "ID" ];
                array_push($updatedatas,"Registration");
            }
        }
        else
        {
        }
        
        $this->Sql_Select_Hash_Datas_Read($item,array("TimeLoad","Code","Certificate"));
        
        $this->PostProcess_Certificate_TimeLoad($item,$updatedatas);
        $this->PostProcess_Code($item,$updatedatas);
        $this->PostProcess_Certificate($item);

        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>