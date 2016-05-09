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
        foreach (array(1,3,4) as $type)
        {
            $cert=
                array
                (
                   "Unit" => $this->Unit("ID"),
                   "Event" => $this->Event("ID"),
                   "Type" => $type,
                );
            
            $latex.=
                $this->CertificatesObj()->Certificate_Generate($cert).
                "";
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