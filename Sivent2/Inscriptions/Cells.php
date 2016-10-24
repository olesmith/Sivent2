<?php




class InscriptionsCells extends InscriptionsRead
{

    //*
    //* function Inscription_Collaborators_Noof_Cell, Parameter list: $inscription=array()
    //*
    //* Returns number of collaborators registered for $inscription.
    //*

    function Inscription_Collaborators_Noof_Cell($inscription=array())
    {
        if (empty($inscription)) { return $this->MyLanguage_GetMessage("Inscriptions_Collaborators_Cell_Noof_Title"); }
        
        $ninscribed=$this->CollaboratorsObj()->Sql_Select_NEntries(array("Friend" => $inscription[ "Friend" ]));

        if (empty($ninscribed)) { $ninscribed="-"; }
        
        return
            $this->Div
            (
               $ninscribed,
               array("CLASS" => 'right')
            );        
    }
    
    //*
    //* function Inscription_Caravaneers_Noof_Cell, Parameter list: $inscription=array()
    //*
    //* Returns number of Caravaneers registered for $inscription.
    //*

    function Inscription_Caravaneers_Noof_Cell($inscription=array())
    {
        if (empty($inscription)) { return $this->MyLanguage_GetMessage("Inscriptions_Caravaneers_Cell_Noof_Title"); }
        
        $ninscribed=$this->CaravaneersObj()->Sql_Select_NEntries(array("Friend" => $inscription[ "Friend" ],"Status" => 1));

        if (empty($ninscribed)) { $ninscribed="-"; }

        return
            $this->Div
            (
               $ninscribed,
               array("CLASS" => 'right')
            );        
    }
    
    //*
    //* function Inscription_Submissions_Noof_Cell, Parameter list: $inscription=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Inscription_Submissions_Noof_Cell($inscription=array())
    {
        if (empty($inscription)) { return $this->MyLanguage_GetMessage("Inscriptions_Submissions_Cell_Noof_Title"); }
        
        $ninscribed=$this->SubmissionsObj()->Sql_Select_NEntries(array("Friend" => $inscription[ "Friend" ]));

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