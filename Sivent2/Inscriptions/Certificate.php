<?php

include_once("Certificate/Cells.php");
include_once("Certificate/Handle.php");

class InscriptionsCertificate extends InscriptionsCertificateHandle
{
    //*
    //* function Inscription_Certificate_Latex, Parameter list: $inscription,$friend=array()
    //*
    //* Generates certificate Latex code.
    //*

    function Inscription_Certificate_Latex($cert)
    {
        return $this->CertificatesObj()->Certificate_Generate($cert);
    }
}

?>