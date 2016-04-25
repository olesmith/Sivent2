<?php


class InscriptionsInscribe extends InscriptionsTables
{
    //*
    //* function HandleInscribe, Parameter list: $friend=array()
    //*
    //* Handle  inscription.
    //*

    function HandleInscribe($friend=array())
    {
        parent::HandleInscribe($friend);
    }

    //*
    //* function Inscribe, Parameter list: $friend=array()
    //*
    //* Adds Inscription.
    //*

    function Inscribe($friend=array())
    {
        unset($this->Inscription[ "Assessments" ]);
        parent::Inscribe($friend);
    }
}

?>