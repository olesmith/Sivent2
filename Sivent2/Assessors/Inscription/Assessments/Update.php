<?php



class AssessorsInscriptionAssessmentsUpdate extends AssessorsInscriptionAssessmentsTable
{
    //*
    //* function Assessor_Inscription_Assessments_Update, Parameter list: $edit,&$assessor,&$assessments
    //*
    //* Updates $assessor assessments form.
    //*

    function Assessor_Inscription_Assessments_Update($edit,&$assessor,&$assessments)
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
               $assessor,
               $assessments
            );
    }
}

?>