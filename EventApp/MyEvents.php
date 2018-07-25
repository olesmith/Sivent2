<?php

include_once("MyEvents/Access.php");
include_once("MyEvents/Friend.php");
include_once("MyEvents/Cells.php");
include_once("MyEvents/Datas.php");
include_once("MyEvents/DataGroups.php");
include_once("MyEvents/Info.php");
include_once("MyEvents/Tables.php");
include_once("MyEvents/Create.php");
include_once("MyEvents/Certificate.php");
include_once("MyEvents/Certificates.php");
include_once("MyEvents/Handle.php");

class MyEvents extends MyEvents_Handle
{
    var $Unit2EventData=array
    (
       "State","Address","Phone","Fax","Url","Email","City","Area","ZIP",
       "Auth","Secure","Port","Host","User","Password","FromEmail","FromName","ReplyTo","BCCEmail",
       "MailHead","MailTail","MailHead_UK","MailTail_UK",
    );

    var $Today2EventData=array("Date","StartDate");
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function MyEvents($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Name","Status","StartDate","EndDate");
        $this->Sort=array("Name");
        $this->IDGETVar="Event";
        $this->NonGetVars=array("Event","CreateTable");
        
        $this->MyEvents_CellMethods_Init();
    }

    //*
    //* function MyEvents_CellMethods, Parameter list: 
    //*
    //* Adds cell methods.
    //*

    function MyEvents_CellMethods_Init()
    {
        $this->CellMethods=
            array_merge
            (
                array
                (
                    "Event_Date_Span_Cell" => TRUE,
                    "Event_Inscriptions_Date_Span_Cell" => TRUE,
                    "NoOfInscriptionsCell" => TRUE,
                    "Event_PreInscriptions_DateSpan" => TRUE,
                    "Event_PreInscriptions_Status" => TRUE,
                    "Events_Status_Cell"  => TRUE,
                    "Event_Title_Show"  => TRUE,
                    "Event_Period_Show"  => TRUE,
                    "Event_Place_Show"  => TRUE,
                    "Event_Inscriptions_Period_Show" => True,
                    "Event_Inscription_Action" => True,
                )
            );
    }


    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName("Events",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return join("/",array("..","EventApp","System","Events","Profiles.php"));
    }
    
    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function MyMod_Data_Upload_Path()
    {
        $path="Uploads/".$this->Unit("ID")."/Events";
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
        array_push($this->ActionPaths,"../EventApp/System/Events");
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
        array_push($this->ItemDataGroupPaths,"../EventApp/System/Events");
        
        array_push($this->ItemDataGroupFiles,"Groups.Mail.php");
        array_push($this->ItemDataSGroupFiles,"SGroups.Mail.php");
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
        array_unshift($this->ItemDataPaths,"../EventApp/System/Events");
        array_unshift($this->ItemDataPaths,"../EventApp/System/Units");
        array_push($this->ItemDataFiles,"Data.Mail.php");
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->ItemData[ "State" ][ "Values" ]=$this->ApplicationObj()->States_Short;
        $this->ItemData[ "State" ][ "Default" ]=9;//GO...
        
        $this->InscriptionsObj()->ItemData("ID");
        $this->InscriptionsObj()->ItemDataGroups("Basic");
        $this->InscriptionsObj()->Actions("Search");


        $this->Unit2ItemData();
        $this->Today2ItemData();
        
        $this->ItemData[ "HtmlIcon1" ][ "Coordinator" ]=2;
        $this->ItemData[ "HtmlIcon2" ][ "Coordinator" ]=2;
        $this->ItemData[ "Initials" ][ "Coordinator" ]=2;
    }

    //*
    //* function Unit2ItemData, Parameter list:
    //*
    //* Transfers data in $this->Unit2EventData from current unit to
    //* Add defaults and fixed values.
    //*

    function Unit2ItemData()
    {
        $unit=$this->ApplicationObj->Unit();
        if (empty($unit)) { return; }
        

        $this->AddDefaults[ "Unit" ]=$unit[ "ID" ];
        $this->AddFixedValues[ "Unit" ]=$unit[ "ID" ];
        $this->ItemData[ "Unit" ][ "Default" ]=$unit[ "ID" ];
        foreach ($this->Unit2EventData as $key)
        {
            if (!empty($this->ItemData[ $key ]) && !is_array($unit[ $key ]))
            {
                $this->AddDefaults[ $key ]=$unit[ $key ];
                $this->ItemData[ $key ][ "Default" ]=$unit[ $key ];
            }
        }
    }
    
