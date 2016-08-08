<?php


class SubmissionsHandleAssessmentsCalc extends SubmissionsCertificate
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Calc_Sum, Parameter list: $$assessments,assessors,$criteria,$weighted=TRUE
    //*
    //* Generate $assessors $criteria row.
    //*

    function Submissions_Handle_Assessors_Assessments_Criteria_Calc_Sum($assessments,$assessors,$criteria,$weighted=TRUE)
    {
        return
            $this->AssessorsObj()->Assessors_Assessments_Criteria_Sum_Calc
            (
               $assessors,
               $criteria,
               $assessments,
               $weighted
            );
    }
    
    //*
    //* function Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum, Parameter list: $$assessments,assessor,$criterias,$weighted=TRUE
    //*
    //* Sums $assessor $criterias values.
    //*

    function Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum($assessments,$assessor,$criterias,$weighted=TRUE)
    {
        return
            $this->AssessorsObj()->Assessor_Assessments_Criterias_Sum_Calc
            (
               $assessor,
               $criterias,
               $assessments,
               $weighted
            );
    }
}

?>