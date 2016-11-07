<?php


class Submissions_Handle_Assessments_Cells extends Submissions_Handle_Assessments_Calc
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Cells_Sum, Parameter list: $$assessments,assessors,$criteria
    //*
    //* Generate $assessors $criteria row.
    //*

    function Submissions_Handle_Assessors_Assessments_Criteria_Cells_Sum($assessments,$assessors,$criteria)
    {
        $sum=$this->Submissions_Handle_Assessors_Assessments_Criteria_Calc_Sum($assessments,$assessors,$criteria);
        $wsum=1.0*$sum*$criteria[ "Weight" ];

        if (count($assessors)>0)
        {
            $wmedia=1.0*$wsum/(1.0*count($assessors));
        }
        else { $sum=$wsum=$wmedia="-"; }
        
        return
            array
            (
               sprintf("%.1f",$sum),
               sprintf("%.1f",$wsum),
               sprintf("%.1f",$wmedia),
            );
    }
}

?>