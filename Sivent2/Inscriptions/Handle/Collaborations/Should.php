<?php


class Inscriptions_Handle_Collaborations_Should extends Inscriptions_Handle_Collaborations_Form
{    
    //*
    //* function Inscription_Handle_Collaborations_Show_Should, Parameter list: $edit,$friend,$inscription
    //*
    //* Determines whether we should show Collaborations.
    //*

    function Inscription_Handle_Collaborations_Show_Should($edit,$friend,$inscription)
    {
        $this->Inscription_Handle_Collaborations_Read($friend);
        $res=$this->EventsObj()->Event_Collaborations_Inscriptions_Open();

        #Show even inscriptions closed, if $friend has collaborations.
        if (!$res)
        {
            if (count($this->Collaborators)>0)
            {
                $res=True;
            }
        }

        return $res;
    }
   
    //*
    //* function Inscription_Handle_Collaborations_Table_Edit_Should, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Handle_Collaborations_Table_Edit_Should($edit)
    {
        $startdate=$this->Event("Collaborations_StartDate");
        $enddate=$this->Event("Collaborations_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
}

?>