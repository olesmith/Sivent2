<?php

include_once("Handle/Assessments.php");

class Submissions_Handle extends Submissions_Handle_Assessments
{    
    //*
    //* function Submissions_Handle_Submission, Parameter list: $submission=array()
    //*
    //* Elaborated display of Submission.
    //*

    function Submissions_Handle_Submission($submission=array())
    {
        if (empty($submission)) { $submission=$this->ItemHash; }

        $text=
            $this->Span
            (
               $this->MyMod_Data_Field(0,$submission,"Type").":",
               array("CLASS" => "submissiontext")
            ).
            $this->BR().
            $this->Div
            (
               $this->Span
               (
                  $this->GetRealNameKey($submission,"Name").": ",
                  array("CLASS" => "submissionkey")
               ).
               $this->GetRealNameKey($submission,"Title"),
               array("CLASS" => "submissiontitle")
            ).
            $this->BR().
            $this->Span
            (
               $this->MyLanguage_GetMessage("Submissions_Authors_Title").":",
               array("CLASS" => "submissiontext")
            ).
            $this->BR().
            $this->Div
            (
                join(";".$this->BR(),$this->Submission_Authors_Info($submission)),
                array("CLASS" => "submissionauthors")
            ).
            $this->BR().
            $this->FrameIt
            (
               $this->MyMod_Item_Table_Html
               (
                  0,
                  $submission,
                  array("Status","Name","Area","Type","Level","Keywords","Summary","File"),
                  array("CLASS" => 'submissioninfotable'),
                  array("CLASS" => 'submissioninfotable'),
                  array("CLASS" => 'submissioninfotable')
               ).
               $this->HR().
               $this->Submission_Schedules($submission)
            ).
            "";

        echo $this->FrameIt($text,array("WIDTH" => '80%'));
    }
}

?>