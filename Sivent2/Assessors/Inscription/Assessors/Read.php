<?php


class AssessorsInscriptionAssessorsRead extends AssessorsAccess
{

    //*
    //* function Assessors_Friend_Assessors_Read, Parameter list: $edit,$inscription
    //*
    //* Reads $friend assessors.
    //*

    function Assessors_Friend_Assessors_Read($edit,$friend)
    {
        $where=$this->UnitEventWhere(array("Friend" => $friend[ "ID" ]));

        $cond=$this->CGI_GETint("Cond");
        if ($cond==1)
        {
            $where[ "HasAssessed" ]=1;
        }
        elseif ($cond==2)
        {
            $where[ "HasAssessed" ]=2;
        }

        $assessors=$this->Sql_Select_Hashes($where);
        if (empty($assessors))
        {
            unset($where[ "HasAssessed" ]);
            $assessors=$this->Sql_Select_Hashes($where);
       }

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