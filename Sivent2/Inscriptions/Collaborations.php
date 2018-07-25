<?php


class InscriptionsCollaborations extends InscriptionsForm
{
    //*
    //* function Inscriptions_Collaborations_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Show_Should($inscription=array())
    {
        $res=
            $this->EventsObj()->Event_Collaborations_Inscriptions_Open($this->Event())
            ||
            $this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ]));

        return $res;
    }

    //*
    //* function Inscriptions_Collaborations_Show_Name, Parameter list: 
    //*
    //* Generates  name for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Name($data,$inscription=array())
    {
        $title="";
        if ($this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ])))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions_Collaborations_Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Title($data,$inscription=array())
    {
        $title="";
        if ($this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ])))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Title");
        }

        return $title;
    }
}

?>