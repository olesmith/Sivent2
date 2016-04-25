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
        
        $this->SGroups_NumberItems=TRUE;

        $table=$this->MyMod_Item_Group_Tables
        (
           $this->InscriptionSGroups($edit),
           $inscription,
           $buttons
        );

        array_unshift($table,$this->InscriptionDiagList($inscription));
        array_unshift($table,$this->InscriptionMessageRow($inscription));

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

        array_push
        (
           $table,
           $this->InscriptionEventMenu($inscription),
           array($this->Inscription_Event_Type_Table($edit,$inscription))
        );

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
            
            $html=$this->Inscription_Submissions_Table(0,$inscription);
        }
        elseif ($type=="Certificate" && $this->Inscriptions_Certificates_Published())
        {
            $html=$this->Inscription_Certificate_Table($edit,$inscription);
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
        $table=parent::InscriptionEventTable($edit);

        $icon1=$this->Event("HtmlIcon1");
        $icon2=$this->Event("HtmlIcon2");

        $height=$this->Event("HtmlLogoHeight");
        $width=$this->Event("HtmlLogoWidth");

        $icons=array();
        if (!empty($icon1)) { array_push($icons,$this->Img($icon1,"event logo",$height,$width)); }
        if (!empty($icon2)) { array_push($icons,$this->Img($icon2,"event logo",$height,$width)); }

        $toptions=array("CLASS" => 'eventicons',"ALIGN" => 'center');
        $troptions=array("CLASS" => 'eventicons');
        $tdoptions=array("CLASS" => 'eventicons');
        
        if (count($icons)==2)
        {
            return
                $this->Html_Table
                (
                   "",
                   array(array(array_shift($icons),$table,array_shift($icons))),
                   $toptions,
                   $troptions,
                   $tdoptions,
                   FALSE
                );
        }
        elseif (count($icons)==1)
        {
            return
                $this->Html_Table
                (
                   "",
                   array(array(array_shift($icons)),array($table)),
                   $toptions,
                   $troptions,
                   $tdoptions,
                   FALSE
                );
        }
        else
        {
            return $table;
        }
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

        return
            $this->MyMod_HorMenu_Action
            (
               $actions,
               "ptablemenu",
               $inscription[ "ID" ],
               $inscription
            );
    }
}

?>