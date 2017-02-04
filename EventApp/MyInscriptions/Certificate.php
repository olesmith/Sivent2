<?php


class MyInscriptions_Certificate extends MyInscriptions_Add
{
    //*
    //* function Inscription_Certificate_Where, Parameter list: $inscription
    //*
    //* Returns where clause has for one inscription cert.
    //*

    function Inscription_Certificate_Where($inscription)
    {
        return $this->UnitEventWhere
        (    
            array
            (
               "Friend"      => $inscription[ "Friend" ],
               "Type"        => $this->Certificate_Type,
            ),
            $inscription[ "Event" ]
         );
    }
 
    //*
    //* function Inscription_Certificates_Where, Parameter list: $inscription
    //*
    //* Returns where clause has for one inscription friend certs.
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
 
}

?>