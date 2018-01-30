<?php

class Collaborators_Table_Table extends Collaborators_Table_Update
{    
    //*
    //* function Collaborators_Table_Collaborations_Html, Parameter list: $userid,$inscriptionsonly=TRUE
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Html($edit,$userid,$inscriptionsonly=TRUE)
    {
        $this->CollaborationsObj()->ItemData("ID");
        $this->CollaborationsObj()->ItemDataGroups("Basic");

        return
            $this->Html_Table
            (
               $this->Collaborators_Table_Collaborations_Titles(),
               $this->Collaborators_Table_Collaborations_Table($edit,$userid,$inscriptionsonly)
            ).
            "";
        
    }

    
    //*
    //* function Collaborators_Table_Collaborations_Table, Parameter list: $userid,$inscriptionsonly=TRUE
    //*
    //* Creates table with elegible collaborations, allowing user to add and remove.
    //*

    function Collaborators_Table_Collaborations_Table($edit,$userid,$inscriptionsonly=TRUE)
    {
        $collaborators=$this->Collaborators_User_Table_Read($userid);
        $collaborators=$this->MyHash_HashesList_2ID($collaborators,"Collaboration");

        
        $collaborations=$this->Collaborators_Table_Collaborations_Read($inscriptionsonly);
        
        //$rdatas=$this->CollaborationsObj()->MyMod_Data_Group_Datas_Get("Inscription");
        //$datas=array("Homologated","TimeLoad","Certificate");
        //$empties=array("-","-");

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $nchanged=$this->Collaborators_Table_Collaborations_Update($userid,$collaborations,$collaborators);
        }

        $n=1;
        
        $table=array();
        foreach ($collaborations as $collaboration)
        {
            $collaborator=array();
            if (!empty($collaborators[ $collaboration[ "ID" ] ])) { $collaborator=$collaborators[ $collaboration[ "ID" ] ]; }

            if ($edit==1 || !empty($collaborator))
            {
                $row=$this->Collaborators_Table_Collaborations_Row
                (
                   $edit,
                   $n++,
                   $collaboration,
                   $this->CollaborationsObj()->MyMod_Data_Group_Datas_Get("Inscription"),
                   $collaborator,
                   array("Homologated","TimeLoad","Certificate"),
                   array("-","-")
                );
                
                array_push($table,$row);
            }
        }

        return $table;
        
    }
}

?>