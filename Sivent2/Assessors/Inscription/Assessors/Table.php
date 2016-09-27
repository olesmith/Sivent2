<?php


class AssessorsInscriptionAssessorsTable extends AssessorsInscriptionAssessorsRows
{
    //*
    //* function Assessors_Inscription_Assessors_Table, Parameter list: $edit,$inscription,$assessors,$datas,$frienddatas,$submissiondatas
    //*
    //* Creates table (matrix) with $inscription assessor, friend and submissiondata.
    //*

    function Assessors_Inscription_Assessors_Table($edit,$inscription,$assessors,$datas,$frienddatas,$submissiondatas)
    {
        $table=array();
        $n=1;
        foreach ($assessors as $assessor)
        {
            array_push
            (
               $table,
               $this->Assessors_Inscription_Assessor_Row($edit,$n++,$inscription,$assessor,$datas,$frienddatas,$submissiondatas)
            );
        }

        return $table;
    }

    

    
    //*
    //* function Assessors_Inscription_Table_Html, Parameter list: $edit,$inscription
    //*
    //* Creates table with $inscription assessor assessments..
    //*

    function Assessors_Inscription_Table_Html($edit,$inscription)
    {
        $assessors=$this->Assessors_Inscription_Assessors_Read($edit,$inscription);

        $datas=array("No","Submission","HasAssessed","Result");
        $frienddatas=array("Name");
        $submissiondatas=array("Area","Level");

        //Must do first for imediate update to work.
        $details=$this->Assessors_Inscription_Assessors_Form($edit,$inscription,$assessors);

        $table=$this->Assessors_Inscription_Assessors_Table($edit,$inscription,$assessors,$datas,$frienddatas,$submissiondatas);

        if (empty($table)) { return array(); }
        
        return
            array
            (
               $this->FrameIt
               (
                  $this->H(2,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Table_Title")).
                  $this->Html_Table
                  (
                     $this->Assessors_Inscription_Assessors_Table_Titles($datas,$frienddatas,$submissiondatas),
                     $table
                  ).
                  $details.
                  ""
                  )
            );    
    }
    
}

?>