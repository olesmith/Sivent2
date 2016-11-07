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
        return $this->UnitEventWhere
        (    
            array
            (
               "Friend"      => $inscription[ "Friend" ],
               //"Inscription" => $inscription[ "ID" ],
               "Type"        => $this->Certificate_Type,
            ),
            $inscription[ "Event" ]
         );
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
               "Friend"      => $inscription[ "Friend" ],
            );

        if ($type==1)
        {
            //$where[ "Inscription" ]=$inscription[ "ID" ];
            $where[ "Type" ]=$this->Certificate_Type;
        }

        return $this->UnitEventWhere($where,$inscription[ "Event" ]);
        
    }
 
    //*
    //* function Certificate_All_Where, Parameter list: 
    //*
    //* SQL where for locating all event certs.
    //*

    function Inscription_Certificates_All_Where()
    {
        $type=$this->CGI_GET("Type");
        $where=$this->UnitEventWhere
        (
            array
            (
                "Type"        => $this->Certificate_Type,
            )
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