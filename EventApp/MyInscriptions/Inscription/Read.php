<?php

class MyInscriptionsInscriptionRead extends MyInscriptionsQuest
{
     //*
    //* function Friend2SqlWhere, Parameter list: $friend
    //*
    //* Returns friend sql where.
    //*

    function Friend2SqlWhere($friend)
    {
        $where=array
        (
         //"Unit" => $this->ApplicationObj->Unit("ID"),
           "Friend" => $friend[ "ID" ],
        );

        $eventid=$this->ApplicationObj->Event("ID");
        if (!empty($eventid))
        {
            $where[ "Event" ]=$this->ApplicationObj->Event("ID");
        }
        
        return $where;
    }
    
   //*
    //* function ReadInscription, Parameter list:
    //*
    //* Reads  inscription.
    //*

    function ReadInscription()
    {
        $this->Inscription=$this->InscriptionsObj()->Sql_Select_Hash
        (
           $this->Friend2SqlWhere($this->Friend),
           TRUE,
           array_keys($this->ItemData)
        );
    }

    //*
    //* function IsInscribed, Parameter list: $friend
    //*
    //* Reads  inscription.
    //*

    function IsInscribed($friend)
    {
        $ninscriptions=$this->Sql_Select_NEntries
        (
           $this->Friend2SqlWhere($friend)
        );

        $res=FALSE;
        if ($ninscriptions>0) { $res=TRUE; }

        return $res;
    }

}

?>