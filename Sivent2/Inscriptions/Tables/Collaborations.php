<?php

class InscriptionsTablesCollaborations extends InscriptionsTablesAssessments
{
    //*
    //* function Inscription_Collaborations_Link, Parameter list: 
    //*
    //* Creates inscription collaborations info row (no details).
    //*

    function Inscription_Collaborations_Link($item)
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
                "Friend" => $item[ "Friend" ],
                "Homologated" => 2
               )
            );

        $ncollaborations=$this->CollaboratorsObj()->Sql_Select_NHashes($where);
        if ($ncollaborations>0)
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
    //* function Inscription_Collaborations_Row, Parameter list: 
    //*
    //* Creates inscription collaboration info row (no details).
    //*

    function Inscription_Collaborations_Row($item)
    {
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "Collaborations",
               $this->Inscription_Collaborations_Link($item),
               array("Collaborations","Collaborations_StartDate","Collaborations_EndDate")
            );
    }
    
    //*
    //* function Inscription_Collaborations_Table, Parameter list: 
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Collaborations_Table($edit,$item,$group="")
    {
        if (!$this->Inscriptions_Collaborations_Has()) { return array(); }

        if (!$this->Inscriptions_Collaborations_Inscriptions_Open()) { $edit=0; }

        $type=$this->InscriptionTablesType($item);
        if ($type!="Collaborations")
        {
            return $this->Inscription_Collaborations_Row($item);
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
            $this->Inscription_Group_Update($group,$item);
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
               $item,
               $this->GetGroupDatas($group,TRUE)
            ).
            $this->Inscription_Collaborations_Table_Show($edit,$item).
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
    //* function Inscription_Event_Collaborations_Table, Parameter list: $edit
    //*
    //* Creates a table listing inscription colaborations.
    //*

    function Inscription_Event_Collaborations_Table($edit,$inscription)
    {
        return
            $this->Inscription_Collaborations_Table_Show($edit,$inscription,"Collaborators_User_Table_Title").
            "";
    }
}

?>