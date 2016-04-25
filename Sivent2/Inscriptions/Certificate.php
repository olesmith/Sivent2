<?php


class InscriptionsCertificate extends InscriptionsSubmissions
{
 
    //*
    //* function Inscription_Certificate_Latex, Parameter list: $inscription,$friend=array()
    //*
    //* Generates certificate Latex code.
    //*

    function Inscription_Certificate_Latex($inscription,$friend=array())
    {
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where,array("ID","Generated"));
        
        return $this->CertificatesObj()->Certificate_Generate($cert,$inscription,$friend);
    }
    
    //*
    //* function Inscription_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Inscription_Handle_Certificate_Generate()
    {
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ]));
        
        $where=$this->Inscription_Certificate_Where($this->ItemHash);
            
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);

        $latex=
            $this->CertificatesObj()->Certificate_Latex_Head().
            "\n\n".
            $this->CertificatesObj()->Certificate_Generate($cert,$this->ItemHash,$friend).
            "\n\n".
            $this->CertificatesObj()->Certificate_Latex_Tail().
            "";
        
        
        $latex=$this->FilterHash($latex,$this->Event(),"Event_");
        $latex=$this->FilterHash($latex,$this->Unit(),"Unit_");
        
        $this->CertificatesObj()->Certificate_Set_Generated($this->ItemHash,1);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }
        
        return $this->RunLatexPrint($this->CertificatesObj()->Certificate_TexName($friend[ "Name" ]),$latex);
    }

    //*
    //* function Inscription_Certificate_Where, Parameter list: $inscription
    //*
    //* Checks whether certificate has been generated.
    //*

    function Inscription_Certificate_Where($inscription)
    {
        return $this->CertificatesObj()->Certificate_Where($inscription,1);
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
        if (!empty($cert))
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