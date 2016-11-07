<?php

include_once("../EventApp/EventMod.php");

class ModulesCommon extends EventMod
{
    var $Coordinator_Type=0;

    //*
    //* function Friend_Assessments_Has, Parameter list: $friend
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessments_Has($friend)
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($friend[ "ID" ]))
        {
            $nentries=$this->AssessorsObj()->Sql_Select_NEntries(array("Friend" => $friend[ "ID" ]));
        }

        if ($nentries>0) { $res=TRUE; }

        return $res;
    }
    
   //*
    //* function Friend_Collaborators_Has, Parameter list: $friend
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Collaborators_Has($friend)
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($friend[ "ID" ]))
        {
            $nentries=$this->CollaboratorsObj()->Sql_Select_NEntries(array("Friend" => $friend[ "ID" ]));
        }

        if ($nentries>0) { $res=TRUE; }

        return $res;
    }
    
   //*
    //* function Friend_Submissions_Has, Parameter list: $friend
    //*
    //* Detects if $friend has any Submissions.
    //*

    function Friend_Submissions_Has($friend)
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($friend[ "ID" ]))
        {
            $nentries=
                $this->SubmissionsObj()->Sql_Select_NEntries(array("Friend" => $friend[ "ID" ]))
                +
                $this->SubmissionsObj()->Sql_Select_NEntries(array("Friend2" => $friend[ "ID" ]))
                +
                $this->SubmissionsObj()->Sql_Select_NEntries(array("Friend3" => $friend[ "ID" ]));
        }

        if ($nentries>0) { $res=TRUE; }

        return $res;
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
    //* sub Current_User_Event_May_Access, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_May_Access($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_May_Access($event);
    }

    /* //\* */
    /* //\* function Inscriptions_Certificates_Published, Parameter list:  */
    /* //\* */
    /* //\* Returns true or false, whether event should provide certificates. */
    /* //\* */

    /* function Inscriptions_Certificates_Published() */
    /* { */
    /*     $event=$this->Event(); */

    /*     return */
    /*         $this->EventsObj()->Event_Certificates_Has($event) */
    /*         && */
    /*         $this->EventsObj()->Event_Certificates_Published($event); */
    /* } */
    
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
}

?>