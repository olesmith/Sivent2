<?php


class AssessorsInscriptionAssessorsRows extends AssessorsInscriptionAssessorsRead
{
    //*
    //* function Assessors_Inscription_Assessors_Table_Titles, Parameter list: $datas,$submissiondatas
    //*
    //* Creates table with $inscription assessor assessments..
    //*

    function Assessors_Inscription_Assessors_Table_Titles($datas,$frienddatas,$submissiondatas)
    {
        return
            array_merge
            (
                array($this->B("No")),
                $this->FriendsObj()->GetDataTitles($frienddatas),
                $this->SubmissionsObj()->GetDataTitles($submissiondatas),
                $this->GetDataTitles($datas),
                array("")
            );
    }
    
    //*
    //* function Assessors_Inscription_Assessor_Row, Parameter list: $edit,$friend,$assessor,$datas,$frienddatas,$submissiondatas
    //*
    //* Creates row with $inscription $assessor, friend and submissiondata.
    //*

    function Assessors_Friend_Assessor_Row($edit,$n,$friend,$assessor,$datas,$frienddatas,$submissiondatas)
    {
        $assessor[ "Result" ]=$this->Sql_Select_Hash_Value($assessor[ "ID" ],"Result");
        
        return
            array_merge
            (
                array($n),
                $this->FriendsObj()->MyMod_Items_Table_Row
                (
                    0,
                    $n,
                    $assessor[ "Friend_Hash" ],
                    $frienddatas,
                    TRUE
                ),
                $this->SubmissionsObj()->MyMod_Items_Table_Row
                (
                    0,
                    $n,
                    $assessor[ "Submission_Hash" ],
                    $submissiondatas,
                    TRUE
                ),
                $this->MyMod_Items_Table_Row
                (
                    0,
                    $n,
                    $assessor,
                    $datas,
                    TRUE
                ),
                array
                (
                    $this->Assessors_Inscription_Assessment_Link($assessor).
                    $this->Anchor("ASSESS_".$assessor[ "ID" ])
                )
            );
    }
}

?>