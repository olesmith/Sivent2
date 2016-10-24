<?php

class PreInscriptionsHandle extends PreInscriptionsInscription
{
    //*
    //* function HandlePreInscriptionsPrintMenu, Parameter list: 
    //*
    //* Handles Schedule Preinscription registration.
    //*

    function HandlePreInscriptionsPrintMenu()
    {
    }
    
    //*
    //* function HandlePreInscriptions, Parameter list: 
    //*
    //* Handles Schedule Preinscription registration.
    //*

    function HandlePreInscriptions()
    {
        $submissionid=$this->CGI_GETint("Submission");
        if (empty($submissionid)) { return "Not allowed"; }

        $submission=$this->SubmissionsObj()->Sql_Select_Hash(array("ID" => $submissionid));
        if (empty($submission[ "ID" ])) { return "Submission not found"; }

       echo
            $this->H(1,$this->MyActions_Entry_Title("Manage")).
            $this->FrameIt($this->SubmissionsObj()->MyMod_Item_Table_Html
            (
               0,
               $submission,
               array("Title","SubmissionAuthorsCell","Type","Area","Status","PreInscriptions","Vacancies")
             )).
            $this->PreInscriptions_Show
            (
               $this->PreInscriptions_Submission_Read($submission)
            ).
            "";
    }
    
    
     
}

?>