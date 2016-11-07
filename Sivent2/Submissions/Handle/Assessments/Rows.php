<?php


class Submissions_Handle_Assessments_Rows extends Submissions_Handle_Assessments_Cells
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Titles, Parameter list: $assessors
    //*
    //* Generate $assessors assessments table title row.
    //*

    function Submissions_Handle_Assessors_Assessments_Titles($assessors)
    {
        $row=array("No","Criteria","Peso");
        foreach ($assessors as $assessor)
        {
            array_push($row,$this->MultiCell($this->FriendsObj()->Sql_Select_Hash_Value($assessor[ "Friend" ],"Name"),2));
        }
        
        array_push
        (
           $row,
           $this->ApplicationObj()->Sigma,
           $this->ApplicationObj()->Pi,
           $this->ApplicationObj()->Mu
        );
        
        return $row;
    }
    
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Rows, Parameter list: $edit,$submission,$assessments,$assessors,$criteria
    //*
    //* Generate $assessors $criteria row.
    //*

    function Submissions_Handle_Assessors_Assessments_Criteria_Rows($edit,$submission,$assessments,$assessors,$criteria)
    {
        $criteriaid=$criteria[ "ID" ];
            
        $row=
            array
            (
               $this->B($criteria[ "No" ]),
               $criteria[ "Name" ],
               sprintf("%.1f",$criteria[ "Weight" ])
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
           $this->Submissions_Handle_Assessors_Assessments_Criteria_Cells_Sum($assessments,$assessors,$criteria)
        );
            
        return $row;
    }
    
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Row_Sum, Parameter list: $submission,$assessments,$assessors,$criterias
    //*
    //* Generate summed row, sums over criterias, per assessor.
    //*

    function Submissions_Handle_Assessors_Assessments_Criterias_Row_Sum($submission,$assessments,$assessors,$criterias)
    {
        $weightsum=$this->CriteriasObj()->Criterias_Weight_Sum($criterias);
        
        $row=
            array
            (
               "",
               $this->MultiCell($this->ApplicationObj()->Sigma.":",1,"right"),
               sprintf("%.1f",$weightsum),
            );

        $sum=0.0;
        $wsum=0.0;
        foreach ($assessors as $assessor)
        {
            $friendid=$assessor[ "Friend" ];
            $asum=$this->Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum($assessments,$assessor,$criterias,FALSE);
            $awsum=$this->Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum($assessments,$assessor,$criterias);
            
            array_push
            (
               $row,
               "",//sprintf("%.1f",$asum),
               sprintf("%.1f",$awsum)
            );
            $sum+=$asum;
            $wsum+=$awsum;
        }

        /* $media=$asum/(1.0*count($assessors)); */
        $wmedia=$wsum;
        if ($wmedia>0.0) { $wmedia=$wsum/$weightsum; }

        array_push
        (
           $row,
           /* sprintf("%.1f",$sum), */
           /* sprintf("%.1f",$wsum), */
           sprintf("%.1f",$wmedia)
        );

        return $row;
    }
    
    //*
    //* function Submissions_Handle_Assessors_Assessments_Criteria_Row_Media, Parameter list: $submission,$assessments,$assessors,$criterias
    //*
    //* Generate media row, sums over criterias, per assessor.
    //*

    function Submissions_Handle_Assessors_Assessments_Criterias_Row_Media($submission,$assessments,$assessors,$criterias)
    {
        $weightsum=$this->CriteriasObj()->Criterias_Weight_Sum($criterias);

        $factor=1.0/(1.0*count($criterias));
        $weightmedia=$weightsum*$factor;
        
        $row=
            array
            (
               "",
               $this->MultiCell($this->ApplicationObj()->Mu.":",1,"right"),
               sprintf("%.1f",$weightmedia),
            );

        $sum=0.0;
        $wsum=0.0;
        foreach ($assessors as $assessor)
        {
            $friendid=$assessor[ "Friend" ];
            $asum=$factor*$this->Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum($assessments,$assessor,$criterias,FALSE);
            $awsum=$factor*$this->Submissions_Handle_Assessor_Assessments_Criterias_Calc_Sum($assessments,$assessor,$criterias);
            
            array_push
            (
               $row,
               sprintf("%.1f",$asum),
               sprintf("%.1f",$awsum)
            );
            $sum+=$asum;
            $wsum+=$awsum;
        }

        //$media=$asum/(1.0*count($assessors));
        $wmedia=$wsum/$weightsum;

        array_push
        (
           $row,
           sprintf("%.1f",$sum),
           sprintf("%.1f",$wsum),
           sprintf("%.1f",$wmedia)
        );

        return $row;
    }
}

?>