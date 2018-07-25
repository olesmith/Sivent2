<?php

class MyInscriptions_Inscription_Contents extends MyInscriptions_Inscription_Update
{
    //*
    //* function InscriptionContents, Parameter list: $edit,$buttons=TRUE
    //*
    //* Creates Inscription edit table as html.
    //*

    function InscriptionContents($edit,$buttons=TRUE)
    {
        $this->Sql_Table_Structure_Update_Force=TRUE; //force update
        $this->Sql_Table_Structure_Update();
        ##$method=$this->TableMethod();
        
        return
            $this->Htmls_Table
            (
                "",
                $this->InscriptionTable
                (
                    $this->InscriptionFormEdit($edit),
                    $buttons,
                    $this->Inscription,
                    TRUE
                )
            );
    }

    //*
    //* function InscriptionFormEdit, Parameter list: $edit
    //*
    //* Checks whether inscription form is editable.
    //*

    function InscriptionFormEdit($edit)
    {
        //Prevent edit, if Event EditDate surpassed.
        if ($this->Event("EditDate")<$this->MyTime_2Sort()) { $edit=0; }

        if ($this->LatexMode()) { $edit=0; }

        return $edit;
    }

    
    
    //*
    //* function InscriptionForm, Parameter list: $edit
    //*
    //* Creates Inscription Edit form.
    //*

    function InscriptionForm($edit)
    {
        $args=$this->CGI_URI2Hash();

        $edit=$this->InscriptionFormEdit($edit);

        #Must run first (update)
        $html= "111".
            $this->Form_Run
            (
               array
               (
                  "Name"       => "InscriptionForm",

                  "Action"     => $this->CGI_Hash2URI($this->CGI_URI2Hash()),

                  "Anchor"     => "INSCR",
                  "Uploads" => TRUE,
                  "CGIGETVars" => array(),
                  "CGIPOSTVars" => array(),

                  "Contents"   => "InscriptionContents",
                  "Options"    => array(),
                  "StartButtons"   => "",
                  "EndButtons"   => "",
                  "Buttons"   => "",
                  "Hiddens"   => array(),

                  "Edit"   => $edit,
                  "Update" => $edit,

                  "ReadMethod" => "ReadInscription",
                  "UpdateMethod" => "UpdateInscription",
                  "ContentsHtml" => "",
                  "ContentsLatex" => "",

                  "UpdateCGIVar" => "Update",
                  "UpdateCGIValue" => 1,
               )
            ).
            "2222";

        return $this->FrameIt
        (
            $this->InscriptionFriendForm(1,$this->Friend,$this->Inscription).
            $html.
            $this->Inscription_Event_Typed_Tables($edit,$this->Friend,$this->Inscription).
            ""
        );
    }
}

?>