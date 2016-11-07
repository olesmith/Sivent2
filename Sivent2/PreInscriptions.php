<?php

include_once("PreInscriptions/Access.php");
include_once("PreInscriptions/Submissions.php");
include_once("PreInscriptions/Inscription.php");
include_once("PreInscriptions/Handle.php");


class PreInscriptions extends PreInscriptionsHandle
{
    var $Export_Defaults=
        array
        (
            "NFields" => 3,
            "Data" => array
            (
                1 => "No",
                2 => "Friend__Name",
                3 => "Friend__Email",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "1",
            ),
        );
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function PreInscriptions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");

        $this->Coordinator_Type=6;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("PreInscriptions",$table);
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
        if ($module!="PreInscriptions")
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

    
    //*
    //* function MyMod_Items_Latex, Parameter list: $items=array()
    //*
    //* Overrides MyMod MyMod_Items_Latex.
    //* Splits item per Submission and generates signatures list
    //* foreach one.
    //* 
    //*

    function MyMod_Items_Latex($items=array())
    {
        if (empty($items)) { $items=$this->ItemHashes; }

      
        $latexes=array();
        foreach ($this->MyHash_HashesList_Key($items,"Submission") as $sid => $sitems)
        {
            $submission=
                $this->SubmissionsObj()->Sql_Select_Hash
                (
                   $this->UnitEventWhere(array("ID" => $sid))
                );

            $slatex=
                $this->FilterHash
                (
                   parent::MyMod_Items_Latex($sitems),
                   $submission,
                   "Submission_"
                );

            $latex="";
            foreach ($this->SubmissionsObj()->Submission_Schedules_Read(array(),$submission) as $schedule)
            {
                $schedule=$this->SchedulesObj()->MyMod_Data_Fields_Enums_ApplyAll($schedule,TRUE);
                $latex.=
                    $this->FilterHash($slatex,$schedule).
                    "\n\n\\clearpage\n\n";
            }

            $latexes[ $submission[ "Name" ].$submission[ "ID" ] ]=$latex;
        }

        $keys=array_keys($latexes);
        sort($keys);

        $latex="";
        foreach ($keys as $key)
        {
            $latex.=$latexes[ $key ];
        }
        
        //$this->ShowLatexCode($latex);exit();
        return $latex;
    }
    
    //*
    //* function InitPrint, Parameter list: $item
    //*
    //* BarCode is Friend barcode.
    //*

    function InitPrint($item)
    {
        $inscription=
            $this->InscriptionsObj()->Sql_Select_Hash
            (
               $this->UnitEventWhere(array("Friend" => $item[ "Friend" ])),
               array("ID","Code")    
            );

        $item[ "Code" ]=$inscription[ "Code" ];
        $item[ "Code_File" ]=$this->InscriptionsObj()->BarCode_Generate($inscription);
        
        return $item;
    }
    

  
}

?>