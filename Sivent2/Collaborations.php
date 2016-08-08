<?php

include_once("Collaborations/Access.php");



class Collaborations extends CollaborationsAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Collaborations($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
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
        return $this->ApplicationObj()->SqlEventTableName("Collaborations",$table);
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
        if ($module!="Collaborations")
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
    //* function Collaborations_Collaborators_Noof_Cell, Parameter list: $collaboration=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Collaborations_Collaborators_Noof_Cell($collaboration=array())
    {
        if (empty($collaboration))
        {
            return $this->MyLanguage_GetMessage("Collaborations_Collaborators_Cell_Noof_Title");
        }
        
        $ninscribed=$this->CollaboratorsObj()->Sql_Select_NEntries
        (
           array
           (
              "Collaboration" => $collaboration[ "ID" ],
           )
        );

        if (empty($ninscribed)) { $ninscribed="-"; }
        
        return $ninscribed;
        
    }
     //*
    //* function Collaborations_Collaborators_NHomologated_Cell, Parameter list: $collaboration=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Collaborations_Collaborators_NHomologated_Cell($collaboration=array())
    {
        if (empty($collaboration))
        {
            return $this->MyLanguage_GetMessage("Collaborations_Collaborators_Cell_NHomologated_Title");
        }
        
        $ninscribed=$this->CollaboratorsObj()->Sql_Select_NEntries
        (
           array
           (
              "Collaboration" => $collaboration[ "ID" ],
              "Homologated" => 2,
           )
        );

        if (empty($ninscribed)) { $ninscribed="-"; }
        
        return $ninscribed;
        
    }
    
   
}

?>