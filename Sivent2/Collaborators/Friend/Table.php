<?php

class Collaborators_Friend_Table extends Collaborators_Friend_Update
{
    //*
    //* function Collaborators_Friend_Collaboration_Collaborator, Parameter list: $collaboration,$inscriptionsonly=TRUE
    //*
    //* Attempts to locate $collaboration.
    //*

    function Collaborators_Friend_Collaboration_Collaborator($collaboration,$inscriptionsonly=TRUE,$inscribedonly=False)
    {
        $collaborator=array();
        if
            (
                !empty($this->Collaborators[ $collaboration[ "ID" ] ])
            )
        {
            $collaborator=$this->Collaborators[ $collaboration[ "ID" ] ];
        }

        if ($edit==1 || !empty($collaborator))
        {
            return $collaborator;
        }
        
        return array();
    }

    
    //*
    //* function Collaborators_Friend_Collaborations_Table, Parameter list: $userid,$inscriptionsonly=TRUE
    //*
    //* Creates table with elegible collaborations, allowing user to add and remove.
    //*

    function Collaborators_Friend_Collaborations_Table($edit,$userid,$group,$inscriptionsonly=TRUE,$inscribedonly=False)
    {
        $this->ItemData("ID");
        $this->ItemDataGroups($group);
        $this->Collaborators_Friend_Read
        (
            $userid,
            $inscriptionsonly,
            $inscribedonly
        );

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $nchanged=$this->Collaborators_Friend_Collaborations_Update($userid);
        }

        $n=1;
       
        $table=array();
        foreach ($this->Collaborations as $collaboration)
        {
            $collaborator=array();
            if
                (
                    !empty($this->Collaborators[ $collaboration[ "ID" ] ])
                )
            {
                $collaborator=$this->Collaborators[ $collaboration[ "ID" ] ];
            }
       
            if ($edit==1 || !empty($collaborator))
            {
                array_push
                (
                    $table,
                    $this->Collaborators_Friend_Collaborations_Row
                    (
                        $edit,
                        $n++,
                        $collaboration,
                        $this->CollaborationsObj()->MyMod_Data_Group_Datas_Get("Inscription"),
                        $collaborator,
                        array("Homologated","TimeLoad","Certificate"),
                        array("-","-")
                    )
                );
            }
        }

        return $table;
    }
}

?>