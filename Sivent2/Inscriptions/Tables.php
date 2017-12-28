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
        if (empty($inscription) && !$this->EventsObj()->Events_Open_Is()) { return ""; }
        
        if (!empty($this->ItemDataSGroups[ "Payments" ]) && is_array($this->ItemDataSGroups[ "Payments" ]))
        {
            $this->ItemDataSGroups[ "Payments" ][ "Visible" ]=FALSE;
        }

        $button_title="Inscription_Button_Inscribed";
        if (empty($inscription))
        {
            $button_title="Inscription_Button_Inscribe";
        }

        $buttons="";
        if ($edit==1)
        {
            $buttons=$this->Buttons
            (
                $this->MyLanguage_GetMessage($button_title)
            );
        }
        
        $this->SGroups_NumberItems=FALSE;
        unset($this->ItemDataSGroups[ "Submissions" ]);

        $sgroups=$this->MyMod_Item_SGroups($edit);

        $html="";
        if (count($sgroups)==1 && count($sgroups[0])==0 && $this->EventsObj()->Events_Open_Is())
        {
            $html=$buttons;
        }
        
        return
            $html.
            $this->MyMod_Item_Group_Tables_Html
            (
               $edit,
               $sgroups,
               $inscription,
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
    //* function Inscription_Event_Info_Row, Parameter list:
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function Inscription_Event_Info_Row($inscription)
    {
        $row=
            array
            (
                $this->Anchor("TABLE").
                $this->InscriptionDiagList($inscription),
            );
        $info=$this->Event("Info");

        if (!empty($info))
        {
            array_push
            (
                $row,
                array
                (
                    "Text" => $this->FriendsObj()->Friend_Event_Info_Cell($this->Event()),
                    "Options" => array
                    (
                        "WIDTH" => "50%",
                    )
                )   
            );
        }

        return $row;
    }

    //*
    //* function Inscription_Event_Payments_Row, Parameter list:
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function Inscription_Event_Payments_Row($inscription)
    {
        $this->ItemDataSGroups[ "Payments" ][ "Visible" ]=FALSE;

        return
            array
            (
                $this->FriendsObj()->Friend_Event_Payments_Cell($this->Event()),
                $this->MyMod_Item_Group_Table_HTML(1,"Payments",$inscription)
            );
    }

    //*
    //* function Inscription_Status_Get, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Returns $inscription status: inscribed or not.
    //*

    function Inscription_Status_Get($inscription)
    {
        $status="";
        if (!empty($inscription[ "ID" ]))
        {
            $status=$this->MyLanguage_GetMessage("Inscription_Inscribed");
        }
        else
        {
            $status=$this->MyLanguage_GetMessage("Inscription_Not_Inscribed");
        }

        return $status;
    }
    
    //*
    //* function Inscription_Status_Row, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates $inscription status row.
    //*

    function Inscription_Status_Row($edit,$inscription)
    {
        return
            array
            (
                $this->B($this->MyLanguage_GetMessage("Friend_Data_Status_Title").":"),
                $this->Inscription_Status_Get($inscription)
            );
    }
    

    //*
    //* function Inscription_Event_Status_Row, Parameter list: 
    //*
    //* Creates $inscription status row.
    //*

    function Inscription_Event_Status_Rows($edit,$inscription)
    {
        $event=$this->Event();
        return
            array
            (
                array
                (
                    $this->H
                    (
                        5,
                        $this->EventsObj()->MyMod_Data_Fields_Show("Name",$event).
                        "<P>".
                        $this->EventsObj()->Event_Date_Span($event)
                    ),
                        
                ),
                array
                (
                    $this->B($this->MyLanguage_GetMessage("Events_Inscriptions_Status_Title").":"),
                    $this->EventsObj()->Events_Status_Cell($event),
                ),
                array
                (
                    $this->B($this->EventsObj()->Event_Inscriptions_Date_Span().":"),
                    $this->EventsObj()->Event_Inscriptions_Date_Span($event),
                ),
                array
                (
                    $this->B($this->EventsObj()->Event_Inscriptions_Editable_Date().":"),
                    $this->EventsObj()->Event_Inscriptions_Editable_Date($event),
                ),
            );
    }
    
    //* function Inscription_Created_Row, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates $inscription status row.
    //*

    function Inscription_Status_Created_Row($edit,$inscription)
    {
        return
            array
            (
                $this->B($this->MyLanguage_GetMessage("Inscription_Create_Title").":"),
                $this->MyMod_Data_Fields_Show("CTime",$inscription)
            );
    }
    
    //*
    //* function Inscription_Status_Table, Parameter list: $edit,$inscription
    //* Creates $inscription event table.
    //*

    function Inscription_Event_Rows($edit,$inscription)
    {
        $table=array();
        $table=array_merge
        (
            $table,
            $this->Inscription_Event_Status_Rows($edit,$inscription)
        );
        
        return $table;
    }
 
    //*
    //* function Inscription_Status_Table, Parameter list: $edit,$inscription
    //* Creates $inscription status table.
    //*

    function Inscription_Status_Table($edit,$inscription)
    {
        $table=array();
        $table=array_merge
        (
            $table,
            $this->Inscription_Event_Rows($edit,$inscription)
        );

            
         array_push
         (
             $table,
             $this->Inscription_Status_Row($edit,$inscription)
         );

        if (!empty($inscription[ "ID" ]))
        {
            array_push
            (
                $table,
                $this->Inscription_Status_Created_Row($edit,$inscription)
            );
        }
        
        return $table;
    }

   

    //*
    //* function Inscription_Status_Form, Parameter list: $edit,$inscription
    //*
    //* Creates Inscription status table.
    //*

    function Inscription_Status_Form($edit,$inscription)
    {
        return
            $this->Html_Table
            (
                "",
                $this->Inscription_Status_Table($edit,$inscription)
            );
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

        $table=
            array
            (
                $this->Inscription_Status_Form($edit,$inscription),
                $this->InscriptionSGroupsTable($edit,$inscription),
            );
        
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
        if ($this->EventsObj()->Event_Payments_Has())
        {
            array_unshift
            (
                $table,
                $this->Inscription_Event_Payments_Row($inscription),
                $this->Buttons()
            );
        }
        

        if (!empty($inscription))
        {
            array_push
            (
                $table,
                $this->Inscription_Event_Info_Row($inscription)
            );
        }

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
            return
                $this->FrameIt
                (
                    $this->Anchor("TABLE").$this->Anchor("INSCR").
                    $this->H
                    (
                        4,
                        $this->GetRealNameKey($this->Event(),"Title").": ".
                        $this->MyLanguage_GetMessage("Inscriptions_Typed_Tables_Title")
                    ).
                    $this->Html_Table("",$tables).
                    ""
                );
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
        return
            array
            (
               $this->B
               (
                   array_merge
                   (
                       $this->EventsObj()->MyMod_Data_Titles($eventdatas),
                       $this->MyMod_Data_Titles($inscrdatas),
                       array("")
                   )
               ),
               array_merge
               (
                   $this->EventsObj()->MyMod_Item_Row(0,$this->Event(),$eventdatas),
                   $this->MyMod_Item_Row(0,$inscription,$inscrdatas),
                   array
                   (
                       $this->DIV($link,array("CLASS" => 'right'))
                   )
               )
            );
    }
    //*
    //* function InscriptionFriendTable, Parameter list: $edit,$buttontitle,$friend=array(),$inscription=array()
    //*
    //* Creates Inscription friend data table. Overrides EventApp version.
    //*

    function InscriptionFriendTable($edit,$buttontitle,$friend=array(),$inscription=array())
    {
        $this->RegDatasObj()->RegDatas_Friend_Datas_Add();
        $this->RegGroupsObj()->RegGroups_SGroups_Add();
        
        return 
            $this->FriendsObj()->MyMod_Item_Group_Tables_Form
            (
                $edit,
                "Update_Friend",
                $this->InscriptionFriendGroupDefs($edit),
                $friend,
                $mayupdate=TRUE,
                $plural=True,
                $precgikey="",
                 $this->Buttons
                (
                    $this->MyLanguage_GetMessage($buttontitle)
                )
            );
   }
    
}

?>