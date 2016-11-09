<?php


include_once("Tables/Speaker.php");
include_once("Tables/Schedules.php");
include_once("Tables/Submissions.php");
include_once("Tables/Assessments.php");
include_once("Tables/Collaborations.php");
include_once("Tables/Caravans.php");
include_once("Tables/Certificates.php");
include_once("Tables/PreInscriptions.php");


class InscriptionsTables extends InscriptionsTablesPreInscriptions
{
    //*
    //* function InscriptionSGroupsTable, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionSGroupsTable($edit,$inscription)
    {
        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $this->SGroups_NumberItems=FALSE;
        unset($this->ItemDataSGroups[ "Submissions" ]);
        
        return
            $this->MyMod_Item_Group_Tables_Form
            (
               $edit,
               "Update",
               $this->MyMod_Item_SGroups($edit),
               $inscription,
               FALSE,  //mayupdate, done elsewhere
               FALSE, //plural
               "",
               $buttons
            ).
            "";
    }
    
    //*
    //* function Inscription_Event_Info, Parameter list: 
    //*
    //* Returns event info.
    //*

    function Inscription_Event_Info()
    {
        $eventmessage=$this->EventsObj()->Event_Inscriptions_Info();
        if (!empty($eventmessage))
        {
            $eventmessage=$this->FrameIt($eventmessage);
        }
        
        return $eventmessage;
    }
    
    //*
    //* function InscriptionTable, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionTable($edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE)
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }

        $buttons="";
        if ($edit==1 && !empty($inscription[ "ID" ])) { $buttons=$this->Buttons(); }
        
        $this->SGroups_NumberItems=FALSE;

        $table=array($this->InscriptionSGroupsTable($edit,$inscription));
        

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

        array_unshift($table,$this->InscriptionDiagList($inscription));

        array_push
        (
           $table,
           $this->Anchor("TABLE").
           $this->Inscription_Event_Info()
        );
        
        /* if (!empty($inscription[ "ID" ])) */
        /* { */
        /*     array_push */
        /*     ( */
        /*        $table, */
        /*        $this->Inscription_Event_Typed_Tables($edit,$inscription) */
        /*     ); */
        /* } */

        return $table;
    }
    
    //*
    //* function GetTablesType, Parameter list: $friend
    //*
    //* Detects tables type from CGI.
    //*

    function GetTablesType()
    {
        return $this->CGI_GET("Type");
    }

    
     //*
    //* function InscriptionTablesType, Parameter list: $inscription
    //*
    //* Detects tables type from CGI.
    //*

    function InscriptionTablesType($inscription=array())
    {
        $type=$this->CGI_GET("Type");
        if (empty($type))
        {
            /* $speaker= */
            /*     $this->SpeakersObj()->Sql_Select_Hash */
            /*     ( */
            /*        $this->UnitEventWhere(array("Friend" => $inscription[ "Friend" ])), */
            /*        array("ID") */
            /*     ); */
            
            /* if (!empty($speaker)) */
            /* { */
            /*     $type="Speaker"; */
            /* } */
            /* else */
            /* { */
            /*     if ($this->Inscriptions_PreInscriptions_Has()) */
            /*     { */
            /*         $type="PreInscriptions"; */
            /*     } */
            /* } */
        }

        return $type;
    }
    
    //*
    //* function Inscription_Event_Typed_Tables, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Event typed tables:
    //*
    //* Caravanas
    //* Collaborations
    //* Submissions
    //* Speakers Data
    //* Schedule info
    //* PreInscriptions info
    //*
    //* Todo:
    //* Presences info
    //* Assessments info
    //*

    function Inscription_Event_Typed_Tables($edit,$friend,$inscription)
    {
        $tables=array();
        if (!empty($inscription))
        {
            $tables=
                array_merge
                (
                    $tables,
                    $this->Inscription_PreInscriptions_Table($edit,$inscription)
                );
        }
        
        $tables=
            array_merge
            (
                $tables,
                $this->Friend_Certificate_Table(0,$friend,$inscription),
                $this->Friend_Speaker_Tables($edit,$friend,$inscription),
                $this->Friend_Assessors_Table($edit,$friend,$inscription),
                $this->Friend_Submissions_Table($edit,$friend,$inscription),
                $this->Friend_Collaborations_Table($edit,$friend,$inscription),
                $this->Friend_Caravans_Table_Form($edit,$friend,$inscription)         
            );
            
        if (!empty($tables))
        {
            return $this->Html_Table("",$tables);
        }

        return "";
    }

    
    //*
    //* function Inscription_Type_Link, Parameter list: $type,$message,$achor="TABLE"
    //*
    //* Returns typed link: Speaker, Collaborators, etc.
    //*

    function Inscription_Type_Link($type,$message,$achor="TABLE")
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Type" ]=$type;
        
        return
            $this->Href
            (
               "?".$this->CGI_Hash2URI($args),
               $this->MyLanguage_GetMessage($message),
               $title="",$target="",$class="",$noqueryargs=FALSE,$options=array(),$anchor="TABLE"
            );
    }


    //*
    //* function Inscription_Type_Rows, Parameter list: $type,$eventdatas=array(),$inscrdatas=array()
    //*
    //* Returns typed link: Speaker, Collaborators, etc.
    //*

    function Inscription_Type_Rows($inscription,$type,$link,$eventdatas=array(),$inscrdatas=array())
    {
        $titles=
            array_merge
            (
               $this->EventsObj()->GetDataTitles($eventdatas),
               $this->GetDataTitles($inscrdatas),
               array("")
            );

        $link=$this->DIV($link,array("CLASS" => 'right'));

        $row=
            array_merge
            (
               $this->EventsObj()->MyMod_Item_Row(0,$this->Event(),$eventdatas),
               $this->MyMod_Item_Row(0,$inscription,$inscrdatas),
               array($link)
            );
                
        return
            array
            (
               $this->B($titles),
               $row
            );
    }
}

?>