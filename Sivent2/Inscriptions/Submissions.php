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
    //* Detects if current event has Submissions activated.
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
    //* function Inscription_Submissions_Has, Parameter list: 
    //*
    //* Detects if current event has any Submissions.
    //*

    function Inscription_Submissions_Has($inscription=array())
    {
        $res=FALSE;

        $nentries=0;
        if (!empty($inscription[ "Friend" ]))
        {
            $nentries=$this->SubmissionsObj()->Sql_Select_NEntries(array("Friend" => $inscription[ "Friend" ]));
        }
        
        if ($nentries>0) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* function Inscriptions_Collaborations_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Submissions_Show_Should($inscription=array())
    {
        $res=
            $this->EventsObj()->Event_Submissions_Inscriptions_Open($this->Event())
            ||
            $this->Inscription_Submissions_Has($inscription);

        return $res;
    }
    
    //*
    //* function Inscriptions_Submissions_Show_Name, Parameter list: 
    //*
    //* Generates  name for Submissions link.
    //*

    function Inscriptions_Submissions_Show_Name($data,$inscription=array())
    {
        $title="";
        if ($this->Inscription_Submissions_Has($inscription))
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

    function Inscriptions_Submissions_Show_Title($data,$inscription=array())
    {
        $title="";
        if ($this->Inscription_Submissions_Has($inscription))
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
    //* function Friend_Submissions_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Friend_Submissions_Table_Edit($edit)
    {
        $startdate=$this->Event("Submissions_StartDate");
        $enddate=$this->Event("Submissions_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
    //*
    //* function Friend_Submissions_Table_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Friend_Submissions_Table_DateSpan()
    {
        return $this->Date_Span_Interval($event,"Submissions_StartDate","Submissions_EndDate");
    }
    
    //*
    //* function Friend_Submissions_Table_Show, Parameter list: $edit,$inscription
    //*
    //* Shows currently allocated collaborations for inscription in $inscription.
    //*

    function Friend_Submissions_Table_Show($edit,$friend,$inscription)
    {
        $this->SubmissionsObj()->ItemData("ID");
        $this->SubmissionsObj()->ItemDataGroups("Basic");
        $this->SubmissionsObj()->Actions("Show");
        
        return
            $this->Submissionsobj()->Submissions_Table_Show($edit,$friend,$inscription);
    }
}

?>