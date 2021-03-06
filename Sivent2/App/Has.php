<?php

class App_Has extends App_Head_Table
{
    //*
    //* function Friend_Caravans_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Caravans.
    //*

    function Friend_Caravans_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Caravans_Has($friend);
    }
    
    //*
    //* function Friend_Caravans_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Caravans.
    //*

    function Friend_Caravans_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Caravans_Should($friend);
    }
    
    //*
    //* function Friend_Certificates_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Certificates.
    //*

    function Friend_Certificates_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Certificates_Has($friend);
    }
    
    //*
    //* function Friend_Certificates_Should, Parameter list: $friend
    //*
    //* Detects if current event has any Certificates.
    //*

    function Friend_Certificates_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Certificates_Should($friend);
    }
    
    //*
    //* function Friend_Submissions_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Submissions_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Submissions_Has($friend);
    }
    
    //*
    //* function Friend_Submissions_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Submissions_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Submissions_Should($friend);
    }
    
    //*
    //* function Friend_Collaborators_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any .
    //*

    function Friend_Collaborators_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Collaborators_Has($friend);
    }
    
    
    //*
    //* function Friend_Collaborators_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any .
    //*

    function Friend_Collaborators_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Collaborators_Should($friend);
    }
    
    
    //*
    //* function Friend_Assessors_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessors_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Assessors_Has($friend);
    }
    
    //*
    //* function Friend_Assessors_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Assessments.
    //*

    function Friend_Assessors_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Assessors_Should($friend);
    }

    //*
    //* function Friend_Speakers_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Speakers.
    //*

    function Friend_Speakers_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Speakers_Has($friend);
    }
    
    //*
    //* function Friend_Speakers_Should, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Speakers.
    //*

    function Friend_Speakers_Should($friend=array())
    {
        return $this->FriendsObj()->Friend_Speakers_Should($friend);
    }
    
    //*
    //* function Friend_Schedules_Has, Parameter list: $friend=array()
    //*
    //* Detects if current event has any Schedules.
    //*

    function Friend_Schedules_Has($friend=array())
    {
        return $this->FriendsObj()->Friend_Schedules_Has($friend);
    }
    

    
    //*
    //* function Event_Payments_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Payments.
    //* 
    //*

    function Event_Payments_Has($event=array())
    {
        return $this->EventsObj()->Event_Payments_Has($event);
    }
    
    //*
    //* function Event_Collaborations_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has collaborations.
    //* 
    //*

    function Event_Collaborations_Has($event=array())
    {
        return $this->EventsObj()->Event_Collaborations_Has($event);
    }
    
    //*
    //* function Event_Caravans_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Caravans.
    //* 
    //*

    function Event_Caravans_Has($event=array())
    {
        return $this->EventsObj()->Event_Caravans_Has($event);
    }
    
    //*
    //* function Event_Submissions_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function Event_Submissions_Has($event=array())
    {
        return $this->EventsObj()->Event_Submissions_Has($event);
    }
    
    //*
    //* function Event_Assessments_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Assessments.
    //* 
    //*

    function Event_Assessments_Has($event=array())
    {
        return $this->EventsObj()->Event_Assessments_Has($event);
    }
    
    //*
    //* function Event_Criterias_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function Event_Criterias_Has($event=array())
    {
        return $this->Event_Criterias_Has($event);
    }
    
    //*
    //* function Event_Submissions_Public, Parameter list:$event=array()
    //*
    //* Checks whether current event has public Submissions.
    //* 
    //*

    function Event_Submissions_Public($event=array())
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
    //* function Event_Certificates_Has, Parameter list:$event=array()
    //*
    //* Checks whether current event has Certificates.
    //* 
    //*

    function Event_Certificates_Has($event=array())
    {
        return $this->EventsObj()->Event_Certificates_Has($event);
    }
    
    //*
    //* function Event_Schedule_Public, Parameter list:$event=array()
    //*
    //* Checks whether current event has a published Schedule.
    //* 
    //*

    function Event_Schedule_Public($event=array())
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
    //* sub Coordinator_Sponsors_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to Sponsors.
    //*
    //*

    function Coordinator_Sponsors_Access_Has($event=array())
    {
        return $this->Coordinator_Access_Has($this->SponsorsObj()->Coordinator_Type,$event);
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
            $this->Event_Collaborations_Has($event)
            &&
            $this->Coordinator_Access_Has($this->CollaborationsObj()->Coordinator_Type,$event);
    }

    //*
    //* sub Coordinator_Payments_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to payments.
    //*
    //*

    function Coordinator_Payments_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return
            $this->Event_Payments_Has($event)
            &&
            $this->Coordinator_Access_Has(8,$event);
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
            $this->Event_Submissions_Has($event)
            &&
            $this->Coordinator_Access_Has($this->SubmissionsObj()->Coordinator_Type,$event);
    }
    //*
    //* sub Coordinator_Assessments_Access_Has, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to .
    //*
    //*

    function Coordinator_Assessments_Access_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return 
            $this->Event_Assessments_Has($event)
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
            $this->Event_Caravans_Has($event)
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
