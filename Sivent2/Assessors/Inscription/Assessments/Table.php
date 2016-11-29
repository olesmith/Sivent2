<?php



class AssessorsInscriptionAssessmentsTable extends AssessorsInscriptionAssessmentsRows
{
    //*
    //* function Assessor_Inscription_Assessments_Table, Parameter list: $edit,$assessor,$criterias,$assessments,$criteriadatas,$assessmentdata
    //*
    //* Creates $assessor assessment table (matrix).
    //*

    function Assessor_Inscription_Assessments_Table($edit,$assessor,$assessments)
    {
        $n=1;

        $table=array();
        foreach ($this->Criterias() as $cid => $criteria)
        {
            $assessment=array();
            if (!empty($assessments[ $criteria[ "ID" ] ]))
            {
                $assessment=$assessments[ $criteria[ "ID" ] ];
            }

            array_push
            (
               $table,
               $this->Assessors_Inscription_Assessment_Row
               (
                   $edit,
                   $n++,
                   $assessor,
                   $criteria,
                   $assessment
               )
            );
        }

        $table=array_merge
        (
           $table,
           $this->Assessors_Inscription_Assessment_Sum_Rows($assessor,$assessments)
        );

        if ($edit==1)
        {
            array_push($table,array($this->Buttons()));
        }
        
        return $table;
    }

}

?>