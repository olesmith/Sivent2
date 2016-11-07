<?php



class AssessorsInscriptionAssessmentsForm extends AssessorsInscriptionAssessmentsUpdate
{
    //*
    //* function Assessors_Inscription_Assessments_Form, Parameter list: $edit,$assessor
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessors_Inscription_Assessments_Form($edit,&$assessor)
    {
        $this->CriteriasObj()->ItemData("ID");
        $this->CriteriasObj()->ItemDataGroups("Basic");
        
        $criteriadatas=array("No","Weight","Name");
        $assessmentdatas=array("Value");

        $criterias=$this->CriteriasObj()->Criterias_Read();
        $assessments=$this->Assessors_Inscription_Assessments_Read($assessor);        

        $start=$end="";
        if ($edit==1)
        {
            $start=$this->StartForm("","post",FALSE,array("Anchor" => "ASSESSED_".$assessor[ "ID" ]));
            $end=
                $this->MakeHidden("Save",1).
                $this->EndForm();

            if ($this->CGI_POSTint("Save")==1)
            {
                $updated=$this->Assessors_Inscription_Assessments_Update($edit,$assessor,$criterias,$assessments);
            }
        }
        

        return
            $this->Anchor("ASSESSED_".$assessor[ "ID" ]).
            $this->FrameIt
            (
               $this->H(2,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Title")).
               $start.
               $this->Html_Table
               (
                  $this->Assessors_Inscription_Assessments_Titles
                  (
                     $criteriadatas,
                     $assessmentdatas
                  ),
                  $this->Assessors_Inscription_Assessments_Table
                  (
                     $edit,
                     $assessor,
                     $criterias,
                     $assessments,
                     $criteriadatas,
                     $assessmentdatas
                  )
               ).
               $end
            ).
            "";
    }
}

?>