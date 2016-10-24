<?php

class PreInscriptionsSubmissions extends PreInscriptionsAccess
{
    //*
    //* function PreInscriptions_Submission_Read, Parameter list: $submission
    //*
    //* Reads Schedule Preinscription registration.
    //*

    function PreInscriptions_Submission_Read($submission,$datas=array())
    {
        if (empty($datas)) $datas=array("ID","Friend","Submission","Schedule");
        return $this->Sql_Select_Hashes(array("Submission" => $submission[ "ID" ]),$datas);
    }

    
    //*
    //* function PreInscriptions_Show, Parameter list: $items
    //*
    //* Reads Schedule Preinscription registration.
    //*

    function PreInscriptions_Show($items,$datas=array())
    {
        if (empty($datas)) $datas=array("ID","Friend","Submission","Schedule");

        if (empty($items))
        {
            return $this->H(2,$this->MyLanguage_GetMessage("Items_None_Found"));
        }
        
        $datas[0]="No";
        return
            $this->H(2,$this->MyLanguage_GetMessage("PreInscriptions_Submission_Table_Title")).
            $this->MyMod_Items_Table_Html
            (
               0,
               $items,
               $datas
             );
    }
}

?>