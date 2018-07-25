<?php


class Inscriptions_Handle_Collaborations_Group extends Inscriptions_Handle_Collaborations_Info
{    
    //*
    //* function Inscription_Handle_Collaborations_Group, Parameter list: $edit,$friend,$inscription
    //*
    //* Incription Collaborations form data group.
    //*

    function Inscription_Handle_Collaborations_Group($group)
    {
        if (empty($group)) { $group="Collaborations"; }
      
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }

        return $group;
    }
    
}

?>