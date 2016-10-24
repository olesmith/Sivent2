<?php

class InscriptionsTablesPreInscriptions extends InscriptionsTablesCertificates
{
    //*
    //* function Inscription_PreInscriptions_Link, Parameter list: 
    //*
    //* Creates inscription pre inscriptions info row (no details).
    //*

    function Inscription_PreInscriptions_Link($item)
    {
        $message="PreInscriptions_Link";
        if (!$this->Inscriptions_PreInscriptions_Has())
        {
            return $this->MyLanguage_GetMessage("PreInscriptions_Not_Available_Yet");
        }
        
        if (!$this->Inscriptions_PreInscriptions_Has())
        {
            return $this->MyLanguage_GetMessage("PreInscriptions_Not_Available_Yet");
        }
        

        return $this->Inscription_Type_Link("PreInscriptions",$message);
    }

    //*
    //* function Inscription_PreInscriptions_Row, Parameter list: 
    //*
    //* Creates inscription pre inscripotion info row.
    //*

    function Inscription_PreInscriptions_Rows($item)
    {
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "PreInscriptions",
               $this->Inscription_PreInscriptions_Link($item),
               array("PreInscriptions_StartDate","PreInscriptions_EndDate","PreInscriptions_MustHavePaid",)
            );
    }

    
    //*
    //* function Inscription_PreInscriptions_Table, Parameter list: $edit,$item,$group="PreInsciptions"
    //*
    //* Creates inscrition preincriptions html table.
    //*

    function Inscription_PreInscriptions_Table($edit,$item,$group="PreInsciptions")
    {
        if (!$this->Inscriptions_PreInscriptions_Has()) { return array(); }
        
        $table=$this->Inscription_PreInscriptions_Rows($item);
        $type=$this->InscriptionTablesType($item);
        if ($type!="PreInscriptions")
        {
            return $this->Inscription_PreInscriptions_Rows($item);
        }

        if (!$this->Inscriptions_PreInscriptions_Open($item))
        {
            $edit=0;
        }

        array_push
        (
           $table,
           $this->FrameIt($this->PreInscriptionsObj()->PreInscriptions_Inscription_Form($edit,$item))
        );
            
        return $table;
    }
}

?>