<?php


class InscriptionsCertificates extends InscriptionsCertificate
{
    //*
    //* function Inscriptions_Certificates_Has, Parameter list: 
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Inscriptions_Certificates_Has()
    {
        $event=$this->Event();

        return $this->EventsObj()->Event_Certificates_Has($event);
    }

    //*
    //* function Inscriptions_Certificates_Has, Parameter list: 
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Inscriptions_Certificates_Published()
    {
        $event=$this->Event();

        return
            $this->EventsObj()->Event_Certificates_Has($event)
            &&
            $this->EventsObj()->Event_Certificates_Published($event);
    }
}

?>