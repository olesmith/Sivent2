<?php



class AssessorsInscriptionAssessmentsForm extends AssessorsInscriptionAssessmentsUpdate
{
    //*
    //* function Assessor_Inscription_Form_Criterias__Data, Parameter list: 
    //*
    //* Returns criterias data to display.
    //*

    function Assessor_Inscription_Form_Criterias_Data()
    {
        return array("No","Weight","Name");
    }

    //*
    //* function Assessors_Inscription_Form_Assessments__Data, Parameter list: 
    //*
    //* Returns criterias data to display.
    //*

    function Assessor_Inscription_Form_Assessments_Data()
    {
        return array("Value","Weighted");
    }

    //*
    //* function Assessors_Inscription_Form_Assessments__Data, Parameter list: 
    //*
    //* Returns criterias data to display.
    //*

    function Assessor_Inscription_Form_Assessed_ID($assessor)
    {
        return "ASSESSED_".$assessor[ "ID" ];
    }

    
    //*
    //* function Assessors_Inscription_Assessments_Form, Parameter list: $edit,$assessor
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessor_Inscription_Assessments_Form($edit,&$assessor)
    {
        $this->CriteriasObj()->ItemData("ID");
        $this->CriteriasObj()->ItemDataGroups("Basic");
        

        $assessments=$this->Assessor_Inscription_Assessments_Read($assessor);        

        $start=$end="";
        if ($edit==1)
        {
            $start=
                $this->StartForm
                (
                    "",
                    "post",
                    FALSE,
                    array
                    (
                        "Anchor" => $this->Assessor_Inscription_Form_Assessed_ID($assessor),
                    )
                );
            $end=
                $this->MakeHidden("Save",1).
                $this->EndForm();

            if ($this->CGI_POSTint("Save")==1)
            {
                $updated=$this->Assessor_Inscription_Assessments_Update($edit,$assessor,$assessments);
            }
        }
        

        return
            $this->FrameIt
            (
               $this->H
               (
                   2,
                   $this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Title"),
                   array
                   (
                       "ID" => $this->Assessor_Inscription_Form_Assessed_ID($assessor)
                   )
               ).
               $start.
               $this->Html_Table
               (
                   $this->Assessor_Inscription_Assessments_Titles(),
                   $this->Assessor_Inscription_Assessments_Table
                   (
                       $edit,
                       $assessor,
                       $assessments
                   )
               ).
               $end
            ).
            "";
    }
}

?>