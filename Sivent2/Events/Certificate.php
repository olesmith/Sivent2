<?php

class EventsCertificate extends EventsCertificates
{
    //*
    //* function Event_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates 'empty' certificate for vizualization.
    //*

    function Event_Handle_Certificate_Generate()
    {
        $latex="";
        foreach (array(1,2,3,4) as $type)
        {
            $cert[ "Type" ]=$type;
            $cert=$this->CertificatesObj()->Certificate_Get_Empty();
            $latex.=
                $this->CertificatesObj()->Certificate_Generate($cert).
                "";
            //var_dump($cert);
        }
        
        $latex=preg_replace('/#/',"\\#",$latex);
        $latex=preg_replace('/_/',"\\_",$latex);

        
        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }
        
        return $this->RunLatexPrint($this->CertificatesObj()->Certificate_TexName("Test"),$latex);
    }
}

?>