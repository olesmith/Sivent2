<?php



class AssessorsInscriptionAssessmentsUpdate extends AssessorsInscriptionAssessmentsTable
{
    //*
    //* function Assessors_Inscription_Assessments_Update, Parameter list: $edit,&$assessor,$criterias,&$assessments
    //*
    //* Updates $assessor assessments form.
    //*

    function Assessors_Inscription_Assessments_Update($edit,&$assessor,$criterias,&$assessments)
    {
        if
            (
               $edit!=1
               ||
               $this->CGI_POSTint("Save")!=1
            ) return FALSE;

        return
            $this->AssessmentsObj()->Assessments_Criterias_Assessor_Update
            (
               $criterias,
               $assessor,
               $assessments
            );
    }
}

?>