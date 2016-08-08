<?php


class AssessorsInscriptionAssessorsForm extends AssessorsInscriptionAssessorsTable
{
    //*
    //* function Assessors_Inscription_Assessor_Form, Parameter list: $edit,$inscription,&$assessor
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessors_Inscription_Assessor_Form($edit,$inscription,&$assessor)
    {
        $frienddatas=array("Name","Email","NickName","Titulation","Curriculum",);
        $submissiondatas=array("Name","Title","Area","Level","Keywords","Summary","File");

        $table=
            array_merge
            (
               array($this->H(3,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Friend_Title"))),
               $this->FriendsObj()->MyMod_Item_Table(0,$assessor[ "Friend_Hash" ],$frienddatas),
               array($this->H(3,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Submission_Title"))),
               $this->SubmissionsObj()->MyMod_Item_Table(0,$assessor[ "Submission_Hash" ],$submissiondatas)
            );
 
        
        return $this->FrameIt
        (
            $this->H(2,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Title")).
            $this->Html_Table("",$table).
            $this->Assessors_Inscription_Assessments_Form($edit,$inscription,$assessor).
            ""
        );
    }
    
    //*
    //* function Assessors_Inscription_Assessors_Table, Parameter list: $edit,$inscription,&$assessors
    //*
    //* Loops over $assessors, if ID equals POST Assessor, shows this Assessors form.
    //*

    function Assessors_Inscription_Assessors_Form($edit,$inscription,&$assessors)
    {
        $assessorid=$this->CGI_GETint("Assessor");

        $html="";
        foreach (array_keys($assessors) as $aid)
        {
            if ($assessors[ $aid ][ "ID" ]==$assessorid)
            {
                $html=$this->Assessors_Inscription_Assessor_Form($edit,$inscription,$assessors[ $aid ]);
                break;
            }
        }

        return $html;
    }
    
    
}

?>