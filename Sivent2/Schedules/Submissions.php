<?php

class SchedulesSubmissions extends SchedulesPlaces
{
    //*
    //* function SubmissionsData, Parameter list: 
    //*
    //* Returns subnmissions data to expose.
    //*

    function SubmissionsData()
    {
        return $this->SubmissionsObj()->Authors_Datas("Author",array("ID","Name","Title"));
    }

    //*
    //* function ReadSubmissions, Parameter list: $where
    //*
    //* Reads event submissions, if necessary.
    //*

    function ReadSubmissions()
    {
        $where=
           array
           (
              "Unit" => $this->Unit("ID"),
              "Event" => $this->Event("ID"),
           );

        $submissions=$this->SubmissionsObj()->Sql_Select_Hashes_ByID($where,$this->SubmissionsData(),"ID","Name,Title");
        
        $this->Submissions=array();
        foreach (array_keys($submissions) as $sid)
        {
            $this->SubmissionsObj()->ReadSubmission($submissions[ $sid ]);
            
             $submissions[ $sid ][ "Authors" ]=join(", ",$submissions[ $sid ][ "Authors" ]);
            
            $this->Submissions[ $sid ]=$submissions[ $sid ];
        }
    }
    
    //*
    //* function ReadSubmission, Parameter list: $submission
    //*
    //* Reads event submission, if necessary.
    //*

    function ReadSubmission($submissionid)
    {
        return $this->ReadSubmissions(array("ID" => $submissionid));
    }

    //*
    //* function Submissions, Parameter list: 
    //*
    //* Reads event submissions, if necessary.
    //*

    function Submissions($sid=0,$key="")
    {
        $this->ReadSubmissions();
        
        if (!empty($sid))
        {
            if (!empty($key))
            {
                return $this->Submissions[ $sid ][ $key ];
            }
            
            return $this->Submissions[ $sid ];
        }
        
        return $this->Submissions;
    }

    
    //*
    //* function Submission_PreInscriptions_Has, Parameter list: $schedule
    //*
    //* Returns TRUE if $schedule Submission key is set, and this
    //* submission has preinscriptions on.
    //*

    function Submission_PreInscriptions_Has($schedule)
    {
        $res=FALSE;
        if (!empty($schedule[ "Submission" ]))
        {
            $pre=$this->SubmissionsObj()->Sql_Select_Hash_Value(array("ID" => $schedule[ "Submission" ]),"PreInscriptions");
            if ($pre==2) { $res=TRUE; }
        }
        

        return $res;
    }

}

?>