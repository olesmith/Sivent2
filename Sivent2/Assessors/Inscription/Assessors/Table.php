<?php


class AssessorsInscriptionAssessorsTable extends AssessorsInscriptionAssessorsRows
{
    //*
    //* function Assessors_Inscription_Assessors_Table, Parameter list: $edit,$inscription,$assessors,$datas,$frienddatas,$submissiondatas
    //*
    //* Creates table (matrix) with $inscription assessor, friend and submissiondata.
    //*

    function Assessors_Friend_Assessors_Table($edit,$friend,$assessors,$datas,$frienddatas,$submissiondatas)
    {
        $cassessor=$this->CGI_GETint("Assessor");
        
        //Must do first for imediate update to work.
        $details=
            $this->Assessors_Friend_Assessors_Form($edit,$friend,$assessors);
        
        $table=array();
        $n=1;
        foreach ($assessors as $assessor)
        {
            array_push
            (
               $table,
               $this->Assessors_Friend_Assessor_Row($edit,$n++,$friend,$assessor,$datas,$frienddatas,$submissiondatas)
            );

            if ($assessor[ "ID" ]==$cassessor)
            {
                array_push($table,array("",$details));
            }
        }

        return $table;
    }

    

    
    //*
    //* function Assessors_Friend_Table_Html, Parameter list: $edit,$friend
    //*
    //* Creates table with $friend assessor assessments.
    //*

    function Assessors_Friend_Table_Html($edit,$friend)
    {
        $assessors=$this->Assessors_Friend_Assessors_Read($edit,$friend);

        $datas=array("HasAssessed","Result");
        $frienddatas=array();

        
        $submissiondatas=array("Title","Author1","Area","Level");

        $table=
            $this->Assessors_Friend_Assessors_Table
            (
                $edit,
                $friend,
                $assessors,
                $datas,
                $frienddatas,
                $submissiondatas
            );

        if (empty($table)) { return array(); }
        
        return
            array
            (
               $this->FrameIt
               (
                   $this->Assessors_Inscription_Assessors_Menu().
                   $this->H(2,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Table_Title")).
                   $this->Html_Table
                   (
                       $this->Assessors_Inscription_Assessors_Table_Titles($datas,$frienddatas,$submissiondatas),
                       $table
                   ).
                   ""
               )
            );   
    }
    
}

?>