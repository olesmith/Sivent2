<?php

include_once("Certificate/Cells.php");
include_once("Certificate/Handle.php");

class InscriptionsCertificate extends InscriptionsCertificateHandle
{
    //*
    //* function Certificate_Where, Parameter list: $inscription
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificate_Where($inscription)
    {
        $where=
            array
            (
               "Unit"        => $this->Unit("ID"),
               "Event"       => $inscription[ "Event" ],
               "Friend"      => $inscription[ "Friend" ],
               "Inscription" => $inscription[ "ID" ],
               "Type"        => $this->Certificate_Type,
            );

        return $where;
    }
 
    //*
    //* function Certificate_Where, Parameter list: $inscription
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificates_Where($inscription)
    {
        $type=$this->CGI_GET("Type");
        
        $where=
            array
            (
               "Unit"        => $inscription[ "Unit" ],
               "Event"       => $inscription[ "Event" ],
               "Friend"      => $inscription[ "Friend" ],
            );

        if ($type==1)
        {
            $where[ "Inscription" ]=$inscription[ "ID" ];
            $where[ "Type" ]=$this->Certificate_Type;
        }

        return $where;
    }
 
    //*
    //* function Certificate_All_Where, Parameter list: 
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificates_All_Where()
    {
        $type=$this->CGI_GET("Type");
        
        $where=
            array
            (
               "Unit"        => $this->Unit("ID"),
               "Event"       => $this->Event("ID"),
               "Type"        => $this->Certificate_Type,
            );

        return $where;
    }
 
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