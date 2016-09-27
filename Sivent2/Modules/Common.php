<?php

include_once("../EventApp/EventMod.php");

class ModulesCommon extends EventMod
{
    var $Coordinator_Type=0;

    
    //*
    //* sub Coordinator_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Coordinator_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->ApplicationObj()->Coordinator_Access_Has($this->Coordinator_Type,$event);
    }

    //*
    //* sub Current_User_Event_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_May_Edit($event=array())
    {
        return $this->Coordinator_Access_Has($event);
    }

    //*
    //* sub Current_User_Event_May_Access, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_May_Access($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_May_Access($event);
    }

    //*
    //* function Inscriptions_Certificates_Published, Parameter list: 
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Inscriptions_Certificates_Published()
    {
        $event=$this->Event();

        return
            $this->EventsObj()->Event_Certificates_Has($event)
            &&
            $this->EventsObj()->Event_Certificates_Published($event);
    }
    
    //*
    //* function Inscriptions_Certificates_May, Parameter list: 
    //*
    //* Returns true or false, whether we may access certificates:
    //*
    //* Friend and Public: Inscriptions_Certificates_Published()
    //* Coordinator and Admin: Yes
    //*

    function Inscriptions_Certificates_May()
    {
        $event=$this->Event();

        $res=FALSE;
        if ($this->Profiles_Is(array("Admin","Coordinator")))
        {
            $res=TRUE;
        }
        elseif ($this->Profiles_Is(array("Public","Friend")))
        {
            $res=$this->Inscriptions_Certificates_Published();
        }
            
        return $res;
    }
    
    //*
    //* sub Unit, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Unit($key="")
    {
        return $this->ApplicationObj()->CGI_GET2Hash("Unit","UnitsObj",$key,"Unit",FALSE);
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
        return
            $this->EventsObj()->Event_Collaborations_Has($item)
            &&
            $this->EventsObj()->Event_Collaborations_May($item);
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
    //* function Event_Assessments_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has activity assessments.
    //*

    function Event_Assessments_Has($item=array())
    {
        $res=FALSE;
        if ($this->Event("Assessments")==2)
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
        $cell=
            $this->MyTime_Sort2Date($item[ $key1 ]);

        if (!empty($key2) && !empty($item[ $key2 ]))
        {
            $cell.=
                " - ".
                $this->MyTime_Sort2Date($item[ $key2 ]).
                "";
        }

        return $cell;
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

    
    //*
    //* function PreActions, Parameter list:
    //*
    //* Add actions common for all modules.
    //*

    function PreActions()
    {
        parent::PreActions();

        array_unshift($this->ActionPaths,"System/App");
    }

    //*
    //* function UnitWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => sql where clause.
    //*

    function UnitWhere($where=array(),$unit=array())
    {
        if (empty($unit))  $unit=$this->Unit();
        
        $where[ "Unit" ]=$unit[ "ID" ];

        return $where;
    }

    //*
    //* function UnitEventWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => and Event => sql where clause.
    //*

    function UnitEventWhere($where=array(),$event=array(),$unit=array())
    {
        if (empty($event)) $event=$this->Event();
        if (empty($unit))  $unit=$this->Unit();

        if (!is_array($event))
        {
            $event=array("ID" => $event);
        }
        
        $where[ "Unit" ]=$unit[ "ID" ];
        $where[ "Event" ]=$event[ "ID" ];

        return $where;
    }

    //*
    //* function ItemExistenceMessage, Parameter list: $message,$where=array()
    //*
    //* Prints informing $message, if no item exists in sql table.
    //* Default $where=$this->UnitEventWhere().
    //*

    function ItemExistenceMessage($othermodule="",$where=array())
    {
        if (!preg_match('/^(Coordinator|Admin)$/',$this->Profile())) return;
            
        if (empty($where)) $where=$this->UnitEventWhere();

        $obj=$this;
        if (empty($othermodule))
        {
            $othermodule=$this->ModuleName;
            $obj=$this;
        }

        $message="No_Items_Defined_Message";
        $message=$this->MyLanguage_GetMessage("No_Items_Defined_Message");

        $message=preg_replace('/#ItemName/',$obj->MyMod_ItemName(),$message);
        $message=preg_replace('/#ItemsName/',$obj->MyMod_ItemName("ItemsName"),$message);


        if (
              !$this->Sql_Table_Exists()
              ||
              $this->Sql_Select_NHashes($this->UnitEventWhere())==0
           )
        {
            echo
                $this->Div
                (
                   $message.
                   ": ".
                   $this->Href
                   (
                      "?".$this->CGI_Hash2URI
                      (
                         array
                         (
                            "Unit" => $this->Unit("ID"),
                            "Event" => $this->Event("ID"),
                            "ModuleName" => $othermodule,
                            "Action" => "Add",
                         )                         
                      ),
                      $this->MyLanguage_GetMessage("Add_Action_Name").
                      " ".
                      $obj->MyMod_ItemName(),
                      "","","",$noqueryargs=FALSE,$options=array(),"HorMenu"
                   ),
                   array("CLASS" => 'warning')
                ).
                $this->BR();

            return FALSE;
        }

        return TRUE;
    }


}

?>