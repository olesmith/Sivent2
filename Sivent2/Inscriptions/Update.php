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
        $inscription=
            $this->MyMod_Item_Update_CGI
            (
                $inscription,
                $this->MyMod_Data_Group_Datas_Get($group,TRUE),
                $prepost=""
            );
        
        return $inscription;
    }
}

?>