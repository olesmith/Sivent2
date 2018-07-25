<?php


class Inscriptions_Handle_Collaborations_Read extends Inscriptions_Handle_Submissions
{    
    //*
    //* function Inscription_Handle_Collaborations_Read, Parameter list: $edit,$friend,$inscription
    //*
    //* Determines whether we should show Collaborations.
    //*

    function Inscription_Handle_Collaborations_Read($item)
    {
        if (empty($this->Collaborators))
        {
            $friend=$item[ "ID" ];
            if (!empty($item[ "Friend" ])) {$friend=$item[ "Friend" ]; }

            $this->Collaborators=
                $this->CollaboratorsObj()->Sql_Select_Hashes
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