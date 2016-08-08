<?php


class AssessorsInscriptionAssessorsRead extends AssessorsAccess
{

    //*
    //* function Assessors_Inscription_Assessors_Read, Parameter list: $edit,$inscription
    //*
    //* Reads assessors.
    //*

    function Assessors_Inscription_Assessors_Read($edit,$inscription)
    {
        $where=$this->UnitEventWhere(array("Friend" => $inscription[ "Friend" ]));
        $assessors=$this->Sql_Select_Hashes($where);

        foreach (array_keys($assessors) as $aid)
        {
            $assessors[ $aid ][ "Submission_Hash" ]=
                $this->SubmissionsObj()->Sql_Select_Hash(array("ID" => $assessors[ $aid ][ "Submission" ]));
            $assessors[ $aid ][ "Friend_Hash" ]=
                $this->FriendsObj()->Sql_Select_Hash(array("ID" => $assessors[ $aid ][ "Friend" ]));
        }

        return $assessors;
    }
}

?>