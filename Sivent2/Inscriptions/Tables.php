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
        
        if
            (
                !empty($this->ItemDataSGroups[ "Payments" ])
                &&
                is_array($this->ItemDataSGroups[ "Payments" ])
            )
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

        $html=array();
        if (count($sgroups)==1 && count($sgroups[0])==0 && $this->EventsObj()->Events_Open_Is())
        {
            array_push($html,$buttons);
        }

        return array
        (
            $html,
            $this->MyMod_Item_Group_Tables_Html
            (
               $edit,
               $sgroups,
               $inscription,
               $buttons
            )
        );
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
                $this->Span
                (
                    $this->InscriptionDiagList($inscription),
                    array("ID" => "TABLE")
                )
            );
        
        $info=$this->Event("Info");

        if (!empty($info))
        {
            array_push
            (
                $row,
                array
                (
                    "Text" => $this->FriendsObj()->Friend_Event_Info_Cell
                    (
                        $this->Event()
                    ),
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
    //* function Inscription_Payment_Cell, Parameter list: $group
    //*
    //* Generates Inscription Payments Group table data.
    //*

    function Inscription_Payment_Cell($group,$item=array())
    {
        return "Inscription_Payment_Type_Cell";
    }
    
    //*
    //* function Inscription_Payments_Table, Parameter list: $group
    //*
    //* Generates Inscription Payments Group table data.
    //*

    function Inscription_Payments_Datas($group,$item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        
        $commondata=
            array
            (
                "Type",
                "Lot",
                "Has_Paid",
                "Value_Nominal",
                "Value_Paid" ,"Date_Paid"
            );


        $event=$this->Event();
        
        $datas=array();
        if ($event[ "Payments_Type" ]==1)
        {
            $datas=
                array
                (
                    "Receit_Paid",
                );
        }
        elseif ($event[ "Payments_Type" ]==2)
        {
            $datas=
                array
                (
                    "PagSeguro_Code",
                );
        }

        $datas=
            array_merge
            (
                $commondata,
                $datas
            );

        return $this->FindAllowedData($edit=0,$datas);
    }

//*
    //* function Inscription_Event_Payments_Row, Parameter list:
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function Inscription_Event_Payments_Row($inscription)
    {
        $this->ItemDataSGroups[ "Payments" ][ "Visible" ]=FALSE;

        $table=$this->MyMod_Item_Group_Table(1,"Payments",$inscription);

        array_push
        (
            $table,
            array
            (
                "Forma de pagamento",
                "fff"
            )
        );

        return
            array
            (
                #$this->Html_Table().
                $this->FriendsObj()->Friend_Event_Payments_Cell($this->Event()),
            );
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
                #$this->Inscription_Handle_Event_Status_Form($edit,$inscription),
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
            array_push
            (
                $table,
                $this->Inscription_Event_Payments_Row($inscription),
                $this->Buttons
                (
                    $this->MyLanguage_GetMessage("Inscription_Button_Inscribed")
                )
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
#                $this->Friend_Collaborations_Table($edit,$friend,$inscription),
                $this->Friend_Caravans_Table_Form($edit,$friend,$inscription)         
            );
            
        if (!empty($tables))
        {
            return
                $this->FrameIt
                (
                    $this->H
                    (
                        4,
                        $this->GetRealNameKey($this->Event(),"Title").": ".
                        $this->MyLanguage_GetMessage("Inscriptions_Typed_Tables_Title"),
                        array("ID" => "INSCR")
                    ).
                    $this->Html_Table("",$tables).
                    "",
                    array("ID" => "TABLE")
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
            $this->Htmls_Comment_Section
            (
                "Inscription Friend data Table",
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
                )
            );
   }
    
}

?>