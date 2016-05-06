<?php


class CollaboratorsCertificate extends CollaboratorsTable
{
    //*
    //* function Collaborator_Certificate_Where, Parameter list: $collaborator,$friendid=0
    //*
    //* Returns $where clause for submission certificate.
    //*

    function Collaborator_Certificate_Where($collaborator,$friendid=0)
    {
        if (empty($friendid)) { $friendid=$collaborator[ "Friend" ]; }
        
        return
            array
            (
               "Unit"          => $collaborator[ "Unit" ],
               "Event"         => $collaborator[ "Event" ],
               "Friend"        => $friendid,
               "Type"          => $this->Certificate_Type,
               "Collaboration" => $collaborator[ "Collaboration" ],
            );
    }

    //*
    //* function Collaborator_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Collaborator_Handle_Certificate_Generate()
    {
        $where=$this->Collaborator_Certificate_Where($this->ItemHash);

        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);

        $latex=$this->CertificatesObj()->Certificate_Generate($cert);

        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        $this->CertificatesObj()->Certificate_Set_Generated($cert);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }

        return
            $this->RunLatexPrint
            (
               $this->CertificatesObj()->Certificate_TexName
               (
                  $cert[ "Friend_Hash" ][ "Name" ]
               ),
               $latex
             );
    }
}
?>