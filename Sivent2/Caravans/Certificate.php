<?php


class Caravans_Certificate extends Caravans_Caravaneers
{
    //*
    //* function Caravan_Certificate_Where, Parameter list: $caravan,$friendid=0
    //*
    //* Returns $where clause for submission certificate.
    //*

    function Caravan_Certificate_Where($caravan,$friendid=0)
    {
        if (empty($friendid)) { $friendid=$caravan[ "Friend" ]; }
        
        return
            array
            (
               "Unit"          => $caravan[ "Unit" ],
               "Event"         => $caravan[ "Event" ],
               "Friend"        => $friendid,
               "Type"          => $this->Certificate_Type,
            );
    }

    //*
    //* function Caravan_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Caravan_Handle_Certificate_Generate()
    {
        $where=$this->Caravan_Certificate_Where($this->ItemHash);

        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);

        $latex=$this->CertificatesObj()->Certificate_Generate($cert);

        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        $this->CertificatesObj()->Certificate_Set_Generated($cert);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }

        return
            $this->Latex_PDF
            (
               $this->CertificatesObj()->Certificate_TexName
               (
                  $cert[ "Friend_Hash" ][ "Name" ]
               ),
               $latex
             );
    }
    
    //*
    //* function Caravan_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates submission certificate in Latex, generates and sends the PDF.
    //*

    function Caravan_Handle_Certificate_Mail_Send()
    {
        $this->CertificatesObj()->Certificates_Generate_Mail_Send
        (
           $this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ])),
           $this->Caravan_Certificate_Where($this->ItemHash)
        );
    }
    
    //*
    //* function Caravan_Certificates_Where, Parameter list: 
    //*
    //* Returns $where clause for all submission certificates.
    //*

    function Caravan_Certificates_Where()
    {
        return
            array
            (
               "Unit"        => $this->Unit("ID"),
               "Event"       => $this->Event("ID"),
               "Type"        => $this->Certificate_Type,
            );
    }

    //*
    //*
    //* function Caravan_Handle_Certificates_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Caravan_Handle_Certificates_Generate()
    {
        return
            $this->CertificatesObj()->Certificates_Generate_Handle
            (
               $this->Caravan_Certificates_Where(),
               "Certs.Caravans.".
               $this->Event("Name")
            );
    }
    
}
?>