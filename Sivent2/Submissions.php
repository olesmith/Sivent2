<?php

include_once("Submissions/Access.php");
include_once("Submissions/Table.php");



class Submissions extends SubmissionsTable
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Submissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Status","TimeLoad");
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
        return $this->ApplicationObj()->SqlEventTableName("Submissions",$table);
    }


    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function GetUploadPath()
    {
        $path=
            join
            (
               "/",
               array
               (
                  "Uploads",
                  $this->Unit("ID"),
                  $this->Event("ID"),
                  "Submissions"
               )
            );
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }
    
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions_disabled()
    {
    }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions_disabled()
    {
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups_disabled()
    {
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups_disabled()
    {
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData_disabled()
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

    function PostInit_disabled()
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
        if (!preg_match('/(Submissions|Friends)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        $this->Sql_Select_Hash_Datas_Read($item,array("Author1"));


        //Take default author names, if empty
        $hash=array
        (
           "Friend"  => "Author1",
           "Friend2" => "Author2",
           "Friend3" => "Author3",
        );

        foreach ($hash as $fkey => $akey)
        {
            if (empty($item[ $akey ]) && !empty($item[ $fkey ]))
            {
                $item[ $akey ]=$this->FriendsObj()->Sql_Select_Hash_Value($item[ $fkey ],"Name");
                array_push($updatedatas,$akey);
            }
        }

        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* Overrides InitAddDefaults.
    //* Updates Friend to AddDefaults and AddFixedValues,
    //* then calls parent.
    //*

    function InitAddDefaults()
    {
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->LoginData("ID");
            $this->AddFixedValues[ "Friend" ]=$this->CGI_GETint("Friend");
            if (!empty($this->AddDefaults[ "Friend" ]))
            {
                $this->AddDefaults[ "Author1" ]=$this->LoginData("Name");
            }
        }
        elseif (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->CGI_GETint("Friend");
        }
        
        return parent::InitAddDefaults();
    }
}

?>