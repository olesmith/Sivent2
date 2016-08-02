<?php


class PreInscriptionsInscriptionConflicts extends PreInscriptionsInscriptionForm
{
    //*
    //* function PreInscriptions_Inscription_Submission_Conflicts, Parameter list: $submission
    //*
    //* Returns submissions in $submissions, conflicting with $submission.
    //*

    function PreInscriptions_Inscription_Submission_Conflicts($submission)
    {
        $conflicts=array();

        foreach ($this->Submissions as $sid => $rsubmission)
        {
            if ($submission[ "ID" ]==$rsubmission[ "ID" ]) { continue; }

            foreach ($submission[ "Times" ] as $timeid)
            {
                foreach ($rsubmission[ "Times" ] as $rtimeid)
                {
                    if ($timeid==$rtimeid)
                    {
                        $conflicts[ $rsubmission[ "ID" ] ]=$rsubmission;
                        continue;
                    }
                }
            }
        }

        return $conflicts;
    }

    //*
    //* function PreInscriptions_Inscription_Submission_Conflicts_List, Parameter list: $submission
    //*
    //* Generates listing of conflicting submissions.
    //*

    function PreInscriptions_Inscription_Submission_Conflicts_List($submission)
    {
        $conflicts=array();
        foreach ($this->PreInscriptions_Inscription_Submission_Conflicts($submission) as $sid => $rsubmission)
        {
            array_push($conflicts,$rsubmission[ "Name" ]);
        }
        
        return
            
            $this->B($this->MyLanguage_GetMessage("PreInscriptions_Conflict_Title").": ").
            join(", ",$conflicts).
            "";
    }            
}

?>