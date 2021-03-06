<?php

include_once("Handle/Assessments.php");

class Submissions_Handle extends Submissions_Handle_Assessments
{    
    //*
    //* function MyMod_Handle_Show_Assessors, Parameter list: $submission
    //*
    //* Shows $submission assessments.
    //*

    function MyMod_Handle_Show_Assessors($submission)
    {
        if (!preg_match('/(Coordinator|Admin)/',$this->Profile()))
        {
            return "";
        }
        $this->AssessorsObj()->ItemData("ID");
        $this->AssessorsObj()->ItemDataGroups("Assessments");
        $this->AssessorsObj()->Actions("Show");

        $datas=$this->AssessorsObj()->MyMod_Data_Group_Datas_Get("Assessments");
        
        return 
            $this->Html_Table
            (
                $this->AssessorsObj()->MyMod_Data_Titles($datas),
                $this->Submission_Assessors_Table
                (
                    1,
                    1,
                    $datas,
                    $submission
                )
            );
    }
    
    //*
    //* function MyMod_Handle_Show, Parameter list: $title=""
    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Show($title="")
    {
        parent::MyMod_Handle_Show($title);

        echo
            $this->MyMod_Handle_Show_Assessors($this->ItemHash);
        
    }

     //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        parent::MyMod_Handle_Edit($echo,$formurl,$title,$noupdate);
           
        echo
            $this->MyMod_Handle_Show_Assessors($this->ItemHash);
    }

    
    //*
    //* function Submissions_Handle_Submission, Parameter list: $submission=array()
    //*
    //* Elaborated display of Submission.
    //*

    function Submissions_Handle_Submission($submission=array())
    {
        if (empty($submission)) { $submission=$this->ItemHash; }

        echo $this->Htmls_Text
        (
            array
            (
                $this->Htmls_SPAN
                (
                    $this->MyMod_Data_Field_Text(0,$submission,"Type").":",
                    array("CLASS" => "submissiontext")
                ),
                $this->BR(),
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->Htmls_SPAN
                        (
                            $this->GetRealNameKey($submission,"Name"),
                            array("CLASS" => "submissionkey")
                        ),
                        $this->GetRealNameKey($submission,"Title")
                    ),
                    array("CLASS" => "submissiontitle")
                ),
                $this->BR(),
                $this->Htmls_SPAN
                (
                    $this->MyLanguage_GetMessage("Submissions_Authors_Title"),
                    array("CLASS" => "submissiontext")
                ),
                $this->BR(),
                $this->Htmls_DIV
                (
                    join(";".$this->BR(),$this->Submission_Authors($submission)),
                    array("CLASS" => "submissionauthors")
                ),
                $this->BR(),
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyMod_Item_Table_Html
                        (
                            0,
                            $submission,
                            array("Status","Name","Area","Type","Level","Keywords","Summary","File"),
                            array("CLASS" => 'submissioninfotable'),
                            array("CLASS" => 'submissioninfotable'),
                            array("CLASS" => 'submissioninfotable')
                        ),
                        $this->HR(),
                        $this->Submission_Schedules($submission).
                        $this->BR(),
                        $this->Htmls_DIV
                        (
                            $this->H(4,$this->MyLanguage_GetMessage("Submissions_Authors_Details_Title")).
                            $this->Submission_Authors_Info_Tables($submission),
                            array("CLASS" => "submissionauthors")
                        )
                    ),
                    array("CLASS" => 'submissioninfotable')
                ),
            )
        );
    }
}

?>