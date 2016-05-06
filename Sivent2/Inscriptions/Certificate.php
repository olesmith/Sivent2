<?php


class InscriptionsCertificate extends InscriptionsSubmissions
{
    //*
    //* function Certificate_Where, Parameter list: $inscription
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificate_Where($inscription)
    {
        $where=
            array
            (
               "Unit"        => $inscription[ "Unit" ],
               "Event"       => $inscription[ "Event" ],
               "Friend"      => $inscription[ "Friend" ],
               "Inscription" => $inscription[ "ID" ],
               "Type"        => $this->Certificate_Type,
            );

        return $where;
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
               "Unit"        => $inscription[ "Unit" ],
               "Event"       => $inscription[ "Event" ],
               "Friend"      => $inscription[ "Friend" ],
            );

        if ($type==1)
        {
            $where[ "Inscription" ]=$inscription[ "ID" ];
            $where[ "Type" ]=$this->Certificate_Type;
        }

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
    
    //*
    //* function Inscription_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Inscription_Handle_Certificate_Generate()
    {
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ]));
        
        $where=$this->Inscription_Certificates_Where($this->ItemHash);
            
        $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);

        $latex="";
        foreach ($certs as $cert)
        {
            $latex.=$this->CertificatesObj()->Certificate_Generate($cert);
        }
        
        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);

        $this->CertificatesObj()->Certificate_Set_Generated($cert);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }
        
        return $this->RunLatexPrint($this->CertificatesObj()->Certificate_TexName($friend[ "Name" ]),$latex);
    }

    //*
    //* function Inscription_Certificate_Generated_Cell, Parameter list: $inscription=array()
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificate_Generated_Cell($inscription=array())
    {
        if (empty($inscription)) { return $this->MyLanguage_GetMessage("Inscriptions_Certificate_Generated_Title");}
        
        $where=$this->Inscription_Certificate_Where($inscription);
            
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where,array("ID","Generated"));

        $cell="-";
        if (!empty($cell))
        {
            $cell=$this->CertificatesObj()->MyMod_Data_Fields_Show("Generated",$cert,TRUE);
        }
        
        return $cell;
    }
    
    //*
    //* function Inscription_Certificate_Mailed_Cell, Parameter list: $inscription=array()
    //*
    //* Checks whether certificate has been mailed.
    //*

    function Inscription_Certificate_Mailed_Cell($inscription=array())
    {
        if (empty($inscription)) { return $this->MyLanguage_GetMessage("Inscriptions_Certificate_Mailed_Title");}
        
        $where=$this->Inscription_Certificate_Where($inscription);
            
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where,array("Mailed"));

        $cell="-";
        if (!empty($cert))
        {
            $cell=$this->CertificatesObj()->MyMod_Data_Fields_Show("Mailed",$cert,TRUE);
        }
        
        return $cell;
    }
    
}

?>