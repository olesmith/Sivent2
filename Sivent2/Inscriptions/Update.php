<?php

class InscriptionsUpdate extends InscriptionsInscribe
{
    //*
    //* function Inscription_Group_Update, Parameter list: &$item
    //*
    //* Updates data from Submissions form.
    //*

    function Inscription_Group_Update($group,&$item)
    {
        $item=$this->MyMod_Item_Update_CGI($item,$this->GetGroupDatas($group,TRUE),$prepost="");
        
        return $item;
    }
}

?>