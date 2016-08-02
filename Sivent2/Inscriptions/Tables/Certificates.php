<?php

class InscriptionsTablesCertificates extends InscriptionsTablesCaravans
{
    //*
    //* function Inscription_Certificate_Link, Parameter list: 
    //*
    //* Creates inscription certificate info row (no details).
    //*

    function Inscription_Certificate_Link($item)
    {
        $message="Certificate_Link";
        if (!$this->Inscriptions_Certificates_Published())
        {
            return $this->MyLanguage_GetMessage("Certificate_Not_Available_Yet");
        }
        

        return $this->Inscription_Type_Link("Certificate",$message);
    }
    
    //*
    //* function Inscription_Certificate_Row, Parameter list: 
    //*
    //* Creates inscription speaker info row (no details).
    //*

    function Inscription_Certificate_Rows($item)
    {
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "Certificate",
               $this->Inscription_Certificate_Link($item),
               array("Certificates","Certificates_Published",)
            );
    }

    
    //*
    //* function InscriptionCertificateTable, Parameter list: $edit,$item,$group="Certificates"
    //*
    //* Creates inscrition certificate html table.
    //*

    function Inscription_Certificate_Table($edit,$item,$group="Certificates")
    {
        if (!$this->Inscriptions_Certificates_Published()) { return array(); }
        
        $table=array();
        $type=$this->InscriptionTablesType($item);
        if ($type!="Certificate")
        {
            return $this->Inscription_Certificate_Rows($item);
        }
        
        if (empty($group)) { $group="Certificates"; }
        
        $this->ItemDataGroups();
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        
        $rdatas=$this->GetGroupDatas($group,TRUE);

        if ($item[ "Certificate" ]!=2)
        {
            $rdatas=array("Certificate");
        }

        array_push
        (
           $table,
           array
           (
              $this->FrameIt
              (
                 $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
                 $this->MyMod_Item_Table_Html($edit,$item,$rdatas)
              )
           )
        );
            
        return $table;
    }
}

?>