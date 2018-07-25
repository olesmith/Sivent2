<?php


class Inscriptions_Handle_Submissions_Read extends Inscriptions_Handle_Submissions_Should
{
    //*
    //* function Inscription_Handle_Submissions_Read, Parameter list: $edit,$friend,$inscription
    //*
    //* Determines whether we should show Submissions.
    //*

    function Inscription_Handle_Submissions_Read($item)
    {
        if (empty($this->Submissions) && !empty($item[ "ID" ]))
        {
            $friend=$item[ "ID" ];
            if (!empty($item[ "Friend" ])) {$friend=$item[ "Friend" ]; }

            $this->Submissions=
                $this->SubmissionsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Friend" => $friend,
                    )
                );
        }
   }
}

?>