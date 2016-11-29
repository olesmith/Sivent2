<?php

include_once("Caravans/Access.php");
include_once("Caravans/Emails.php");
include_once("Caravans/Caravaneers.php");
include_once("Caravans/Certificate.php");
include_once("Caravans/Statistics.php");



class Caravans extends Caravans_Statistics
{
    var $Certificate_Type=5;
    var $Export_Defaults=
        array
        (
            "NFields" => 5,
            "Data" => array
            (
                1 => "No",
                2 => "Friend__Name",
                3 => "Friend__Email",
                4 => "Homologated",
                5 => "Certificate",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "1",
                3 => "0",
                4 => "0",
                5 => "0",
            ),
        );
    
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
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->AddUnitEventDefault();
        
        $unitid=$this->GetCGIVarValue("Unit");
        $eventid=$this->GetCGIVarValue("Event");
        
        $this->ItemData[ "Unit" ][ "Default" ]=$unitid;
        $this->ItemData[ "Event" ][ "Default" ]=$eventid;
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

        $friend=array("ID" => $item[ "Friend" ]);
        
        $isinscribed=$this->EventsObj()->Friend_Inscribed_Is($this->Event(),$friend);
        if (!$isinscribed)
        {
            $this->InscriptionsObj()->DoInscribe($friend);
        }
        
        return $item;
    }
    
    //*
    //* function AddForm_PostText, Parameter list:
    //*
    //* Pretext function. Shows add inscriptions form.
    //*

    function AddForm_PostText()
    {
        return
            $this->BR().
            $this->FrameIt($this->InscriptionsObj()->DoAdd());
    }
}

?>