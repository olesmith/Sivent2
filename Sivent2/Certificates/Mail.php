<?php

class Certificates_Mail extends Certificates_Read
{
    //*
    //* function Certificates_Generate_Mail_Send, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Mail_Send($friend,$where)
    {
        $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);

        $latex="";
        foreach ($certs as $cert)
        {
            $latex.=$this->CertificatesObj()->Certificate_Generate($cert);
        }
        
        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);

        $pdffile=$this->Latex_Run
        (
           $this->CertificatesObj()->Certificate_TexName($friend[ "Name" ]),
           $latex
        );
        
        //$friend[ "Name" ]=$this->LoginData[ "Name" ];
        
        $this->CertificatesObj()->Certificate_Set_Mailed($cert);
        
        $this->ApplicationObj()->ApplicationSendEmail
        (
           $friend,
           array
           (
              "Subject" => $this->FilterHash
              (
                 $this->MyLanguage_GetMessage("Inscriptions_Certificate_Mail_Subject"),
                 $this->Event(),
                 "Event_"
              ),
              "Body"    => $this->FilterHash
              (
                 $this->MyEmail_Mail_Head_Get().
                 $this->MyLanguage_GetMessage("Inscriptions_Certificate_Mail_Body").
                 "\n\n".
                 $this->MyEmail_Mail_Tail_Get().
                 "",
                 $this->Event(),
                 "Event_"
              ),
           ),
           array($this->Event()),
           array
           (
               array
               (
                  "File" => $this->LatexTmpPath()."/".$pdffile,
                  "Name" => $pdffile,
               )
           )
        );
    }
    
}

?>