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
    
    //*
    //* function Event_Collaborations_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Collaborations_Has($item=array())
    {
        $res=FALSE;
        if ($this->Event("Collaborations")==2)
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function Event_Submissions_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Submissions_Has($item=array())
    {
        $res=FALSE;
        if ($this->Event("Submissions")==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function Event_Caravans_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Caravans_Has($item=array())
    {
        $res=FALSE;
        $value=$this->Event("Caravans");
        if (!empty($value) && $value==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function , Parameter list: $date1,$date2
    //*
    //* Returns: formatted date span string.
    //*

    function Date_Span_Interval($item,$key1,$key2)
    {
        return
            $this->MyTime_Sort2Date($item[ $key1 ]).
            " - ".
            $this->MyTime_Sort2Date($item[ $key2 ]).
            "";
    }

    //*
    //* function , Parameter list: $date1,$date2,$date=0
    //*
    //* Returns:
    //* 0 if $date is smaller than both dates.
    //* 1 if $date inbetween dates
    //* 2 if $date greater that both dates.
    //*

    function Date_Span_Position($item,$key1,$key2,$date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }
        
        $res=1;
        $date1=$item[ $key1 ];
        $date2=$item[ $key2 ];
        
        if     ($date<$date1 && $date<$date2) { $res=0; }
        elseif ($date>$date1 && $date>$date2) { $res=2; }

        return $res;
    }

    //*
    //* function Date_Span_Status, Parameter list: $date1,$date2,$date=0
    //*
    //* Returns formatted messgae according to date dates span status.
    //*

    function Date_Span_Status($item,$key1,$key2,$date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }
        
        
        $res=$this->Date_Span_Position($item,$key1,$key2,$date);

        $key="Events_ToOpen_Title";
        if ($res==1)
        {
            $key="Events_Open_Title";
        }
        elseif ($res==2)
        {
            $key="Events_Closed_Title";
        }

        return $this->MyLanguage_GetMessage($key);
    }

}

?>