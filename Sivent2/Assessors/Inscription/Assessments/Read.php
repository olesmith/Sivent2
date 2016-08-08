<?php



class AssessorsInscriptionAssessmentsRead extends AssessorsInscriptionAssessors
{
    //*
    //* function Assessors_Inscription_Assessments_Read, Parameter list: $assessor
    //*
    //* Reads relevant assessments.
    //*

    function Assessors_Inscription_Assessments_Read($assessor)
    {
        return
            $this->MyHash_HashesList_2ID
            (
               $this->AssessmentsObj()->Sql_Select_Hashes
               (
                  $this->UnitEventWhere(array("Submission" => $assessor[ "Submission" ]))
               ),
               "Criteria"
            );
    }
}

?>