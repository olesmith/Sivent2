<?php

include_once("../EventApp/MyEvents.php"); 


include_once("Events/Cells.php");
include_once("Events/Create.php");
include_once("Events/Collaborations.php");
include_once("Events/Caravans.php");
include_once("Events/Payments.php");
include_once("Events/Submissions.php");
include_once("Events/PreInscriptions.php");
include_once("Events/Schedules.php");
include_once("Events/Certificates.php");
include_once("Events/Certificate.php");

class Events extends EventsCertificate
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Events($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Name","Certificates","Collaborations","Collaborations");
        $this->Sort=array("Name");
        $this->IDGETVar="Event";
        $this->IncludeAllDefault=TRUE;
        $this->NonGetVars=array("Event","CreateTable");
    }


    //*
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return "System/Events/Profiles.php";
    }
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlUnitTableName("Events",$table);
    }

    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function GetUploadPath()
    {
        $path="Uploads/".$this->Unit("ID")."/Events";
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push
        (
           $this->ItemDataFiles,
           "Data.Selection.php",
           "Data.Certificates.php",
           "Data.Collaborations.php",
           "Data.Caravans.php",
           "Data.Submissions.php",
           "Data.PreInscriptions.php"
        );
        
        parent::PreProcessItemData();
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
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        parent::PostProcessItemData();
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        parent::PostInit();
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
            
        return parent::PostProcess($item);
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
    //* function EventCertificates, Parameter list:$event=array()
    //*
    //* Returns TRUE if $event (or $this->Event()) has certificates.
    //*

    function EventCertificates($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $res=TRUE;
        if (!empty($event) && $event[ "Certificates" ]!=2)
        {
            $res=FALSE;
        }

        return $res;
    }
    
    //*
    //* function MyMod_Handle_Event_Menu, Parameter list: 
    //*
    //* Creates horisontal menu with access to different SGroups.
    //*

    function MyMod_Handle_Event_Menu()
    {
        $args=$this->CGI_URI2Hash();

        $subactions=$this->ReadPHPArray("System/Events/SubActions.php");
        
        $currsubaction=$this->CGI_GET("SubAction");

        $hrefs=array();
        foreach ($subactions as $subaction => $def)
        {
            $args[ "SubAction" ]=$subaction;

            $href=$this->GetRealNameKey($def);
            if ($subaction!=$currsubaction)
            {
                $href=$this->Href
                (
                   "?".$this->CGI_Hash2URI($args),
                   $href,
                   "",
                   "",
                   "",
                   FALSE,
                   array(),
                   "HorMenu"
                );
            }
            
            array_push($hrefs,$href);
        }
        
        return
            $this->Center
            (
               "[ ".
               join(" | ",$hrefs).
               " ]"
            );
    }
    
    //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Overrides module object Edit handler.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        echo $this->MyMod_Handle_Event_Menu();

        $subaction=$this->CGI_GET("SubAction");

        $agroups=array();
        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (!empty($this->ItemDataSGroups[ $group ][ "SubAction" ]))
            {
                if ($this->ItemDataSGroups[ $group ][ "SubAction" ]==$subaction)
                {
                    $agroups[ $group ]=$this->ItemDataSGroups[ $group ];
                }
                unset($this->ItemDataSGroups[ $group ]);
            }
        }
        
        foreach (array_keys($agroups) as $group)
        {
            $this->ItemDataSGroups[ $group ]=$agroups[ $group ];
        }
        
        return parent::MyMod_Handle_Edit($echo,$formurl,$title,$noupdate);
    }

    
}

?>