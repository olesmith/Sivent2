<?php


class Submissions_Handle_Assessments_Cells extends Submissions_Handle_Assessments_Calc
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Cells_Sum, Parameter list: $$assessments,assessors,$criteria
    //*
    //* Generate $assessors $criteria row.
    //*

    function Submissions_Handle_Assessors_Assessments_Criteria_Cells($submission,$assessments,$assessors,$criteria)
    {
        $sum=$this->AssessorsObj()->Assessors_Submission_Criteria_Media_Calc($assessors,$submission,$criteria,FALSE);
        $wsum=1.0*$sum*$criteria[ "Weight" ];

        if (count($assessors)>0)
        {
            $wmedia=1.0*$wsum/(1.0*count($assessors));
            $wsum=sprintf("%.1f",$wsum);
            $sum=sprintf("%.1f",$sum);
            $wmedia=sprintf("%.1f",$wmedia);
        }
        else { $sum=$wsum=$wmedia="-"; }
        
        return
            $this->B
            (
                array
                (
                    $this->Div($sum,array("ALIGN" => 'right')),
                    $this->Div($wsum,array("ALIGN" => 'right')),
                )
            );
    }
}

?>