<?php

class Collaborators_Friend_Where extends Collaborators_Friend_Row
{
    //*
    //* function Collaborators_Friend_Collaborations_Where, Parameter list: 
    //*
    //* Sql where for collaborations read.
    //*

    function Collaborators_Friend_Collaborations_Where($userid,$inscriptionsonly=TRUE,$inscribedonly=True)
    {
        $where=array();
        $where[ "Event" ]=$this->Event("ID");
        
        if ($inscriptionsonly)
        {
            $where[ "Inscriptions" ]=2;
        }

        return $where;
    }
    
    //*
    //* function Collaborators_Friend_Collaborators_Where, Parameter list: 
    //*
    //* Sql where for Collaborators read.
    //*

    function Collaborators_Friend_Collaborators_Where($userid,$inscriptionsonly=TRUE,$inscribedonly=True)
    {
        if ($inscribedonly)
        {
            $where=array
            (
               "Friend" => $userid,
            );
        }

    }
    
}

?>