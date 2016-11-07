<?php

include_once("MySponsors/Access.php");


class MySponsors extends MySponsorsAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function MySponsors($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->Sort=array("Name");
        $this->NonGetVars=array("Event","CreateTable");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName("Sponsors",$table);
    }

    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function MyMod_Data_Upload_Path()
    {
        $path="Uploads/".$this->Unit("ID")."/Sponsors";
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }

    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
       array_push($this->ActionPaths,"../EventApp/System/Sponsors");
     }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        array_unshift($this->ItemDataGroupPaths,"../EventApp/System/Sponsors");
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_unshift($this->ItemDataPaths,"../EventApp/System/Sponsors");
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $unit=$this->ApplicationObj->Unit("ID");

        $this->AddDefaults[ "Unit" ]=$unit;
        $this->AddFixedValues[ "Unit" ]=$unit;
        $this->ItemData[ "Unit" ][ "Default" ]=$unit;
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
    
    //*
    //* function UnitSponsors, Parameter list: $location
    //*
    //* Returns list of sponsers off the Unit (Event 0).
    //*

    function UnitSponsors($location)
    {
        $unit=$this->Unit("ID");
        $where=array
        (
           "Unit" => $unit,
           "Event" => 0,
           "Place" => $location,
        );

        return $this->Sql_Select_Hashes($where);
    }
    
    //*
    //* function EventSponsors, Parameter list: $event=array()
    //*
    //* Returns list of sponsers off Event.
    //*

    function EventSponsors($location,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        $unit=$this->Unit("ID");

        if (empty($event)) { return array(); }
        
        $where=array
        (
           "Unit" => $unit,
           "Event" => $event[ "ID" ],
           "Place" => $location,
        );

        return $this->Sql_Select_Hashes($where);
    }
    
    //*
    //* function SponsorsCell, Parameter list: $sponsor,$sponsertitleclass
    //*
    //* Produces a row for $sponsor.
    //*

    function SponsorsCell($sponsor)
    {
        $args=array
        (
           "Unit"       => $this->Unit("ID"),
           "ModuleName" => "Sponsors",
           "ID"         => $sponsor[ "ID" ],
           "Action"     => "Download",
           "Data"       => "Logo",
        );
        $cell=
            //$this->Div($sponsor[ "Initials" ].":",array("CLASS" => 'sponsortitle')).
            $this->A
            (
               $sponsor[ "URL" ],
               $this->IMG
               (
                  "?".$this->CGI_Hash2URI($args),
                  $sponsor[ "Text" ],
                  $sponsor[ "Height" ],
                  $sponsor[ "Width" ],
                  array
                  (
                     "TITLE" => $sponsor[ "Name" ].": ".$sponsor[ "Text" ],
                     "BORDER" => "0",
                  )
                ),
               array("TARGET" => '_blank',"CLASS" => 'sponsorlink')
            );

        return "\n".$cell;
    }
   
    //*
    //* function SponsorsTable, Parameter list: $sponsors,$vertical
    //*
    //* Produces a list of Ssponsors.
    //*

    function SponsorsTable($sponsors,$vertical)
    {
        $table=array();
        foreach ($sponsors as $sponsor)
        {
            $cell=$this->SponsorsCell($sponsor);
            if ($vertical)
            {
                $cell=array($cell);
            }

            array_push($table,$cell);
        }

        return $table;
    }

    //*
    //* function ShowSponsors, Parameter list: $location,$event=array()
    //*
    //* Produces a list of sponsors.
    //*

    function ShowSponsors($location,$event=array())
    {
        $vertical=TRUE;
        if ($location==2) { $vertical=FALSE; }
        
        $table=array_merge
        (
           $this->SponsorsTable
           (
              $this->UnitSponsors($location),
              $vertical
           ),
           $this->SponsorsTable
           (
              $this->EventSponsors($location,$event),
              $vertical
           )
        );

        if (empty($table)) { return ""; }

        return
            $this->Div
            (
               $this->MyLanguage_GetMessage("Sponsors_Table_Title"),
               array("CLASS" => 'sponsorstitle')
            ).
            $this->Html_Table
            (
               "",
               $table,
               array("CLASS" => 'sponsorstable',"ALIGN" => 'center'),
               array("CLASS" => 'sponsorstable'),
               array("CLASS" => 'sponsorstable'),
               FALSE,FALSE
            );
    }
}

?>