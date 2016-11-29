<?php



class AssessorsInscriptionAssessmentsRead extends AssessorsInscriptionAssessors
{
    //*
    //* function Assessor_Inscription_Assessments_Read, Parameter list: $assessor
    //*
    //* Reads $assessor assessments.
    //*

    function Assessor_Inscription_Assessments_Read($assessor)
    {
        return
            $this->MyHash_HashesList_2ID
            (
               $this->AssessmentsObj()->Sql_Select_Hashes
               (
                  $this->UnitEventWhere
                  (
                      array
                      (
                          "Friend" => $assessor[ "Friend" ],
                          "Submission" => $assessor[ "Submission" ],
                      )
                  )
               ),
               "Criteria"
            );
    }
}

?>