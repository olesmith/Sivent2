<?php


class Inscriptions_Handle_Inscription extends Inscriptions_Handle_Friend
{
    //*
    //* function Inscription_Handle_Form_Show, Parameter list: 
    //*
    //* Detects whether to edit friend data form.
    //*

    function Inscription_Handle_Inscription_Form_Show($show=False)
    {
        $subaction=$this->CGI_GET("SubAction");

        if (preg_match('/(Inscription|Start)/',$subaction))
        {
            $show=True;
        }

        $show=$show && $this->EventsObj()->Event_Inscriptions_Show_Should();
        
        return $show;
    }
    
    //*
    //* function Inscription_Handle_Form_Edit, Parameter list: 
    //*
    //* Detects whether to edit inscription data form.
    //*

    function Inscription_Handle_Inscription_Form_Edit($edit)
    {
        $edit=$this->Inscription_Handle_Inscription_Form_Show($edit);
        $edit=$edit && $this->EventsObj()->Event_Inscriptions_Edit_May();
        
        return $edit;
    }

    //*
    //* function Inscription_Handle_Inscription_Form, Parameter list: $edit
    //*
    //* Creates Inscription Edit form. Should run first.
    //*

    function Inscription_Handle_Inscription_Form($edit,$friend,$inscription)
    {
        if ($this->Inscription_Handle_Inscription_Form_Show($edit)==0) { return array(); }
        
        $args=$this->CGI_URI2Hash();

        $edit=$this->Inscription_Handle_Inscription_Form_Edit($edit);

        #Must run first (update)
        return array(
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
                  "Item"   => $inscription,

                  #"ReadMethod" => "ReadInscription",
                  "UpdateMethod" => "UpdateInscription",
                  "ContentsHtml" => "",
                  "ContentsLatex" => "",

                  "UpdateCGIVar" => "Update",
                  "UpdateCGIValue" => 1,
               )
            )
        );
    }
    
}

?>