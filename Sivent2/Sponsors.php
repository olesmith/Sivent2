<?php

include_once("../EventApp/MySponsors.php");

class Sponsors extends MySponsors
{
    var $Coordinator_Type=9;
    
    //*
    //* function Sponsors, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Sponsors($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Event");
        $this->Sort=array("Name");
        $this->IncludeAllDefault=TRUE;

        $unit=$this->Unit("ID");
        $event=$this->CGI_GETint("Event");
        
        $this->SqlWhere[ "Unit" ]=$unit;
        if (!empty($event) && !preg_match('/^Admin$/',$this->Profile()))
        {
            $this->SqlWhere[ "Event" ]=$event;
            
        }
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
        $this->PostProcessUnitData();
        $this->PostProcessEventData();
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Sponsors")
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