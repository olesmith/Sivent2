<?php

include_once("../EventApp/EventMod.php");

class ModulesCommon extends EventMod
{
    var $Coordinator_Type=0;

    //*
    //* function Friend_Items_Has, Parameter list: $module,$friend
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Items_Has($module,$friend,$friendfield="Friend")
    {
        if (empty($friend)) { $friend=$this->LoginData(); }

        $module.="Obj";
        return
            $this->$module()->Sql_Select_Hashes_Has
            (
                $this->UnitEventWhere(array($friendfield => $friend[ "ID" ]))
            );
    }
    
    //*
    //* function Friend_Certificates_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Certificates.
    //*

    function Friend_Certificates_Has($friend=array())
    {
        return $this->Friend_Items_Has("Certificates",$friend);
    }
    
    //*
    //* function Friend_Certificates_Should, Parameter list: $friend=array()
    //*
    //* Detects if we should show certificates for current event.
    //*

    function Friend_Certificates_Should($friend=array())
    {
        return
            $this->Friend_Items_Has("Certificates",$friend)
            &&
            $this->EventsObj()->Event_Certificates_Published();
    }
    
    //*
    //* function Friend_Assessors_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessors_Has($friend=array())
    {
        return $this->Friend_Items_Has("Assessors",$friend);
    }
    
    //*
    //* function Friend_Assessors_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessors_Should($friend=array())
    {
        return
            $this->EventsObj()->Event_Assessments_Inscriptions_Open()
            ||
            $this->Friend_Assessors_Has($friend);
    }
    
    //*
    //* function Friend_Caravans_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Caravans.
    //*

    function Friend_Caravans_Has($friend=array())
    {
        return $this->Friend_Items_Has("Caravans",$friend);
    }
    
    //*
    //* function Friend_Caravans_Should, Parameter list: $friend=array()
    //*
    //* Checks whether we should show Caravans for $friend.
    //*

    function Friend_Caravans_Should($friend=array())
    {
        $res=
            $this->EventsObj()->Event_Caravans_Inscriptions_Open()
            ||
            $this->Friend_Caravans_Has($friend);
        
        
        return $res;
    }

    //*
    //* function Friend_Collaborators_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Collaborators_Has($friend=array())
    {
        return $this->Friend_Items_Has("Collaborators",$friend);
    }
    
    //*
    //* function Friend_Collaborators_Should, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has Collaborations.
    //*

    function Friend_Collaborators_Should($friend=array())
    {
        $res=
            $this->EventsObj()->Event_Collaborations_Inscriptions_Open()
            ||
            $this->Friend_Collaborators_Has($friend);
        
        
        return $res;
    }
    
    //*
    //* function Friend_Speakers_Has, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has spekker entries.
    //*

    function Friend_Speakers_Has($friend=array())
    {
        return $this->Friend_Items_Has("Speakers",$friend);
    }
   //*
    //* function Friend_Speakers_Should, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has Speakers.
    //*

    function Friend_Speakers_Should($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }

