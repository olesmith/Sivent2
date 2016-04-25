<?php

include_once("Certificates/Access.php");
include_once("Certificates/Validate.php");
include_once("Certificates/Latex.php");
include_once("Certificates/Generate.php");



class Certificates extends Certificates_Generate
{
    //*
    //* function Certificates, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Certificates($args=array())
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
        return $this->ApplicationObj()->SqlUnitTableName("Certificates",$table);
    }
    
     //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Areas")
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
    //* function Certificate_Where, Parameter list: $inscription,$type
    //*
    //* Checks whether certificate has been generated.
    //*

    function Certificate_Where($inscription,$type)
    {
        return
            array
            (
               "Unit"   => $inscription[ "Unit" ],
               "Event"  => $inscription[ "Event" ],
               "Friend" => $inscription[ "Friend" ],
               "Type"   => 1,
            );
     }
    
}

?>