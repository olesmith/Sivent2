<?php

include_once("Places/Access.php");



class Places extends PlacesAccess
{
    var $Export_Defaults=
        array
        (
            "NFields" => 3,
            "Data" => array
            (
                1 => "No",
                2 => "Name",
                3 => "Title",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "1",
                3 => "0",
            ),
        );
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Places($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name");
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
        return $this->ApplicationObj()->SqlEventTableName("Places",$table);
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
        if ($module!="Places")
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
    //* function PlaceTitle, Parameter list: $place,$date=array()
    //*
    //* Returns room title.
    //*

    function PlaceTitle($place,$room=array())
    {
        $title=
            $this->MyMod_ItemName()." ".
        //$this->MyLanguage_GetMessage("Schedule_Place_Title").": ".
            $place[ "Name" ].", ".$place[ "Title" ].
            "";
        if (!empty($room))
        {
            $title=$this->RoomsObj()->RoomTitle($room).": ".$title;
        }
        
        return $title;
    }
    
    //*
    //* function PlaceTitleCell, Parameter list: $place,$room=array()
    //*
    //* Returns formatted room title cell.
    //*

    function PlaceTitleCell($place,$room=array())
    {
        $cell=$place[ "Name" ];
        if (!empty($date))
        {
            $cell=
                $this->Span
                (
                   $cell,
                   array
                   (
                      "TITLE" => $this->PlaceTitle($place,$room),
                   )
                );
        }
        
        return $cell;
    }
    
    //*
    //* function PlaceTitleCell, Parameter list: $places,$room=array()
    //*
    //* Returns formatted room title cell.
    //*

    function PlaceTitleCells($places,$room=array())
    {
        $titles=array();
        foreach ($places as $place)
        {
            array_push($titles,$this->PlaceTitleCell($place,$room));
        }

        return $titles;
    }
    
    //*
    //* function PlaceTitle00, Parameter list: $place
    //*
    //* Generates date scedule date.
    //*

    function PlaceTitle00($place)
    {
        return
            $this->MyLanguage_GetMessage("Schedule_Place_Title").": ".
            $place[ "Name" ].", ".$place[ "Title" ].
            "";
    }
    
    //*
    //* function GetCurrentPlaces, Parameter list: 
    //*
    //* Returns ordered list of current places.
    //*

    function GetCurrentPlaces($key="Name",$sortkey="",$sortnumeric=TRUE)
    {
        $keys=array($key);
        if (empty($sortkey))
        {
            $sortkey=$key;
        }
        else
        {
            array_push($keys,$sortkey);
        }
        
        $items=$this->Sql_Select_Hashes($this->UnitEventWhere(),$keys);
        $ritems=array();
        foreach ($items as $item)
        {
            $ritems[ $item[ $sortkey ] ]=$item;
        }

        $rkeys=array_keys($ritems);
        if ($sortnumeric) sort($rkeys,SORT_NUMERIC);
        else              sort($rkeys);

        $items=array();
        foreach ($rkeys as $rkey)
        {
            $item=$ritems[ $rkey ];
             array_push($items,$item[ $key ]);
        }
        
        return $items;
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages for nonexisting entries.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->ItemExistenceMessage();
        if ($res)
        {
            $res=$this->RoomsObj()->ItemExistenceMessage("Rooms");
        }

        return $res;
    }
        
}

?>