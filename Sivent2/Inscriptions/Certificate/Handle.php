<?php


class InscriptionsCertificateHandle extends InscriptionsCertificateCells
{
    //*
    //* function Inscription_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Inscription_Handle_Certificate_Generate()
    {
        $this->FriendsObj()->Sql_Table_Structure_Update();
        $this->CertificatesObj()->Sql_Table_Structure_Update();
        
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ]));
        
        $where=$this->Inscription_Certificates_Where($this->ItemHash);

        $latex="";
        foreach ($this->CertificatesObj()->Sql_Select_Hashes($where) as $cert)
        {
            $latex.=$this->CertificatesObj()->Certificate_Generate($cert);
            $this->CertificatesObj()->Certificate_Set_Generated($cert);
        }
        
        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }
        
        return $this->Latex_PDF($this->CertificatesObj()->Certificate_TexName($friend[ "Name" ]),$latex);
    }

    
    //*
    //* function Inscription_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Inscription_Handle_Certificate_Mail_Send()
    {
        $this->CertificatesObj()->Certificates_Generate_Mail_Send
        (
           $this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ])),
           $this->Inscription_Certificates_Where($this->ItemHash)
        );
    }
    
    //*
    //* function Inscription_Handle_Certificates_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Inscription_Handle_Certificates_Generate()
    {
        return
            $this->CertificatesObj()->Certificates_Generate_Handle
            (
               $this->Inscription_Certificates_All_Where(),
               "Certs.Participants.".
               $this->Event("Name")
            );
    }
}

?>