<?php

include_once("Times/Access.php");



class Times extends TimesAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Times($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Event","Sort","Name","Duration","StartHour","StartMin","EndHour","EndMin",);
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Sort","Name");

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
        return $this->ApplicationObj()->SqlEventTableName("Times",$table);
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
        if ($module!="Times")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $start=$item[ "StartHour" ]*60+$item[ "StartMin" ];
        $end=$item[ "EndHour" ]*60+$item[ "EndMin" ];
        
        if ($start>$end)
        {
            $tmp=$item[ "StartHour" ];
            $item[ "StartHour" ]=$item[ "EndHour" ];
            $item[ "EndHour" ]=$tmp;
            
            $tmp=$item[ "StartMin" ];
            $item[ "StartMin" ]=$item[ "EndMin" ];
            $item[ "EndMin" ]=$tmp;

            array_push($updatedatas,"StartHour","StartMin","EndHour","EndMin");
        }

        $duration=abs($end-$start);
        if (empty($item[ "Duration" ]) || $item[ "Duration" ]!=$duration)
        {
            $item[ "Duration" ]=$duration;
            array_push($updatedatas,"Duration");
        }
        
        $name=sprintf("%02d:%02d-%02d:%02d",$item[ "StartHour" ],$item[ "StartMin" ],$item[ "EndHour" ],$item[ "EndMin" ]);
        if (empty($item[ "Name" ]) || $item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }
        
        $sort=
            $this->DatesObj()->Sql_Select_Hash_Value(array("ID" => $item[ "Date" ]),"Name").
            $name;
        
        if (empty($item[ "Sort" ]) || $item[ "Sort" ]!=$sort)
        {
            $item[ "Sort" ]=$sort;
            array_push($updatedatas,"Sort");
        }
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function TimeTitle, Parameter list: $time,$date=array()
    //*
    //* Returns $time title.
    //*

    function TimeTitle($time,$date=array())
    {
        $title=$time[ "Name" ];
        if (!empty($date))
        {
            $title=$this->DatesObj()->DateTitle($date).": ".$title;
        }
        
        return $title;
    }
    
    //*
    //* function TimeTitleCell, Parameter list: $room,$date=array()
    //*
    //* Returns formatted $time title cell.
    //*

    function TimeTitleCell($time,$date=array())
    {
        $cell=$time[ "Name" ];
        if (!empty($date))
        {
            $cell=
                $this->Span
                (
                   $cell,
                   array
                   (
                      "TITLE" => $this->TimeTitle($time,$date),
                   )
                );
        }
        
        return $cell;
    }
    
     //*
    //* function HandleAdd, Parameter list: $echo=TRUE
    //*
    //* Overrides HandleAdd. Sets suitable default for date.
    //*

    function HandleAdd($echo=TRUE)
    {
        $dates=$this->DatesObj()->GetCurrentDates("ID","Name");

        if (!empty($dates))
        {
            $this->AddDefaults[ "Date" ]=array_pop($dates);
        }

        parent::HandleAdd($echo);
    }
    
     //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages for nonexisting entries.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->DatesObj()->ItemExistenceMessage("Dates");
        if ($res)
        {
            $res=$this->ItemExistenceMessage();
        }

        return $res;
     }
        
}

?>