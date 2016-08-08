<?php



class AssessorsInscriptionAssessmentsTable extends AssessorsInscriptionAssessmentsRows
{
    //*
    //* function Assessors_Inscription_Assessments_Table, Parameter list: $edit,$assessor,$criterias,$assessments,$criteriadatas,$assessmentdata
    //*
    //* Creates $assessor assessment table (matrix).
    //*

    function Assessors_Inscription_Assessments_Table($edit,$assessor,$criterias,$assessments,$criteriadatas,$assessmentdata)
    {
        $n=1;

        $table=array();
        foreach ($criterias as $criteria)
        {
            $assessment=array();
            if (!empty($assessments[ $criteria[ "ID" ] ]))
            {
                $assessment=$assessments[ $criteria[ "ID" ] ];
            }

            array_push
            (
               $table,
               $this->Assessors_Inscription_Assessment_Row($edit,$n++,$assessor,$criteria,$assessment,$criteriadatas,$assessmentdata)
            );
        }

        $table=array_merge
        (
           $table,
           $this->Assessors_Inscription_Assessment_Sum_Rows($assessor,$criterias,$assessments,$criteriadatas)
        );

        if ($edit==1)
        {
            array_push($table,array($this->Buttons()));
        }
        
        return $table;
    }

}

?>