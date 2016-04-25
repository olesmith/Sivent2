<?php


class InscriptionsCertificates extends InscriptionsCertificate
{
    //*
    //* function Inscriptions_Certificates_Has, Parameter list: 
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Inscriptions_Certificates_Has()
    {
        $event=$this->Event();

        return $this->EventsObj()->Event_Certificates_Has($event);
    }

    //*
    //* function Inscriptions_Certificates_Has, Parameter list: 
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Inscriptions_Certificates_Published()
    {
        $event=$this->Event();

        return
            $this->EventsObj()->Event_Certificates_Has($event)
            &&
            $this->EventsObj()->Event_Certificates_Published($event);
    }

   //*
    //* function InscriptionCertificateTable, Parameter list: $edit,$item,$group="Certificates"
    //*
    //* Creates inscrition certificate html table.
    //*

    function Inscription_Certificate_Table($edit,$item,$group="Certificates")
    {
        if (empty($group)) { $group="Collaborations"; }
        
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        $this->ItemDataGroups();
        
        $rdatas=$this->GetGroupDatas($group,TRUE);

        if ($item[ "Certificate" ]!=2)
        {
            $rdatas=array("Certificate");
        }

        return 
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->MyMod_Item_Table_Html($edit,$item,$rdatas).
            "";
    }
}

?>