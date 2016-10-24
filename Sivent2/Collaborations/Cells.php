<?php


class Collaborations_Cells extends Collaborations_Access
{
    //*
    //* function Collaborations_Collaborators_Noof_Cell, Parameter list: $collaboration=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Collaborations_Collaborators_Noof_Cell($collaboration=array())
    {
        if (empty($collaboration))
        {
            return $this->MyLanguage_GetMessage("Collaborations_Collaborators_Cell_Noof_Title");
        }
        
        $ninscribed=$this->CollaboratorsObj()->Sql_Select_NEntries
        (
           array
           (
              "Collaboration" => $collaboration[ "ID" ],
           )
        );

        if (empty($ninscribed)) { $ninscribed="-"; }
        
        return
            $this->Div
            (
               $ninscribed,
               array("CLASS" => 'right')
            );        
    }
     //*
    //* function Collaborations_Collaborators_NHomologated_Cell, Parameter list: $collaboration=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Collaborations_Collaborators_NHomologated_Cell($collaboration=array())
    {
        if (empty($collaboration))
        {
            return $this->MyLanguage_GetMessage("Collaborations_Collaborators_Cell_NHomologated_Title");
        }
        
        $ninscribed=$this->CollaboratorsObj()->Sql_Select_NEntries
        (
           array
           (
              "Collaboration" => $collaboration[ "ID" ],
              "Homologated" => 2,
           )
        );

        if (empty($ninscribed)) { $ninscribed="-"; }
        
        return
            $this->Div
            (
               $ninscribed,
               array("CLASS" => 'right')
            );        
    }
}

?>