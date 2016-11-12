<?php
include_once("Table.php");

class Certificates_Handle extends Certificates_Table
{
    //*
    //* function Certificates_Generate_Handle_ByCode, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Handle_ByCode()
    {
        $code=$this->CGI_GET("Code");
        $certs=$this->Certificate_Code2Cert($code);

        $name="";
        $latex=
            $this->Certificates_Latex_Ambles_Put
            (
               $this->Certificates_Generate($certs)
            );
        
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }

        return $this->Latex_PDF($this->CertificatesObj()->Certificate_TexName($name),$latex);
    }
    
    //*
    //* function Certificates_Generate_Handle, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Handle($where,$latexname)
    {
        $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);            

        $latex=$this->CertificatesObj()->Certificates_Generate($certs);

        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
            exit();
        }

        return
            $this->Latex_PDF
            (
               $this->CertificatesObj()->Certificate_TexName($latexname),
               $latex
             );
    }
    
}

?>