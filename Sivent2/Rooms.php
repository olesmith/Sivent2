<?php

include_once("Rooms/Access.php");



class Rooms extends RoomsAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Rooms($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name");
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Rooms",$table);
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
        if ($module!="Rooms")
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
    //* function RoomTitle, Parameter list: $room,$date=array()
    //*
    //* Returns room title.
    //*

    function RoomTitle($room,$date=array())
    {
        $title=$this->MyMod_ItemName()." ".$room[ "Name" ];
        if (!empty($date))
        {
            $title=$this->DatesObj()->DateTitle($date).": ".$title;
        }
        
        return $title;
    }
    
    //*
    //* function RoomTitleCell, Parameter list: $room,$date=array()
    //*
    //* Returns formatted room title cell.
    //*

    function RoomTitleCell($room,$date=array())
    {
        $cell=$room[ "Name" ];
        if (!empty($date))
        {
            $cell=
                $this->Span
                (
                   $cell,
                   array
                   (
                      "TITLE" => $this->RoomTitle($room,$date),
                   )
                );
        }
        
        return $cell;
    }
    
    //*
    //* function RoomTitleCell, Parameter list: $rooms,$date=array()
    //*
    //* Returns formatted room title cell.
    //*

    function RoomTitleCells($rooms,$date=array())
    {
        $titles=array();
        foreach ($rooms as $room)
        {
            array_push($titles,$this->RoomTitleCell($room,$date));
        }

        return $titles;
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages for nonexisting entries.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->PlacesObj()->ItemExistenceMessage("Places");
        if ($res)
        {
            $res=$this->ItemExistenceMessage();
        }
        
        return $res;
    }
        
     //*
    //* function HandleAdd, Parameter list: $echo=TRUE
    //*
    //* Overrides HandleAdd. Sets suitable default for date.
    //*

    function HandleAdd($echo=TRUE)
    {
        $places=$this->PlacesObj()->GetCurrentPlaces("ID","Name");

        if (!empty($places))
        {
            $this->AddDefaults[ "Place" ]=array_pop($places);
        }

        parent::HandleAdd($echo);
    }
}

?>