<?php


class InscriptionsSubmissions extends InscriptionsCaravans
{
    //*
    //* function Inscriptions_Submissions_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Submissions_Has()
    {
        $event=$this->Event();
        return $this->EventsObj()->Event_Submissions_Has($event);
    }
    
    //*
    //* function Inscriptions_Submissions_Public, Parameter list: 
    //*
    //* Detects if current event has submissions public.
    //*

    function Inscriptions_Submissions_Public()
    {
        $event=$this->Event();
        return $this->EventsObj()->Event_Submissions_Public($event);
    }
    
    //*
    //* function Inscriptions_Submissions_Inscriptions_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Submissions_Inscriptions_Has()
    {
        $event=$this->Event();
        return $this->EventsObj()->Event_Submissions_Inscriptions_Has($event);
    }
    
    //*
    //* function Inscriptions_Submissions_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Submissions_Inscriptions_Open()
    {
        $event=$this->Event();
        return $this->EventsObj()->Event_Submissions_Inscriptions_Open($event);
    }

    //*
    //* function Inscriptions_Collaborations_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscription_Submissions_Has($item=array())
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($item[ "Friend" ]))
        {
            $nentries=$this->SubmissionsObj()->Sql_Select_NEntries(array("Friend" => $item[ "Friend" ]));
        }
        
        if ($nentries>0) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* function Inscriptions_Collaborations_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Submissions_Show_Should($item=array())
    {
        $res=
            $this->EventsObj()->Event_Submissions_Inscriptions_Open($this->Event())
            ||
            $this->Inscription_Submissions_Has($item);

        return $res;
    }
    
    //*
    //* function Inscriptions_Submissions_Show_Name, Parameter list: 
    //*
    //* Generates  name for Submissions link.
    //*

    function Inscriptions_Submissions_Show_Name($data,$item=array())
    {
        $title="";
        if ($this->Inscription_Submissions_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Submissions_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Submissions_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions__Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Submissions_Show_Title($data,$item=array())
    {
        $title="";
        if ($this->Inscription_Submissions_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Submissions_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Submissions_Show_Inscriptions_Title");
        }

        return $title;
    }
    //*
    //* function Inscription_Submissions_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Submissions_Table_Edit($edit)
    {
        $startdate=$this->Event("Submissions_StartDate");
        $enddate=$this->Event("Submissions_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
    //*
    //* function Inscription_Submissions_Table_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Inscription_Submissions_Table_DateSpan()
    {
        return
            $this->H
            (
               4,
               $this->MyTime_Sort2Date($this->Event("Submissions_StartDate")).
               " - ".
               $this->MyTime_Sort2Date($this->Event("Submissions_EndDate"))
            ).
            "";
    }
    
    //*
    //* function Inscription_Group_Update, Parameter list: &$item
    //*
    //* Updates data from Submissions form.
    //*

    function Inscription_Group_Update($group,&$item)
    {
        $item=$this->MyMod_Item_Update_CGI($item,$this->GetGroupDatas($group,TRUE),$prepost="");
        
        return $item;
    }
   //*
    //* function Inscription_Submissions_Table, Parameter list: 
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Submissions_Table($edit,$item,$group="")
    {
        $this->SubmissionsObj()->Sql_Table_Structure_Update();
        
        $this->SubmissionsObj()->Actions("Edit");
        $this->SubmissionsObj()->ItemData("ID");
        $this->SubmissionsObj()->ItemDataGroups("Basic");
        
        if (empty($group)) { $group="Submissions"; }
        
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$item);
        }
        
        return
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->Inscription_Submissions_Table_DateSpan().
            $this->MyMod_Item_Table_Html
            (
               $this->Inscription_Submissions_Table_Edit($edit),
               $item,
               $this->GetGroupDatas($group,TRUE)
            ).
            $this->Inscription_Submissions_Table_Show($edit,$item).
            "";
    }
    
    
    //*
    //* function Inscription_Submissions_Show, Parameter list: $edit,$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Submissions_Table_Show($edit,$item)
    {
        
        return 
            $this->Submissionsobj()->Submissions_Table_Show($edit,$item);
    }
}

?>