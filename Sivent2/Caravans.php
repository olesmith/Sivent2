<?php

include_once("Caravans/Access.php");
include_once("Caravans/Caravaneers.php");
include_once("Caravans/Certificate.php");



class Caravans extends Caravans_Certificate
{
    var $Certificate_Type=5;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Caravans($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Email","TimeLoad","Registration","NParticipants");
        $this->Sort=array("Name");

        $this->IncludeAllDefault=TRUE;

        $this->Coordinator_Type=4;
    }

    
    //*
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return "System/Caravans/Profiles.php";
    }
    
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Caravans",$table);
    }


    

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/(Caravans|Friends|Inscriptions)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $this->Sql_Select_Hash_Datas_Read($item,array("NParticipants"));
        
        $where=$this->UnitEventWhere(array("Friend" => $item[ "Friend" ]));
        $ncaravaneers=$this->CaravaneersObj()->Sql_Select_NHashes($where);
        if ($item[ "NParticipants" ]!=$ncaravaneers)
        {
            $item[ "NParticipants" ]=$ncaravaneers;
            array_push($updatedatas,"NParticipants");
        }
                
        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>