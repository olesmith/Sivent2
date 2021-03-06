<?php

include_once("MyInscriptions/Access.php");
include_once("MyInscriptions/Zip.php");
include_once("MyInscriptions/Quest.php");
include_once("MyInscriptions/Inscription.php");
include_once("MyInscriptions/Receit.php");
include_once("MyInscriptions/Handle.php");
include_once("MyInscriptions/Add.php");
include_once("MyInscriptions/Certificate.php");

class MyInscriptions extends MyInscriptions_Certificate
{
    var $InscriptionEventTableSGroups=
        array
        (
           array
           (
              "Basic" => 0,
           ),
           array
           (
              "Inscriptions" => 0,
           ),
         );

    //*
    //* function Inscriptions, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Inscriptions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name");
        $this->Sort=array("Name");
        $this->IncludeAllDefault=TRUE;
    }


    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("Inscriptions",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return join("/",array("..","EventApp","System","Inscriptions","Profiles.php"));
    }
    
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
        array_push($this->ActionPaths,"../EventApp/System/Inscriptions");
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
        $this->Import_Datas=array("Name","Email");
        array_unshift($this->ItemDataGroupPaths,"../EventApp/System/Inscriptions");
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
        $this->AddEventQuestDataGroups();
     }


    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        $this->Sql_Table_Column_Rename("Candidate","Friend");

        
        array_unshift($this->ItemDataPaths,"../EventApp/System/Inscriptions");

        $unitid=$this->ApplicationObj->Unit("ID");
        $eventid=$this->ApplicationObj->Event("ID");

        $this->AddDefaults[ "Unit" ]=$unitid;
        $this->AddFixedValues[ "Unit" ]=$unitid;
        $this->ItemData[ "Unit" ][ "Default" ]=$unitid;

        $this->AddDefaults[ "Event" ]=$eventid;
        $this->AddFixedValues[ "Event" ]=$eventid;
        $this->ItemData[ "Event" ][ "Default" ]=$eventid;
   }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->AddEventQuestDatas();
        $this->ItemDataGroups();
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
        $this->Sql_Select_Hash_Datas_Read($item,array("Friend","Name"));

        $name=$this->FriendsObj()->Friend_Name_Text($item[ "Friend" ]);
        
        
        $updatedatas=array();
        if (empty($item[ "Name" ]) || $item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }

        $this->Sql_Select_Hash_Datas_Read
        (
            $item,
            array_merge
            (
                $this->MyMod_Item_Groups_Compulsory_Data($this->InscriptionSGroups(0),True),
                array("Status","Completed")
            )
        );
        
        if ($item[ "Status" ]==1 || !$this->Inscription_Complete($item))
        {
            if (empty($item[ "Complete" ]) || $item[ "Complete" ]!=1)
            {
                $item[ "Complete" ]=1;
                array_push($updatedatas,"Complete");
            }
        }
        else
        {
            if (empty($item[ "Complete" ]) || $item[ "Complete" ]!=2)
            {
                $item[ "Complete" ]=2;
                array_push($updatedatas,"Complete");
            }
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>