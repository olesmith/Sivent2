<?php


class Submissions_Handle_Assessments_Rows extends Submissions_Handle_Assessments_Cells
{
    //*
    //* function Submission_Handle_Assessors_Assessments_Titles, Parameter list: $assessors
    //*
    //* Generate $assessors assessments table title row.
    //*

    function Submission_Handle_Assessors_Assessments_Titles($assessors)
    {
        $row1=array("No","Criteria","Peso");
        $row2=array($this->MultiCell("&nbsp;",count($row1)));

        $n=1;
        foreach ($assessors as $assessor)
        {
            $cell=$this->AssessorsObj()->MyMod_ItemName()." #".$n++;
            if (preg_match('/^(Coordinator|Admin)$/',$this->Profile()))
            {
                $cell=$this->FriendsObj()->Sql_Select_Hash_Value($assessor[ "Friend" ],"Name");
            }
            
            array_push($row1,$this->MultiCell($cell,2));
            array_push($row2,"N","W");
        }
        
        array_push
        (
            $row1,
            $this->MultiCell(count($this->AssessorsObj()->Assessors_Submission_HasAssesed($assessors)),2)
        );
        
        array_push
        (
           $row2,
           $this->ApplicationObj()->Mu,
           $this->ApplicationObj()->Pi
        );
        
        return array($row1,$row2);
    }

    //*
    //* function Submission_Handle_Assessors_Assessments_Criteria_Rows, Parameter list: $edit,$submission,$assessments,$assessors,$criteria
    //*
    //* Generate $assessors $criteria row.
    //*

    function Submission_Handle_Assessors_Assessments_Criteria_Rows($edit,$submission,$assessments,$assessors,$criteria)
    {
        $criteriaid=$criteria[ "ID" ];
            
        $row=
            array
            (
               $this->B($criteria[ "No" ]),
               $criteria[ "Name" ],
               $this->B(sprintf("%.1f",$criteria[ "Weight" ]))
            );

        //$sum=0.0;
        foreach ($assessors as $assessor)
        {
            $friendid=$assessor[ "Friend" ];
                
            $assessment=array();
            if (!empty($assessments[ $friendid ][ $criteriaid ]))
            {
                $assessment=$assessments[ $friendid ][ $criteriaid ];
                //$sum+=$assessment[ "Value" ];
            }

            $row=array_merge($row,$this->AssessmentsObj()->Assessment_Cells($edit,$criteria,$assessor,$assessment));
        }
        
        $row=array_merge
        (
           $row,
           $this->Submissions_Handle_Assessors_Assessments_Criteria_Cells($submission,$assessments,$assessors,$criteria)
        );
            
        return $row;
    }
    
}

?>