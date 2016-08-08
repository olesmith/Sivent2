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
    //* function Inscriptions_Assessments_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has  activated.
    //*

    function Inscriptions_Assessments_Inscriptions_Open()
    {
        return $this->EventsObj()->Event_Assessments_Inscriptions_Open($this->Event());
    }
    
    //*
    //* function Inscription_Assessors_Table_Show, Parameter list: $edit,$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Assessors_Table($edit,$item)
    {
        $this->AssessorsObj()->Actions("Show");
        $this->AssessorsObj()->ItemData("ID");
        $this->AssessorsObj()->ItemDataGroups("Basic");
        
        $this->FriendsObj()->ItemData("ID");
        $this->CriteriasObj()->ItemData("ID");
        $this->AssessmentsObj()->ItemData("ID");
        
        return 
            $this->AssessorsObj()->Assessors_Inscription_Table_Html($edit,$item);
    }
    
}

?>