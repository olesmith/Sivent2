<?php


class Submissions_Handle_Assessments_Update extends Submissions_Handle_Assessments_Table
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Update, Parameter list: $submission,$assessors,$assessments
    //*
    //* Updates $assessors assessments table.
    //*

    function Submissions_Handle_Assessors_Assessments_Update($submission,&$assessors,&$assessments)
    {
        foreach (array_keys($assessors) as $aid)
        {
            $friendid=$assessors[ $aid ][ "Friend" ];

            if (empty($assessments[ $friendid ]))
            {
                $assessments[ $friendid ]=array();
            }

            $this->AssessmentsObj()->Assessments_Criterias_Assessor_Update($assessors[ $aid ],$assessments[ $friendid ]);
        }

        //return $assessments;
     }
}

?>