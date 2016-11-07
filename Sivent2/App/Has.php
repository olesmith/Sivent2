<?php

class App_Has extends App_Head_Table
{
    //*
    //* function Friend_Assessments_Has, Parameter list: $friend
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessments_Has($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        return $this->FriendsObj()->Friend_Assessments_Has($friend);
    }
    
    //*
    //* function HasCollaborations, Parameter list:$event=array()
    //*
    //* Checks whether current event has collaborations.
    //* 
    //*

    function HasCollaborations($event=array())
    {
        return $this->EventsObj()->Event_Collaborations_Has($event);
    }
    
    //*
    //* function HasCaravans, Parameter list:$event=array()
    //*
    //* Checks whether current event has Caravans.
    //* 
    //*

    function HasCaravans($event=array())
    {
        return $this->EventsObj()->Event_Caravans_Has($event);
    }
    
    //*
    //* function HasSubmissions, Parameter list:$event=array()
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function HasSubmissions($event=array())
    {
        return $this->EventsObj()->Event_Submissions_Has($event);
    }
    
    //*
    //* function HasCriterias, Parameter list:$event=array()
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function HasCriterias($event=array())
    {
        return $this->HasSubmissions($event);
    }
    
    //*
    //* function SubmissionsPublic, Parameter list:$event=array()
    //*
    //* Checks whether current event has public Submissions.
    //* 
    //*

    function SubmissionsPublic($event=array())
    {
        if (preg_match('/^(Admin|Coordinator)$/',$this->Profile())) { return TRUE; }
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $where=
               array
               (
                  "Unit"  => $this->Unit("ID"),
                  "Event" => $this->Event("ID"),
                  "Friend" => $this->LoginData("ID"),
               );
            
            if ($this->SubmissionsObj()->Sql_Select_NHashes($where)>0)
            {
                return TRUE;
            }
        }

        return $this->EventsObj()->Event_Submissions_Public($event);
    }
    
    //*
    //* function HasCertificates, Parameter list:$event=array()
    //*
    //* Checks whether current event has Certificates.
    //* 
    //*

    function HasCertificates($event=array())
    {
        return $this->EventsObj()->Event_Certificates_Has($event);
    }
    
    //*
    //* function SchedulePublic, Parameter list:$event=array()
    //*
    //* Checks whether current event has a published Schedule.
    //* 
    //*

    function SchedulePublic($event=array())
    {
        return $this->EventsObj()->Event_Schedule_Public($event);
    }

    //*
    //* sub Coordinator_Inscriptions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Inscriptions.
    //*
    //*

    function Coordinator_Inscriptions_Access_Has($event=array())
    {
        return $this->Coordinator_Access_Has($this->InscriptionsObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Coordinator_Collaborations_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to .
    //*
    //*

    function Coordinator_Collaborations_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return
            $this->HasCollaborations($event)
            &&
            $this->Coordinator_Access_Has($this->CollaborationsObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Coordinator_Submissions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to .
    //*
    //*

    function Coordinator_Submissions_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return 
            $this->HasSubmissions($event)
            &&
            $this->Coordinator_Access_Has($this->SubmissionsObj()->Coordinator_Type,$event);
    }
    //*
    //* sub Coordinator_Caravans_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Caravans.
    //*
    //*

    function Coordinator_Caravans_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return 
            $this->HasCaravans($event)
            &&
            $this->Coordinator_Access_Has($this->CaravansObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Coordinator_Preinscriptions_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Preinscriptions.
    //*
    //*

    function Coordinator_Preinscriptions_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return
            $this->Coordinator_Access_Has($this->PreinscriptionsObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Coordinator_Presences_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Presences.
    //*
    //*

    function Coordinator_Presences_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Coordinator_Access_Has($this->PresencesObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Current_User_Event_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to module.
    //*
    //*

    function Current_User_Event_May_Edit($event=array())
    {
        return $this->Coordinator_Access_Has($this->EventsObj()->Coordinator_Type,$event);
    }
    
}
