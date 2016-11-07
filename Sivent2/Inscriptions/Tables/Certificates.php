<?php

class InscriptionsTablesCertificates extends InscriptionsTablesCaravans
{
    //*
    //* function Inscription_Certificate_Link, Parameter list: 
    //*
    //* Creates inscription certificate link.
    //*

    function Inscription_Certificate_Link($inscription)
    {
        $message="Certificate_Link";
        if (!$this->EventsObj()->Event_Certificates_Published())
        {
            return $this->MyLanguage_GetMessage("Certificate_Not_Available_Yet");
        }
        

        return $this->Inscription_Type_Link("Certificate",$message);
    }
    
    //*
    //* function Inscription_Certificate_Row, Parameter list: $friend,$inscription
    //*
    //* Creates inscription speaker info row (no details).
    //*

    function Friend_Certificate_Rows($friend,$inscription)
    {
        return
            $this->Inscription_Type_Rows
            (
               $inscription,
               "Certificate",
               $this->Inscription_Certificate_Link($inscription),
               array("Certificates","Certificates_Published",)
            );
    }

    
    //*
    //* function Friend_Certificate_Table, Parameter list: $edit,$friend,$inscription,$group="Certificates"
    //*
    //* Creates inscrition certificate html table.
    //*

    function Friend_Certificate_Table($edit,$friend,$inscription,$group="Certificates")
    {
        if (!$this->EventsObj()->Event_Certificates_Published()) { return array(); }
        
        $table=array();
        $type=$this->InscriptionTablesType($inscription);

        if ($type!="Certificate"&& !empty($type))
        {
            return $this->Friend_Certificate_Rows($friend,$inscription);
        }
        
        if (empty($group)) { $group="Certificates"; }
        
        $this->ItemDataGroups();
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        
        $itable="";
        if (!empty($inscription))
        {
            $rdatas=$this->GetGroupDatas($group,TRUE);

            if (empty($inscription[ "Certificate" ]) || $inscription[ "Certificate" ]!=2)
            {
                $rdatas=array("Certificate");
            }

            $itable=
                $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
                $this->MyMod_Item_Table_Html($edit,$inscription,$rdatas).
                "";
        }
        

        

        array_push
        (
           $table,
           array
           (
              $this->FrameIt
              (
                 $itable.
                 $this->CertificatesObj()->Certificates_Friend_Table_Html($friend,$this->Event())
              )
           )
        );

        return $table;
    }
}

?>