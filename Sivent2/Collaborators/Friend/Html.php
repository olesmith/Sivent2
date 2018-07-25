<?php

class Collaborators_Friend_Html extends Collaborators_Friend_Table
{
    //*
    //* function Collaborators_Friend_Collaborations_Html, Parameter list: $edit,$userid,$group="Basic"
    //*
    //* Generates user collaborations table.
    //*

    function Collaborators_Friend_Collaborations_Html($edit,$userid,$group="",$titlekey="",$inscriptionsonly=True,$inscribedonly=True)
    {
        if (empty($titlekey)) { $titlekey="Collaborators_User_Table_Title"; }
        if (empty($group)) { $group="Basic"; }
        
        if (count($this->Collaborators)>=0)
        {
            return
                $this->Htmls_Table
                (
                    $this->Collaborators_Friend_Collaborations_Titles(),
                    $this->Collaborators_Friend_Collaborations_Table
                    (
                        $edit,
                        $userid,
                        $group,
                        $inscriptionsonly,
                        $inscribedonly
                    ),
                    array(),array(),array(),
                    True,True
                );
        }

        return array();
    }
    
}

?>