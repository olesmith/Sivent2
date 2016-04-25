<?php

include_once("../EventApp/EventMod.php");

class ModulesCommon extends EventMod
{
    //*
    //* sub Unit, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Unit($key="")
    {
        return $this->ApplicationObj()->CGI_GET2Hash("Unit","UnitsObj",$key,"Unit");
    }

    //*
    //* sub Event, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Event($key="")
    {
        return $this->ApplicationObj()->CGI_GET2Hash("Event","EventsObj",$key,"Event",FALSE);
    }

    //*
    //* function PrintDocHeads, Parameter list: 
    //*
    //* Overrides Application::PrintDocHeads.
    //*

    function PrintDocHeads()
    {
        $this->ApplicationObj()->MyApp_Interface_Head();

        echo $this->ApplicationObj->AppInfo();
    }


    //*
    //* function SetEvent, Parameter list: 
    //*
    //* Sets $this->ApplicationObj->Event to $event.
    //*

    function SetEvent($event)
    {
        $this->ApplicationObj->Event=$event;
    }


    //*
    //*
    //* function SqlEventTableName, Parameter list: $table="",$event=array()
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlEventTableName($module,$event=array())
    {
        $table="#Unit__#Event_".$module;

        $eventid=0;
        if ($this->CGI_GET("ModuleName")=="Events")
        {
            $eventid=$this->CGI_GET("ID");
        }

        if (empty($eventid))
        {
            $eventid=$this->CGI_GET("Event");
        }

        if (!empty($event))
        {
            $eventid=$event[ "ID" ];
        }

        $table=preg_replace('/#Event/',$eventid,$table);

        return preg_replace('/#Unit/',$this->ApplicationObj->Unit("ID"),$table);
    }
    
    //*
    //* sub MyMod_Mail_Texts_Get, Parameter list: $files=array()
    //*
    //* Returns contents of Mail Texts file.
    //*
    //*

    function MyMod_Mail_Texts_Get($files=array())
    {
        if (empty($files))
        {
            $files=array
            (
               "../EventApp/System/".$this->ModuleName."/Mail.Data.php",
               "System/".$this->ModuleName."/Mail.Data.php"
            );
        }
        
        return parent::MyMod_Mail_Texts_Get($files);
    }

    //*
    //* sub GetMailText, Parameter list: $field
    //*
    //* Returns contents of Mail Texts file.
    //*
    //*

    function GetMailText($field)
    {
        $hash=$this->ReadPHPArray("../EventApp/System/".$this->ModuleName."/Mail.Data.php");

        return $hash[ $field ];
    }

    //*
    //* function PostProcessUnitData, Parameter list:
    //*
    //* Sets Unit data default to current unit.
    //*

    function PostProcessUnitData()
    {
        $unit=$this->ApplicationObj->Unit("ID");

        $this->AddDefaults[ "Unit" ]=$unit;
        $this->AddFixedValues[ "Unit" ]=$unit;
        $this->ItemData[ "Unit" ][ "Default" ]=$unit;
    }

    //*
    //* function PostProcessEventData, Parameter list:
    //*
    //* Sets Event data default to current event.
    //*

    function PostProcessEventData()
    {
        $event=$this->ApplicationObj->Event("ID");

        $this->AddDefaults[ "Event" ]=$event;
        $this->AddFixedValues[ "Event" ]=$event;
        $this->ItemData[ "Event" ][ "Default" ]=$event;
    }    
}

?>