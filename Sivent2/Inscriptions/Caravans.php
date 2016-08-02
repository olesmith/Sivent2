<?php


class InscriptionsCaravans extends InscriptionsCollaborations
{
    //*
    //* function Inscriptions_Caravans_Has, Parameter list: 
    //*
    //* Detects if current event has Caravans activated.
    //*

    function Inscriptions_Caravans_Has()
    {
        $event=$this->Event();

        return $this->EventsObj()->Event_Caravans_Has($event);
    }
    
    //*
    //* function Inscriptions_Caravans_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //* Calls EventObj() for the job.
    //*

    function Inscriptions_Caravans_Inscriptions_Open()
    {
        $event=$this->Event();

        return $this->EventsObj()->Event_Caravans_Inscriptions_Open($event);
    }
    
    //*
    //* function Inscriptions_Caravans_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Caravans_Show_Should($item=array())
    {
        $res=
            $this->EventsObj()->Event_Caravans_Has($this->Event())
            /* || */
            /* $this->Inscription_Caravaneers_Has($item) */
            ;

        return $res;
    }
    
    //*
    //* function Inscriptions_Caravans_Show_Name, Parameter list: 
    //*
    //* Generates  name for Submissions link.
    //*

    function Inscriptions_Caravans_Show_Name($data,$item=array())
    {
        $title="";
        if ($this->Inscriptions_Caravans_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions_Caravans_Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Caravans_Show_Title($data,$item=array())
    {
        $title="";
        if ($this->Inscriptions_Caravans_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Inscriptions_Title");
        }

        return $title;
    }
    
    //*
    //* function Inscription_Caravans_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Caravans_Table_Edit($edit)
    {
        $startdate=$this->Event("Caravans_StartDate");
        $enddate=$this->Event("Caravans_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
    //*
    //* function Inscription_Caravans_Table_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Inscription_Caravans_Table_DateSpan()
    {
        return
            $this->MyTime_Sort2Date($this->Event("Caravans_StartDate")).
            " - ".
            $this->MyTime_Sort2Date($this->Event("Caravans_EndDate")).
            "";
    }
}

?>