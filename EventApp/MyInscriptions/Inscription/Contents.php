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
        $this->InscriptionsObj()->Sql_Table_Structure_Update_Force=TRUE; //force update
        $this->Sql_Table_Structure_Update();
        $method=$this->TableMethod();

        return
            $this->Anchor("TOP").
            $this->FrameIt
            (
               $this->$method
               (
                  "",
                  $this->InscriptionTable
                  (
                     $edit,
                     $buttons,
                     $this->Inscription,
                     TRUE
                  )
               )
            ).
            "";
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
        
        $html=
            $this->Form_Run
            (
               array
               (
                  "Name"       => "Name-me...",

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
            "";

        return $this->FrameIt
        (
            $this->InscriptionFriendForm(1,$this->Friend,$this->Inscription).
            $this->Inscription_Event_Typed_Tables($edit,$this->Friend,$this->Inscription).
            $html.
            ""
        );
    }
}

?>