        $res=
            $this->Friend_Speakers_Has($friend);
        
        
        return $res;
    }
        
    //*
    //* function Friend_Schedules_Has, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has Schedules entries.
    //*

    function Friend_Schedules_Has($friend=array())
    {
        return $this->Friend_Items_Has("Schedules",$friend);
    }
    
    //*
    //* function Friend_Schedules_Should, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has .
    //*

    function Friend_Schedules_Should($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }

        $res=
            $this->Friend_Schedules_Has($friend);
        
        
        return $res;
    }
        
     //*
    //* function Friend_Submissions_Has, Parameter list: $friend=array()
    //*
    //* Detects if $friend has any Submissions.
    //*

    function Friend_Submissions_Has($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }

        $res=FALSE;
        if (!empty($friend[ "ID" ]))
        {
            foreach (array("Friend","Friend2","Friend3") as $fkey)
            {
                if ($this->Friend_Items_Has("Submissions",$friend,$fkey))
                {
                    $res=TRUE;
                    break;
                }
             }
        }

        return $res;
    }
    
    //*
    //* function Friend_Submissions_Should, Parameter list: $friend=array()
    //*
    //* Detects if we should show Submissions for current event.
    //*

    function Friend_Submissions_Should($friend=array())
    {
        return
            $this->Friend_Items_Has("Submissions",$friend)
            ||
            $this->EventsObj()->Event_Submissions_Open();
    }
    
    
    
    //*
    //* sub Coordinator_Access_Has, Parameter list: $event=array(),$type=""
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Coordinator_Access_Has($type="",$event=array())
    {
        if (empty($type)) { $type=$this->Coordinator_Type; }

        return $this->ApplicationObj()->Coordinator_Access_Has($type,$event);
    }

    //*
    //* sub Coordinator_Inscriptions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Inscriptions.
    //*
    //*

    function Coordinator_Inscriptions_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Inscriptions_Access_Has($event);
    }

    //*
    //* sub Coordinator_Collaborations_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Collaborations.
    //*
    //*

    function Coordinator_Collaborations_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Collaborations_Access_Has($event);
    }

    //*
    //* sub Coordinator_Submissions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Submissions.
    //*
    //*

    function Coordinator_Submissions_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Submissions_Access_Has($event);
    }
    //*
    //* sub Coordinator_Caravans_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Caravans.
    //*
    //*

    function Coordinator_Caravans_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Caravans_Access_Has($event);
    }

    //*
    //* sub Coordinator_Preinscriptions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Preinscriptions.
    //*
    //*

    function Coordinator_Preinscriptions_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Preinscriptions_Access_Has($event);
    }


    //*
    //* sub Coordinator_Presences_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Presences.
    //*
    //*

    function Coordinator_Presences_Access_Has($event=array())
    {
        return $this->ApplicationObj()->Coordinator_Presences_Access_Has($event);
    }


    //*
    //* sub Current_User_Event_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_May_Edit($event);
    }

    //*
    //* sub Current_User_Event_Type_May_Edit, Parameter list: $type,$event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_Type_May_Edit($type,$event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Type_May_Edit($type,$event);
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
            $res=$this->EventsObj()->Event_Certificates_Published();
        }

            
        return $res;
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
            $this->EventsObj()->Event_Collaborations_Has()
            &&
            $this->EventsObj()->Event_Collaborations_May();
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
    //* function Item_Existence_Message, Parameter list: $message,$where=array()
    //*
    //* Prints informing $message, if no item exists in sql table.
    //* Default $where=$this->UnitEventWhere().
    //*

    function Item_Existence_Message($othermodule="",$where=array())
    {
        if (empty($where)) $where=$this->UnitEventWhere();

        return parent::Item_Existence_Message($othermodule,$where);
    }

    //*
    //* function AddUnitDefault, Parameter list: 
    //*
    //* Adds unit default.
    //*

    function AddUnitDefault()
    {
        $unitid=$this->GetCGIVarValue("Unit");
        $eventid=$this->GetCGIVarValue("Event");
        $this->AddDefaults[ "Unit" ]=$unitid;
        $this->AddFixedValues[ "Unit" ]=$unitid;
    }
   //*
    //* function AddUnitEventDefault, Parameter list: 
    //*
    //* Adds unit default.
    //*

    function AddUnitEventDefault()
    {
        $this->AddUnitDefault();
        
        $eventid=$this->GetCGIVarValue("Event");
        $this->AddDefaults[ "Event" ]=$eventid;
        $this->AddFixedValues[ "Event" ]=$eventid;
    }

    
    //*
    //* function Submission_Confirm_Should, Parameter list: $submission
    //*
    //* Determine Confirmed fields access permissions.
    //*

    function Submission_Confirm_Should($data,$submission)
    {
        $res=0;
        if (!empty($submission[ "Status" ]) && $submission[ "Status" ]==2)
        {
            $res=2;
        }

        return $res;
    }
    
    //*
    //* function Criterias, Parameter list: $id=0,$key=""
    //*
    //* All modules Criterias accessor!
    //*

    function Criterias($id=0,$key="")
    {
        return $this->ApplicationObj()->Criterias($id,$key);
    }

    //*
    //* function Criteria_IDs, Parameter list: 
    //*
    //* Reyturns Criteria IDs
    //*

    function Criteria_IDs()
    {
        return array_keys($this->Criterias());
    }

    //*
    //* function Criterias_N, Parameter list: 
    //*
    //* Returns no of Criterias
    //*

    function Criterias_N()
    {
        return count($this->Criteria_IDs());
    }

    //*
    //* function Criterias_Weight, Parameter list: 
    //*
    //*  Returns Criterias summed weights.
    //*

    function Criterias_Weight($id=0)
    {
        $weight="";
        if (!empty($id))
        {
            $weight=$this->Criterias($id,"Weight");
        }
        else
        {
            $weight=0.0;
            foreach ($this->Criterias() as $cid => $criteria)
            {
                $weight+=$criteria[ "Weight" ];
            }
        }
        
        return $weight;
    }
 }

?>