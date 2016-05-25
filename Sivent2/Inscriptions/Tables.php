<?php

class InscriptionsTables extends InscriptionsRead
{
    //*
    //* function InscriptionTable, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionTable($edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE)
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }

        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $this->SGroups_NumberItems=FALSE;

        $table=$this->MyMod_Item_Group_Tables
        (
           $this->InscriptionSGroups($edit),
           $inscription,
           $buttons
        );

        //array_unshift($table,$this->InscriptionMessageRow($inscription));

        array_unshift($table,$this->InscriptionDiagList($inscription));

        if (empty($inscription[ "ID" ]) && $edit==1 && $buttons)
        {
            $title="";
            if (!empty($inscription[ "ID" ]))
            {
                $title=$this->MyLanguage_GetMessage("Inscription_Button_Inscribed");
            }
            else
            {
                $title=$this->MyLanguage_GetMessage("Inscription_Button_Inscribe");
            }
            
            array_push($table,$this->Button("submit",$title));
        }

        if (!empty($inscription[ "ID" ]))
        {
            array_push
            (
               $table,
               $this->HR().
               $this->InscriptionEventMenu($inscription),
               array($this->Inscription_Event_Type_Table(1,$inscription)),
               $this->HR(),
               array($this->Inscription_Event_Types_Table(0,$inscription))
            );
        }

        return $table;
    }
    
    //*
    //* function Inscription_Event_Type_Table, Parameter list: $edit
    //*
    //* Creates Inscription event Type table: Certificates, Collaborations, Caravans and Submissions.
    //* Dispatcher.
    //*

    function Inscription_Event_Type_Table($edit,$inscription)
    {
        $type=$this->CGI_GETOrPOST("Type");

        $html="";
        if ($type=="Collaboration" && $this->Inscriptions_Collaborations_Has())
        {
            if (!$this->Inscriptions_Collaborations_Inscriptions_Open()) { $edit=0; }

            $html=$this->Inscription_Collaborations_Table($edit,$inscription);
        }
        elseif ($type=="Caravan" && $this->Inscriptions_Caravans_Has())
        {
            if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }
            
            $html=$this->Inscription_Caravans_Table($edit,$inscription);
        }
        elseif ($type=="Submission" && $this->Inscriptions_Submissions_Has())
        {
            if (!$this->Inscriptions_Submissions_Inscriptions_Open()) { $edit=0; }
            
            $html=$this->Inscription_Submissions_Table($edit,$inscription);
        }
        elseif ($type=="Certificate" && $this->Inscriptions_Certificates_Published())
        {
            $html=$this->Inscription_Certificate_Table($edit,$inscription);
        }

        return $html;
    }
    
    //*
    //* function Inscription_Event_Types_Table, Parameter list: $edit
    //*
    //* Creates table listing fo inscriptions for submissions, collaborations and caravans.
    //*

    function Inscription_Event_Types_Table($edit,$inscription)
    {
        $type=$this->CGI_Get("Type");
        $html="";

        if ($type!="Collaboration")
        {
            $html.=$this->Inscription_Event_Collaborations_Table($edit,$inscription);
        }
        
        if ($type!="Submission")
        {
            $html.=$this->Inscription_Event_Submissions_Table($edit,$inscription);
        }
        
        if ($type!="Caravan")
        {
            $html.=$this->Inscription_Event_Caravans_Table($edit,$inscription);
        }

        return $html;
    }
    
    
    
    //*
    //* function InscriptionEventTable, Parameter list: $edit
    //*
    //* Creates Inscription event data table
    //*

    function InscriptionEventTable($edit)
    {
        return "";
        $table=parent::InscriptionEventTable($edit);
        
        return $this->InscriptionEventLogosAdd($table);
    }

    
    //*
    //* function InscriptionEventMenu, Parameter list: 
    //*
    //* Creates Inscription event data menu, offering links
    //* to Collaborations, Caravans, Submissions, etc.
    //*

    function InscriptionEventMenu($inscription)
    {
        $actions=$this->MyActions_AddFile("System/Inscriptions/Actions.Inscription.php");

        if (empty($inscription[ "ID" ])) { return ""; }
        
        return
            $this->Anchor("Menu").
            $this->MyMod_HorMenu_Action
            (
               $actions,
               "ptablemenu",
               $inscription[ "ID" ],
               $inscription
            ).
            "";
    }
        
}

?>