    //*
    //* function Today2ItemData, Parameter list:
    //*
    //* Transfers data in $this->Today2EventData from todays date
    //* Add defaults and fixed values.
    //*

    function Today2ItemData()
    {
        $today=$this->MyTime_2Sort();
        foreach ($this->Today2EventData as $key)
        {
            $this->AddDefaults[ $key ]=$today;
        }
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
    //* function Unit2Event, Parameter list: &$item
    //*
    //* Takes undefined keys $this->ApplicationObj()->Event2MailInfo
    //* in $item, from $this->ApplicationObj()->Unit.
    //*

    function Unit2Event(&$item)
    {
        $updatedatas=$this->MyHash_Keys_Take
        (
           $this->ApplicationObj()->Unit,
           $this->ApplicationObj()->Event2MailInfo,
           $item
        );
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return count($updatedatas);
    }
    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Events")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->Unit2Event($item);

        $this->Sql_Select_Hash_Datas_Read($item,array("Status","StartDate","EndDate"));
        
        $updatedatas=array();
        if (
              !empty($item[ "StartDate" ])
              &&
              !empty($item[ "EndDate" ])
           )
        {
            $status=3;
            if ($this->Events_Open_Is($item))
            {
                $status=2;
            }
            
            if ($this->Events_Open_Premature($item))
            {
                $status=1;
            }

            if ($item[ "Status" ]!=$status)
            {
                $item[ "Status" ]=$status;
                array_push($updatedatas,"Status");
                
            }
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }

    //*
    //* function  EventHorisontalMenues, Parameter list: $event
    //*
    //* Prints horistonal menu for $event.
    //*

    function EventHorisontalMenu($event)
    {
        return "";
        if (empty($event)) { return ""; }
        
        return 
            $this->MyMod_HorMenu_Actions
            (
             array("Datas","GroupDatas"),
               "atablemenu",
               $event[ "ID" ],
               $event
            ).
            "";
    }

    //*
    //* function PostInterfaceMenu, Parameter list: $plural=FALSE,$id=""
    //*
    //* Interface menu postprocessor. Called by MyMod_HorMenu.
    //* Prints horisontal menu of Singular and Plural actions.
    //*

    function PostInterfaceMenu($plural=FALSE,$id="")
    {
        echo
            $this->BR().
            $this->EventHorisontalMenu($this->ApplicationObj->Event());
    }
    //*
    //* function HasChildrenItems, Parameter list: $event
    //*
    //* Returns TRUE if no children items, here:
    //*
    //* Inscriptions, Datas and GroupDatas.
    //*

    function HasChildrenItems($event)
    {
        $where=array
        (
           "Unit" => $event[ "Unit" ],
           "Event" => $event[ "ID" ],
        );

        
        $res=$this->MyMod_Item_Children_Has
        (
           array("InscriptionsObj","DatasObj","GroupDatasObj"),
           array
           (
              "Unit" => $event[ "Unit" ],
              "Event" => $event[ "ID" ],
           )
        );

        return $res;
    }

    
    //*
    //* function Event_DateSpan, Parameter list: $edit
    //*
    //* Returns event dates span cell.
    //*

    function Event_DateSpan($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Interval($event,"EventStart","EventEnd");
    }
    
    //*
    //* function Event_Place, Parameter list: $edit
    //*
    //* Returns event place cell.
    //*

    function Event_Place($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $comps=array();
        foreach (array("Place",) as $key)
        {
            if (!empty($event[ $key ]))
            {
                array_push($comps,$event[ $key ]);
            }
        }
        
        return join(" - ",$comps);
    }
    
    //*
    //* function Event_Inscriptions_DateSpan, Parameter list: $edit
    //*
    //* Returns event inscriptions date span cell.
    //*

    function Event_Inscriptions_DateSpan($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Interval($event,"StartDate","EndDate");
    }
    
    
    
    //*
    //* function MyMod_Messages_Files, Parameter list: 
    //*
    //* Returns list of module messaged files.
    //*

    function MyMod_Messages_Files()
    {
        return 
            array_merge
            (
               array
               (
                  "../EventApp/System/Events/LeftMenu.php",
               ),
               parent::MyMod_Messages_Files()
            );
    }
}

?>