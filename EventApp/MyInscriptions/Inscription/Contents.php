<?php

class MyInscriptionsInscriptionContents extends MyInscriptionsInscriptionUpdate
{
    //*
    //* function InscriptionContents, Parameter list: $edit,$buttons=TRUE
    //*
    //* Creates Inscription edit table as html.
    //*

    function InscriptionContents($edit,$buttons=TRUE)
    {
        $open=TRUE;
        if ($this->ApplicationObj->Event("EditDate")<$this->TimeStamp2DateSort())
        {
            $open=FALSE;
            $edit=0;
        }
        
        $date=$this->EventsObj()->MyMod_Data_Fields(0,$this->Event(),"EditDate");

        $title1=$this->Messages("Contents__Title_Main");
        $title2=
            $this->Messages("Contents__Title_Editable_Until").
            ": ".
            $date;
        
        if ($edit==0)
        {
            $title2=
                $this->Messages("Contents__Title_UnEditable_Since").
                " ".$date; 
        }

        $table=
            array_merge
            (
               $this->InscriptionFriendTable(0,$this->Friend),
               $this->InscriptionTable
               (
                  $edit,
                  $buttons,
                  $this->Inscription,
                  TRUE
               )
             );
        
        
        return
            $this->Anchor("TOP").
            $this->FrameIt
            (
               $this->Html_Table("",$table)
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
       
        return
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
    }
}

?>