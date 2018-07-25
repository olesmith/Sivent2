<?php

class Collaborators_Friend_Read extends Collaborators_Friend_Where
{
   //*
    //* function Collaborators_Friend_Read, Parameter list: $user
    //*
    //* Reads users collaborations fro db.
    //*

    function Collaborators_Friend_Read($friendid,$inscriptionsonly=TRUE,$inscribedonly=True)
    {
        $this->Collaborators_Friend_Collaborations_Read
        (
            $friendid,
            $inscriptionsonly,
            $inscribedonly
        );
        
        $this->Collaborators_Friend_Collaborators_Read
        (
            $friendid,
            $inscriptionsonly,
            $inscribedonly
        );
    }

    
     //*
    //* function Collaborators_Friend_Collaborations_Read, Parameter list: $friendid,$inscriptionsonly=True,$inscribedonly=False
    //*
    //* Read all event collaborations;
    //*

    function Collaborators_Friend_Collaborations_Read($friendid,$inscriptionsonly=True,$inscribedonly=True)
    {
        if (empty($this->Collaborations))
        {
            $this->Collaborations=
                $this->CollaborationsObj()->Sql_Select_Hashes
                (
                    $this->Collaborators_Friend_Collaborations_Where($friendid,$inscriptionsonly,$inscribedonly),
                    array(),
                    "Name"
                );
        }
        
        return $this->Collaborations;
    }
    
    //*
    //* function Collaborators_Friend_Read, Parameter list: $friendid,$inscriptionsonly=True,$inscribedonly=False
    //*
    //* Reads users collaborations fro db.
    //*

    function Collaborators_Friend_Collaborators_Read($friendid,$inscriptionsonly=True,$inscribedonly=True)
    {
        if (empty($this->Collaborators))
        {
            $where=array
            (
               "Friend" => $friendid,
            );

            $this->Collaborators=
                $this->MyHash_HashesList_2ID
                (
                    $this->CollaboratorsObj()->Sql_Select_Hashes
                    (
                        $this->Collaborators_Friend_Collaborators_Where($friendid,$inscriptionsonly,$inscribedonly)
                    ),
                    "Collaboration"
                );
            
        }
                

        return $this->Collaborations;
    }
}

?>