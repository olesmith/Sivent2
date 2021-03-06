<?php

include_once("Assessors/Access.php");
include_once("Assessors/Inscription.php");
include_once("Assessors/Submission.php");
include_once("Assessors/Statistics.php");


class Assessors extends Assessors_Statistics
{
    var $Certificate_Type=6;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Assessors($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name","Friend","Submission","Result");

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
        return $this->ApplicationObj()->SqlEventTableName("Assessors",$table);
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
        if ($module!="Assessors")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $friend=array("ID" => $item[ "Friend" ]);

        $event=array("ID" => $this->Event("ID"));
        if (!empty($item[ "Event" ]))
        {
            $event=array("ID" => $item[ "Event" ]);
        }
        
        $isinscribed=$this->EventsObj()->Friend_Inscribed_Is($event,$friend);
        if (!$isinscribed)
        {
            $this->InscriptionsObj()->DoInscribe($friend);
        }

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
        $res=$this->SubmissionsObj()->Item_Existence_Message("Submissions");

        return $res;
    }

    
    //*
    //* function MyMod_Handle_Edit, Parameter list: 
    //*
    //* Overrides module MyMod_Handle_Edit: adds assessments table..
    //*
    
    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="", $noupdate = false)
    {
        parent::MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="", $noupdate = false);

        echo
            $this->Assessors_Inscription_Assessments_Form(1,$this->ItemHash).
            "";
    }
    
    //*
    //* function Assessor_Field, Parameter list:
    //*
    //* Field generating method for submissions activities form.
    //*

    function Assessor_Field($data,$assessor=array())
    {
        $rdata=$data;
        if (!empty($assessor[ "ID" ]))
        {
            $rdata=$assessor[ "ID" ]."_Friend";
        }
        
        return
            $this->MyMod_Data_Fields_Module_Edit
            (
                $data,
                $assessor,
                $value="",$tabindex="",$plural=FALSE,$options=array(),
                $rdata
            );
    }
    
    //*
    //* function MyMod_Handle_Add_Form_Text_Post, Parameter list:
    //*
    //* Pretext function. Shows add inscriptions form.
    //*

    function MyMod_Handle_Add_Form_Text_Post()
    {
        return
            $this->BR().
            $this->FrameIt($this->InscriptionsObj()->DoAdd());
    }

    
    //* function EventMod_Import_Events_Update_Compulsories, Parameter list: $dest_event,$dest_item
    //*
    //* Returns a module specific $hash of compulsory values.
    //* Supposed to be overriden by specific modules!!!
    //*

    function EventMod_Import_Events_Update_Compulsories($dest_event,$dest_item)
    {
        $dest_item=parent::EventMod_Import_Events_Update_Compulsories($dest_event,$dest_item);
        
        #$dest_item[ "Certificate" ]=1;
        #$dest_item[ "Code" ]=" ";

        foreach (array("HasAssessed","HasAccessed",) as $data)
        {
            $dest_item[ $data ]=1;
        }
        foreach (array("Result",) as $data)
        {
            $dest_item[ $data ]=0.0;
        }
        
        foreach (array("CoordComment","FriendComment",) as $data)
        {
            $dest_item[ $data ]="";
        }
        
        return $dest_item;
    }
}

?>