<?php


class SubmissionsCertificate extends SubmissionsTable
{
    //*
    //* function Submission_Certificate_Where, Parameter list: $inscription,$friendid=0
    //*
    //* Returns $where clause for submission certificate.
    //*

    function Submission_Certificate_Where($submission,$friendid=0)
    {
        if (empty($friendid)) { $friendid=$submission[ "Friend" ]; }
        
        return
            array
            (
               "Unit"        => $submission[ "Unit" ],
               "Event"       => $submission[ "Event" ],
               "Friend"      => $friendid,
               "Submission" => $submission[ "ID" ],
               "Type"        => $this->Certificate_Type,
            );
    }

    //*
    //* function Submission_Authors_Get, Parameter list: $submission
    //*
    //* Returns submission authors as a list.
    //*

    function Submission_Authors_Get($submission)
    {
        $authors=array();
        foreach (array("Author1","Author2","Author3") as $data)
        {
            if (!empty($submission[ $data ]))
            {
                array_push($authors,$submission[ $data ]);
            }
        }

        return $authors;
    }
    
    //*
    //* function Submission_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Submission_Handle_Certificate_Generate()
    {
        $where=$this->Submission_Certificate_Where($this->ItemHash);

        
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);            

        $latex=
            $this->CertificatesObj()->Certificates_Latex_Ambles_Put
            (
               $this->CertificatesObj()->Certificate_Generate($cert)
            );

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