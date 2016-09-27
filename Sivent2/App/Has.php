<?php

class App_Has extends App_Head_Table
{
    //*
    //* function HasCollaborations, Parameter list:
    //*
    //* Checks whether current event has collaborations.
    //* 
    //*

    function HasCollaborations()
    {
        return $this->EventsObj()->Event_Collaborations_Has();
    }
    
    //*
    //* function HasCaravans, Parameter list:
    //*
    //* Checks whether current event has Caravans.
    //* 
    //*

    function HasCaravans()
    {
        return $this->EventsObj()->Event_Caravans_Has();
    }
    
    //*
    //* function HasSubmissions, Parameter list:
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function HasSubmissions()
    {
        return $this->EventsObj()->Event_Submissions_Has();
    }
    
    //*
    //* function HasCriterias, Parameter list:
    //*
    //* Checks whether current event has Submissions.
    //* 
    //*

    function HasCriterias()
    {
        return $this->HasSubmissions();
    }
    
    //*
    //* function SubmissionsPublic, Parameter list:
    //*
    //* Checks whether current event has public Submissions.
    //* 
    //*

    function SubmissionsPublic()
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
        
        return $this->EventsObj()->Event_Submissions_Public();
    }
    
    //*
    //* function HasCertificates, Parameter list:
    //*
    //* Checks whether current event has Certificates.
    //* 
    //*

    function HasCertificates()
    {
        return $this->EventsObj()->Event_Certificates_Has();
    }
    
    //*
    //* function SchedulePublic, Parameter list:
    //*
    //* Checks whether current event has a published Schedule.
    //* 
    //*

    function SchedulePublic()
    {
        return $this->EventsObj()->Event_Schedule_Public();
    }
    
}
