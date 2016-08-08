<?php


class SubmissionsHandleAssessmentsRead extends SubmissionsHandleAssessmentsRows
{
    //*
    //* function Submissions_Handle_Assessors_Assessments_Read, Parameter list: $submission,$assessors,$assesmentsdatas=array()
    //*
    //* Reads all $assessors assessments.
    //*

    function Submissions_Handle_Assessors_Assessments_Read($submission,$assessors,$assesmentsdatas=array())
    {
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