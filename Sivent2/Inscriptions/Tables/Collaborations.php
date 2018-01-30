<?php

class InscriptionsTablesCollaborations extends InscriptionsTablesAssessments
{
    //*
    //* function Friend_Collaborations_Link, Parameter list: $friend
    //*
    //* Creates $friend collaborations info row (no details).
    //*

    function Friend_Collaborations_Link($friend)
    {
        $message="Collaborations_Inscribe_Link";
        if (!$this->Inscriptions_Collaborations_Inscriptions_Open())
        {
            $message="Collaborations_Inscriptions_Closed";
        }

        $where=
            $this->UnitEventWhere
            (
               array
               (
                "Friend" => $friend[ "ID" ],
                "Homologated" => 2
               )
            );

        if ($this->Friend_Collaborators_Has($friend))
        {
            $message="Collaborations_Inscribed_Link";
        }
        elseif(!$this->Inscriptions_Collaborations_Inscriptions_Open())
        {
            return $this->MyLanguage_GetMessage("Collaborations_Inscriptions_Closed");
        }
        
        return $this->Inscription_Type_Link("Collaborations",$message);
    }
    
    //*
    //* function Inscription_Collaborations_Row, Parameter list: $friend,$inscription
    //*
    //* Creates inscription collaboration info row (no details).
    //*

    function Friend_Collaborations_Row($friend,$inscription)
    {
        return
            $this->Inscription_Type_Rows
            (
               $inscription,
               "Collaborations",
               $this->Friend_Collaborations_Link($friend),
               array("Collaborations","Collaborations_StartDate","Collaborations_EndDate")
            );
    }
    
    //*
    //* function Friend_Collaborations_Table, Parameter list: $edit,$friend,$inscription,$group=""
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Friend_Collaborations_Table($edit,$friend,$inscription,$group="")
    {
        if (!$this->FriendsObj()->Friend_Collaborators_Should($friend)) { return array(); }

        //if (!$this->Inscriptions_Collaborations_Inscriptions_Open()) { $edit=0; }

        $type=$this->InscriptionTablesType($inscription);

        if ($type!="Collaborations")
        {
            return $this->Friend_Collaborations_Row($friend,$friend);
        }
        
        $this->CollaborationsObj()->Sql_Table_Structure_Update();
        $this->CollaboratorsObj()->Sql_Table_Structure_Update();
        
        if (empty($group)) { $group="Collaborations"; }
      
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$inscription);
        }
        
        $html="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
            $html.=$this->StartForm();
        }

        $html.=
            $this->H
            (
               5,
               $this->MyLanguage_GetMessage("Inscription_Period").
               ", ".
               $this->GetRealNameKey($this->ItemDataSGroups[ $group ]).
               ": ".
               $this->EventsObj()->Event_Collaborations_Inscriptions_DateSpan().
               ". ".
               $this->EventsObj()->Event_Collaborations_Inscriptions_Status()
            ).
            $this->MyMod_Item_Table_Html
            (
               $this->Inscription_Collaborations_Table_Edit($edit),
               $inscription,
               $this->MyMod_Data_Group_Datas_Get($group,TRUE)
            ).
            $this->Friend_Collaborations_Table_Show($edit,$friend,$inscription).
            "";
        
        if ($edit==1)
        {
            $html.=
                $this->MakeHidden("Update",1).
                //$buttons.
                $this->EndForm().
                "";
        }

        return array(array($this->FrameIt($html)));
    }
    
    
    //*
    //* function Inscription_Event_Collaborations_Table, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates a table listing inscription colaborations.
    //*

    function Inscription_Event_Collaborations_Table($edit,$friend,$inscription)
    {
        return
            $this->Inscription_Collaborations_Table_Show($edit,$inscription,"Collaborators_User_Table_Title").
            "";
    }
}

?>