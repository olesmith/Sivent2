<?php


class Submissions_Handle_Assessments_Read extends Submissions_Handle_Assessments_Rows
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Read, Parameter list: $submission,$assessors,$assesmentsdatas=array()
    //*
    //* Reads all $assessors assessments.
    //*

    function Submissions_Handle_Assessors_Assessments_Read($submission,&$assessors,$assesmentsdatas=array())
    {
        foreach (array_keys($assessors) as $aid)
        {
            $this->AssessorsObj()->Assessor_Submission_Complete($submission,$assessors[ $aid ]);
        }
        
        $assessorids=$this->MyHash_HashesList_Values($assessors,"Friend");
        
        $where=$this->UnitEventWhere
        (
           array
           (
              "Submission" => $submission[ "ID" ],
              "Friend" => "IN ('".join("','",$assessorids)."')",
           )
        );
            
        $assessments=$this->AssessmentsObj()->Sql_Select_Hashes($where,$assesmentsdatas);

        $rassessments=array();
        foreach ($assessments as $assessment)
        {
            $friendid=$assessment[ "Friend" ];
            $criteriaid=$assessment[ "Criteria" ];
            
            if (empty($rassessments[ $friendid ])) { $rassessments[ $friendid ]=array(); }
            
            $rassessments[ $friendid ][ $criteriaid ]=$assessment;
        }

        return $rassessments;
    }

}

?>