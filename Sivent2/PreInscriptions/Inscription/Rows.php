<?php

class PreInscriptionsInscriptionRows extends PreInscriptionsInscriptionCells
{
    //*
    //* function PreInscriptions_Inscription_Submission_Titles, Parameter list:
    //*
    //* Creates preinscriptions table titlerow.
    //*

    function PreInscriptions_Inscription_Submission_Titles()
    {
        $titles=$this->SubmissionsObj()->GetDataTitles($this->PreInscriptions_Submissions_Show_Datas());
        array_push($titles,$this->PreInscriptions_Inscription_Submission_PreInscribe_Cell(0,array()));
        
        return array("CLASS" => 'head',"Row" => $titles);
    }
    
    //*
    //* function PreInscriptions_Inscription_Submission_Row, Parameter list: $inscription,$submission,$sdatas
    //*
    //* Creates first row with submission data - and cell for preinscription.
    //*

    function PreInscriptions_Inscription_Submission_Row($edit,$inscription,$submission)
    {
        $row=
            $this->SubmissionsObj()->MyMod_Item_Row
            (
               0,
               $submission,
               $this->PreInscriptions_Submissions_Show_Datas()
            );
        
        array_push
        (
           $row,
           $this->PreInscriptions_Inscription_Submission_PreInscribe_Cell($edit,$inscription,$submission)
        );

        return $row;
    }
    
}

?>