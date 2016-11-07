<?php

class InscriptionsUpdate extends InscriptionsInscribe
{
    //*
    //* function Inscription_Group_Update, Parameter list: &$inscription
    //*
    //* Updates data from Submissions form.
    //*

    function Inscription_Group_Update($group,&$inscription)
    {
        $inscription=$this->MyMod_Item_Update_CGI($inscription,$this->GetGroupDatas($group,TRUE),$prepost="");
        
        return $inscription;
    }
}

?>