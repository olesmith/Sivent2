<?php

class MyInscriptions_Inscription_Read extends MyInscriptions_Quest
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
        $where=$this->Friend2SqlWhere($this->Friend);

        if (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $iid=$this->CGI_GETint("ID");
            if (!empty($iid))
            {
                $fid=$this->InscriptionsObj()->Sql_Select_Hash_Value($iid,"Friend");
                if (!empty($iid))
                {
                    $this->Friend=$this->FriendsObj()->Sql_Select_Hash
                    (
                       array("ID" => $fid),
                       TRUE,
                       array()
                    );
                }
            }
        }
 
        $this->Inscription=$this->Sql_Select_Hash
        (
           $this->Friend2SqlWhere($this->Friend),
           TRUE,
           array_keys($this->ItemData)
        );
    }
}

?>