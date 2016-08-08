<?php



class AssessorsInscriptionAssessmentsRows extends AssessorsInscriptionAssessmentsCells
{
    //*
    //* function Assessors_Inscription_Assessments_Titles, Parameter list: 
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessors_Inscription_Assessments_Titles($criteriadatas)
    {
        return
            array_merge
            (
               $this->CriteriasObj()->GetDataTitles($criteriadatas),
               $this->AssessmentsObj()->GetDataTitles(array("Value","Weighted"))
            );
    }

    //*
    //* function Assessors_Inscription_Assessment_Row, Parameter list: $n,$assessor,$criterias,$assessments,$criteriadatas,$assessmentdata
    //*
    //* Creates $assessor $assessment row.
    //*

    function Assessors_Inscription_Assessment_Row($edit,$n,$assessor,$criteria,$assessment,$criteriadatas,$assessmentdata)
    {
        return
            array_merge
            (
               $this->CriteriasObj()->MyMod_Items_Table_Row(0,$n,$criteria,$criteriadatas,TRUE),
               $this->AssessmentsObj()->Assessment_Cells($edit,$criteria,$assessor,$assessment)
            );
    }
    
    //*
    //* function Assessors_Inscription_Assessment_Sum_Row, Parameter list: $assessor,$criterias,$assessments,$criteriadatas
    //*
    //* Creates $assessor $assessment row.
    //*

    function Assessors_Inscription_Assessment_Sum_Row($assessor,$criterias,$assessments,$criteriadatas)
    {
        $sum=0.0;
        $wsum=0.0;
        foreach ($criterias as $criteria)
        {
            $assessment=array();
            if (!empty($assessments[ $criteria[ "ID" ] ]))
            {
                $assessment=$assessments[ $criteria[ "ID" ] ];
            }
            
            if (!empty($assessment[ "Value" ]))
            {
                $sum+=1.0*$assessment[ "Value" ];
                $wsum+=1.0*$criteria[ "Weight" ]*$assessment[ "Value" ];;
            }
        }

        $row=array();
        foreach ($criteriadatas as $data) { array_push($row,""); }

        array_pop($row);
        array_push($row,$this->MultiCell($this->ApplicationObj()->Sigma.":",1,"right"));
        

        array_push($row,sprintf("%.1f",$sum),sprintf("%.1f",$wsum));

        return $row;
    }
    
    //*
    //* function Assessors_Inscription_Assessment_Sum_Rows, Parameter list: $assessor,$criterias,$assessments,$criteriadatas
    //*
    //* Creates $assessor $assessment rows. Adds sum row. and HR's
    //*

    function Assessors_Inscription_Assessment_Sum_Rows($assessor,$criterias,$assessments,$criteriadatas)
    {
        return
            array
            (
               array($this->HR()),
               $this->Assessors_Inscription_Assessment_Sum_Row($assessor,$criterias,$assessments,$criteriadatas),
               array($this->HR())
            );
    }
    
}

?>