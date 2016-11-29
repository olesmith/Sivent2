<?php


class InscriptionsCertificateCells extends InscriptionsAssessments
{ 
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