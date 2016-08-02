<?php


class InscriptionsPreInscriptions extends InscriptionsCertificates
{
    //*
    //* function Inscriptions_PreInscriptions_Has, Parameter list: 
    //*
    //* Returns true or false, whether event should show
    //* preinscriptions.
    //*

    function Inscriptions_PreInscriptions_Has()
    {
        $res=$this->EventsObj()->Event_PreInscriptions_Has();

        return $res;
    }
    
    //*
    //* function Inscriptions_PreInscriptions_Open, Parameter list: $edit=0,$item=array(),$data=""
    //*
    //* Returns PreInscriptions status: open or closed.
    //*

    function Inscriptions_PreInscriptions_Open($item=array())
    {
        $res=$this->EventsObj()->Event_PreInscriptions_Open();

        //todo: consider payment, if configured for event.

        return $res;
    }
    
}

?>