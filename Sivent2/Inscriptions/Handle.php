<?php

include_once("Handle/Menu.php");
include_once("Handle/Friend.php");
include_once("Handle/Inscription.php");
include_once("Handle/Event.php");
include_once("Handle/Submissions.php");
include_once("Handle/Collaborations.php");

class InscriptionsHandle extends Inscriptions_Handle_Collaborations
{
    var $CSS=
        array
        (
            "Leading" => 'group group_leading',
            "Text" => 'group group_text',
            "Table" => 'group group_table',
            "Table_Title" => 'group group_table_title',
            "Table_Rows" => 'group group_table_rows',
            "Table_Cells" => 'group group_table_cells',
            "Table_None" => 'group group_table_none',
        );
    //*
    //* function InscriptionForm, Parameter list: $edit
    //*
    //* Creates Inscription Edit form.
    //*

    function InscriptionForm($edit)
    {
        $this->ReadInscription();
        return
            $this->Htmls_Text
            (
                $this->Htmls_Table
                (
                    "",
                    $this->Inscription_Handle_Form_Tables($edit,$this->Friend,$this->Inscription)
                )
            );
    }
    
     
    //*
    //* function Inscription_Handle_Form_Tables, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Inscription tables:
    //*
    //* Inscription, Submissions, Collaborations 

    //* Payments, Assessments, Caravans.
    //*

    function Inscription_Handle_Form_Tables($edit,$friend,$inscription)
    {
         return
            array
            (
                array
                (
                    $this->Inscription_Handle_Event_Status_Form($edit,$inscription),
                ),
                array
                (
                    $this->Htmls_H
                    (
                        1,
                        $this->Messages("Friend_Table_Title")
                    ),
                ),
                array
                (
                    $this->Inscription_Handle_Menu($edit)
                ),
                 array
                (
                    $this->Inscription_Handle_Friend_Form($edit,$friend,$inscription),
                ),
                array
                (
                    $this->Inscription_Handle_Inscription_Form($edit,$friend,$inscription),
                ),
                $this->Htmls_List
                (
                    array
                    (
                        $this->Inscription_Handle_Submissions_Html($edit,$friend,$inscription),
                        $this->Inscription_Handle_Collaborations_Form($edit,$friend,$inscription),
                    )
                ),
                array
                (
                    $this->Inscription_Event_Typed_Tables($edit,$friend,$inscription),
                ),
            );
    }
 }

?>