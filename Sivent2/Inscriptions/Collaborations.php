<?php


class InscriptionsCollaborations extends InscriptionsForm
{
    //*
    //* function Inscriptions_Collaborations_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Has($item=array())
    {
        return $this->EventsObj()->Event_Collaborations_Has($this->Event());
    }
    
    //*
    //* function Inscriptions_Collaborations_Inscriptions_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Inscriptions_Has($item=array())
    {
        return $this->EventsObj()->Event_Collaborations_Inscriptions_Has($this->Event());
    }

    //*
    //* function Inscriptions_Collaborations_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has inscriptions to collaborations activated.
    //*

    function Inscriptions_Collaborations_Inscriptions_Open($item=array())
    {
        return $this->EventsObj()->Event_Collaborations_Inscriptions_Open($this->Event());
    }

    //*
    //* function Inscription_Collaborations_Has, Parameter list: $item
    //*
    //* Detects if $item has any collaborations.
    //*

    function Inscription_Collaborations_Has($item=array())
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($item[ "Friend" ]))
        {
            $nentries=$this->CollaboratorsObj()->Sql_Select_NEntries(array("Friend" => $item[ "Friend" ]));
        }

        if ($nentries>0) { $res=TRUE; }

        return $res;
    }

    
    //*
    //* function Inscriptions_Collaborations_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Show_Should($item=array())
    {
        $res=
            $this->EventsObj()->Event_Collaborations_Inscriptions_Open($this->Event())
            ||
            $this->Inscription_Collaborations_Has($item);

        return $res;
    }

    //*
    //* function Inscriptions_Collaborations_Show_Name, Parameter list: 
    //*
    //* Generates  name for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Name($data,$item=array())
    {
        $title="";
        if ($this->Inscription_Collaborations_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions_Collaborations_Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Title($data,$item=array())
    {
        $title="";
        if ($this->Inscription_Collaborations_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Title");
        }

        return $title;
    }
   
    //*
    //* function Inscription_Collaborations_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Collaborations_Table_Edit($edit)
    {
        $startdate=$this->Event("Collaborations_StartDate");
        $enddate=$this->Event("Collaborations_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
   
    //*
    //* function Inscription_Group_Update, Parameter list: &$item
    //*
    //* Updates data from Collaborations form.
    //*

    function Inscription_Group_Update($group,&$item)
    {
        $item=$this->MyMod_Item_Update_CGI($item,$this->GetGroupDatas($group,TRUE),$prepost="");
        
        return $item;
    }
   //*
    //* function Inscription_Collaborations_Table, Parameter list: 
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Collaborations_Table($edit,$item,$group="")
    {
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
                $buttons.
                $this->EndForm().
                "";
        }

        return $this->FrameIt($html);
    }
    
    
    //*
    //* function Inscription_Collaborations_Show, Parameter list: $edit,$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Collaborations_Table_Show($edit,$item,$msgkey="")
    {
        if (empty($msgkey)) { $msgkey="Collaborators_User_Inscription_Title"; }
        
        $this->CollaborationsObj()->Sql_Table_Structure_Update();
        $this->CollaboratorsObj()->Sql_Table_Structure_Update();

        return
            $this->CollaboratorsObj()->Collaborators_User_Table_Show($edit,$item[ "Friend" ],$msgkey);
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