<?php

class PreInscriptionsInscriptionCells extends PreInscriptionsInscriptionRead
{
    //*
    //* function PreInscriptions_Inscription_Submission_Cell_Name, Parameter list: $submission
    //*
    //* Returns cgi name of preinscription cell. 
    //*

    function PreInscriptions_Inscription_Submission_PreInscribe_Cell_Name($submission)
    {
        return "Submission_".$submission[ "ID" ];
    }
    
    //*
    //* function PreInscriptions_Inscription_Submission_Cell_Value, Parameter list: $submission
    //*
    //* Returns cgi name of preinscription cell. 
    //*

    function PreInscriptions_Inscription_Submission_PreInscribe_Cell_Value($submission)
    {
        return
            $this->CGI_POSTint
            (
               $this->PreInscriptions_Inscription_Submission_PreInscribe_Cell_Name($submission)
            );
    }
    
    //*
    //* function PreInscriptions_Inscription_Submission_Cell, Parameter list: $edit,$inscription,$submission=array
    //*
    //* Creates first row with submission data - and cell for preinscription.
    //*

    function PreInscriptions_Inscription_Submission_PreInscribe_Cell($edit,$inscription,$submission=array())
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("PreInscriptions_Select_Title"); }

        $where=$this->UnitEventWhere(array("Friend" => $inscription[ "Friend" ]));

        $checked=FALSE;
        $disabled=FALSE;
        if ($edit!=1) { $disabled=TRUE; }

        $message=$this->MyLanguage_GetMessage("PreInscriptions_Inscribe");
        
        if (!empty($this->PreInscriptions[ $submission[ "ID" ] ]))
        {
            $checked=TRUE;
            $message=$this->MyLanguage_GetMessage("PreInscriptions_Inscribed");
        }
        
        $conflicts=$this->PreInscriptions_Inscription_Submission_Conflicts($submission);
        foreach ($conflicts as $conflict)
        {
            if (!$disabled && !empty($this->PreInscriptions[ $conflict[ "ID" ] ]))
            {
                $disabled=TRUE;
                $message=
                    $this->MyLanguage_GetMessage("PreInscriptions_Conflict_Message").
                    $conflict[ "Name" ] ;
            }
        }

        $nvacancies=$this->SubmissionsObj()->SubmissionVacancies($submission);
        if (!$checked && $nvacancies<=0)
        {
            $disabled=TRUE;
            $message=$this->MyLanguage_GetMessage("PreInscriptions_No_Vacancies");
        }

        $cell=
            $this->Html_Input_CheckBox_Field
            (
               $this->PreInscriptions_Inscription_Submission_PreInscribe_Cell_Name($submission),
               1,
               $checked,
               $disabled,
               array("TITLE" => $message)
            );
        
        return $cell;
    }
}

?>