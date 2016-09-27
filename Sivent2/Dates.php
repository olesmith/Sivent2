<?php

include_once("Dates/Access.php");



class Dates extends DatesAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Dates($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Title");
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");

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
        return $this->ApplicationObj()->SqlEventTableName("Dates",$table);
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
        if ($module!="Dates")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        if (!empty($item[ "Name" ]))
        {
            $title=$this->MyTime_Sort2Date($item[ "Name" ]);
            if (empty($item[ "Title" ]) || $item[ "Title" ]!=$title)
            {
                $item[ "Title" ]=$title;
                array_push($updatedatas,"Title");
            }
        }
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function DateTitle, Parameter list: $date
    //*
    //* Returns date title.
    //*

    function DateTitle($date)
    {
        return $this->MyTime_Sort2Date($date[ "Name" ]);
    }
    
    //*
    //* function GetCurrentDates, Parameter list: 
    //*
    //* Returns ordered list of current dates.
    //*

    function GetCurrentDates($key="Name",$sortkey="",$sortnumeric=TRUE)
    {
        if (empty($sortkey)) $sortkey=$key;
        
        $dates=$this->Sql_Select_Hashes($this->UnitEventWhere(),array($key,$sortkey));
        $rdates=array();
        foreach ($dates as $date)
        {
            $rdates[ $date[ $sortkey ] ]=$date;
        }

        $rkeys=array_keys($rdates);
        if ($sortnumeric) sort($rkeys,SORT_NUMERIC);
        else              sort($rkeys);

        $dates=array();
        foreach ($rkeys as $rkey)
        {
            $date=$rdates[ $rkey ];
             array_push($dates,$date[ $key ]);
        }
        
        return $dates;
    }
    
     //*
    //* function HandleAdd, Parameter list: $echo=TRUE
    //*
    //* Overrides HandleAdd. Sets suitable default for date.
    //*

    function HandleAdd($echo=TRUE)
    {
        $dates=$this->GetCurrentDates();
        
        $default="";
        if (empty($dates))
        {
            $default=$this->Event("EventStart");
        }
        else
        {
            $last=array_pop($dates);
            //Elaborate
            $default=$last+1;
        }

        $this->AddDefaults[ "Name" ]=$default;
        
        return parent::HandleAdd($echo);
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->ItemExistenceMessage();
        if ($res)
        {
            $res=$this->TimesObj()->ItemExistenceMessage("Times");
        }

        return $res;
    }
        
}

?>