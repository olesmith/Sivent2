<?php


class InscriptionsAssessments extends InscriptionsSubmissions
{
    //*
    //* function Inscriptions_Assessments_Has, Parameter list: 
    //*
    //* Detects if current event has assessments activated.
    //*

    function Inscriptions_Assessments_Has()
    {
        return $this->EventsObj()->Event_Assessments_Has($this->Event());
    }
    
    //*
    //* function Inscriptions_Assessments_Public, Parameter list: 
    //*
    //* Detects if current event has assessments published.
    //*

    function Inscriptions_Assessments_Public()
    {
        return $this->EventsObj()->Event_Assessments_Public($this->Event());
    }
    
    //*
    //* function Inscriptions_Assessments_Open, Parameter list: 
    //*
    //* Detects if current event has  activated.
    //*

    function Inscriptions_Assessments_Open()
    {
        return $this->EventsObj()->Event_Assessments_Inscriptions_Open($this->Event());
    }
    
    //*
    //* function Inscriptions_Assessments_Has, Parameter list: 
    //*
    //* Detects if current event has any Assessments.
    //*

    function Inscription_Assessments_Has($inscription=array())
    {
        return $this->Friend_Assessors_Has(array("ID" => $inscription[ "Friend" ]));
    }
    
    //*
    //* function Inscription_Assessments_Link, Parameter list: 
    //*
    //* Creates inscription assessments link.
    //*

    function Inscription_Assessments_Link($friend)
    {
        $message="Assessments_Link";
        if (!$this->Inscriptions_Assessments_Open())
        {
            $message="Assessments_Closed";
        }
        
        
        return $this->Inscription_Type_Link("Assessments",$message);
    }
    
    //*
    //* function Inscription_Assessments_Rows, Parameter list: $friend,$inscription
    //*
    //* Creates inscription assessment info row (no details).
    //*

    function Inscription_Assessments_Rows($friend,$inscription)
    {
        return
            $this->Inscription_Type_Rows
            (
               $inscription,
               "Assessments",
               $this->Inscription_Assessments_Link($friend),
               array("Assessments","Assessments_StartDate","Assessments_EndDate")
            );
    }
    
    //*
    //* function Inscription_Assessors_Table_Show, Parameter list: $edit,$inscription
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Friend_Assessors_Table($edit,$friend,$inscription)
    {
        if (!$this->Friend_Assessors_Should($friend)) { return array(); }
        
        $type=$this->GetTablesType();
        if (!empty($type) && $type!="Assessments")
        {
            return $this->Inscription_Assessments_Rows($friend,$inscription);
        }
        
        $this->AssessorsObj()->Actions("Show");
        $this->AssessorsObj()->ItemData("ID");
        $this->AssessorsObj()->ItemDataGroups("Basic");
        
        $this->FriendsObj()->ItemData("ID");
        $this->CriteriasObj()->ItemData("ID");
        $this->AssessmentsObj()->ItemData("ID");
        
        return 
            $this->AssessorsObj()->Assessor_Friend_Table_Html($edit,$friend);
    }
    
}

?>