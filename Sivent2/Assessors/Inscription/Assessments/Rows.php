<?php



class AssessorsInscriptionAssessmentsRows extends AssessorsInscriptionAssessmentsCells
{
    //*
    //* function Assessor_Inscription_Assessments_Titles, Parameter list: 
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessor_Inscription_Assessments_Titles()
    {
        return
            array_merge
            (
               $this->CriteriasObj()->MyMod_Data_Titles
               (
                   $this->Assessor_Inscription_Form_Criterias_Data()
               ),
               $this->AssessmentsObj()->MyMod_Data_Titles
               (
                   $this->Assessor_Inscription_Form_Assessments_Data()
               )
            );
    }

    //*
    //* function Assessors_Inscription_Assessment_Row, Parameter list: $n,$assessor,$criterias,$assessments
    //*
    //* Creates $assessor $assessment row.
    //*

    function Assessors_Inscription_Assessment_Row($edit,$n,$assessor,$criteria,$assessment)
    {
        return
            array_merge
            (
               $this->CriteriasObj()->MyMod_Items_Table_Row
               (
                   0,
                   $n,
                   $criteria,
                   $this->Assessor_Inscription_Form_Criterias_Data(),
                   TRUE
               ),
               $this->AssessmentsObj()->Assessment_Cells($edit,$criteria,$assessor,$assessment)
            );
    }
    
    //*
    //* function Assessors_Inscription_Assessment_Sum_Row, Parameter list: $assessor,$assessments
    //*
    //* Creates $assessor $assessment row.
    //*

    function Assessors_Inscription_Assessment_Sum_Row($assessor,$assessments)
    {
        $sum=0.0;
        $wsum=0.0;
        foreach ($this->Criterias() as $cid => $criteria)
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
        foreach ($this->Assessor_Inscription_Form_Criterias_Data() as $data) { array_push($row,""); }

        array_pop($row);
        array_push($row,$this->MultiCell($this->ApplicationObj()->Sigma.":",1,"right"));
        

        array_push($row,sprintf("%.1f",$sum),sprintf("%.1f",$wsum));

        return $row;
    }
    
    //*
    //* function Assessors_Inscription_Assessment_Sum_Rows, Parameter list: $assessor,$assessments
    //*
    //* Creates $assessor $assessment rows. Adds sum row. and HR's
    //*

    function Assessors_Inscription_Assessment_Sum_Rows($assessor,$assessments)
    {
        return
            array
            (
               array($this->HR()),
               $this->Assessors_Inscription_Assessment_Sum_Row($assessor,$assessments),
               array($this->HR())
            );
    }
    
}

?>