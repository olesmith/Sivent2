<?php


class Submissions_Handle_Assessments_Table extends Submissions_Handle_Assessments_Read
{
    //*
    //* function Submission_Handle_Assessors_Assessments_Table, Parameter list: $edit,$submission,$assessors
    //*
    //* Generate $assessors assessments table.
    //*

    function Submission_Handle_Assessors_Assessments_Table($edit,$submission,&$assessors)
    {
        $assessments=$this->Submissions_Handle_Assessors_Assessments_Read($submission,$assessors);

        
        if ($this->CGI_POSTint("Update")==1)
        {
            $this->Submissions_Handle_Assessors_Assessments_Update($submission,$assessors,$assessments);
        }
        
        $weight=0.0;
        foreach ($this->Criterias() as $cid => $criteria)
        {
            $weight+=$criteria[ "Weight" ];
        }
        
        $sums=array();
        foreach ($assessors as $assessor)
        {
            $friendid=$assessor[ "Friend" ];
            $sums[ $friendid ]=0.0;
        }
        

        $table=array();
        $n=1;
        foreach ($this->Criterias() as $cid => $criteria)
        {
            $criteriaid=$criteria[ "ID" ];
            $criteria[ "No" ]=$n++;
            
            $sum=0.0;
            foreach ($assessors as $assessor)
            {
                $friendid=$assessor[ "Friend" ];
                
                $assessment=array();
                if (!empty($assessments[ $friendid ][ $criteriaid ]))
                {
                    $assessment=$assessments[ $friendid ][ $criteriaid ];
                    $sums[ $friendid ]+=$assessment[ "Value" ];
                    $sum+=$assessment[ "Value" ];
                }
            }

            array_push
            (
               $table,
               $this->Submission_Handle_Assessors_Assessments_Criteria_Rows
               (
                  $edit,
                  $submission,
                  $assessments,
                  $assessors,
                  $criteria
               )
            );
        }

        array_push
        (
           $table,
           $this->AssessorsObj()->Assessors_Submission_Media_Row($submission,$assessors)
        );

        if ($edit==1)
        {
            array_push
            (
                $table,
                array($this->Buttons())
            );
        }
        
        return $table;
    }
}

?>