<?php


class SubmissionsHandleAssessmentsUpdate extends SubmissionsHandleAssessmentsTable
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Update, Parameter list: $submission,$assessors,$criterias,$assessments
    //*
    //* Updates $assessors assessments table.
    //*

    function Submissions_Handle_Assessors_Assessments_Update($submission,&$assessors,$criterias,&$assessments)
    {
        foreach (array_keys($assessors) as $aid)
        {
            $friendid=$assessors[ $aid ][ "Friend" ];

            if (empty($assessments[ $friendid ]))
            {
                $assessments[ $friendid ]=array();
            }

            $this->AssessmentsObj()->Assessments_Criterias_Assessor_Update($criterias,$assessors[ $aid ],$assessments[ $friendid ]);
        }

        //return $assessments;
     }
}

?>