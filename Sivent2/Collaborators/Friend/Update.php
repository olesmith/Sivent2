<?php

class Collaborators_Friend_Update extends Collaborators_Friend_Read
{
    //*
    //* function Collaborators_Friend_Collaborations_Update, Parameter list: $userid
    //*
    //* Does the updating: adding and removing, according to CGI.
    //*

    function Collaborators_Friend_Collaborations_Update($userid)
    {
        var_dump("Update");
        $nchanged=0;        
        foreach ($this->Collaborations as $collaboration)
        {
            $nchanged+=$this->Collaborators_Friend_Collaboration_Update($userid,$collaboration);
        }

        return $nchanged;
    }
    
    //*
    //* function Collaborators_Friend_Collaboration_Update, Parameter list: $userid,$collaboration
    //*
    //* Does the updating: adding and removing, according to CGI.
    //*

    function Collaborators_Friend_Collaboration_Update($userid,$collaboration)
    {
        $nchanged=0;        
        if ($collaboration[ "Inscriptions" ]!=2) { return; }
            
        $value=$this->CGI_POSTint($this->Collaborators_Friend_Collaborations_Cell_Name($collaboration));

        $collaborator=array();
        if (!empty($this->Collaborators[ $collaboration[ "ID" ] ]))
        {
            $collaborator=$this->Collaborators[ $collaboration[ "ID" ] ];
        }
            
        if ($value==1 && empty($collaborator))
        {
            $collaborator=$this->Collaborators_Friend_Collaborations_Update_Add($userid,$collaboration);
            $nchanged++;
        }
        elseif ($value==0 && !empty($collaborator) && $collaborator[ "Homologated" ]!=2)
        {
            $this->Collaborators_Friend_Collaborations_Update_Delete($userid,$collaboration,$collaborator);
            $nchanged++;
        }

        return $nchanged;
    }
    
    //*
    //* function Collaborators_Friend_Collaborations_Update_Delete, Parameter list: $userid,$collaboration,$collaborator
    //*
    //* Removes $collaborator.
    //*

    function Collaborators_Friend_Collaborations_Update_Delete($userid,$collaboration,$collaborator)
    {
        $res=
            $this->CollaboratorsObj()->Sql_Delete_Items
            (
                array
                (
                    "Unit"          => $this->Unit("ID"),
                    "Event"         => $this->Event("ID"),
                    "Friend"        => $userid,
                    "Collaboration" => $collaboration[ "ID" ],
                )
            );

        unset($this->Collaborators[ $collaboration[ "ID" ] ]);
        
        $this->ApplicationObj()->AddHtmlStatusMessage("Delete Collaboration");
        
        return $res;
    }

        
    //*
    //* function Collaborators_Friend_Collaborations_Update_Add, Parameter list: $userid,$collaboration
    //*
    //* Creates new collaboration, ensuring uniqueness.
    //*

    function Collaborators_Friend_Collaborations_Update_Add($userid,$collaboration)
    {
        $where=array
        (
           "Unit"          => $this->Unit("ID"),
           "Event"          => $this->Event("ID"),
           "Friend"        => $userid,
           "Collaboration" => $collaboration[ "ID" ],
        );
        
        $collaborator=$where;
        $collaborator[ "TimeLoad" ]=$collaboration[ "TimeLoad" ];
        $collaborator[ "Homologated" ]=1;
        
        
        $res=$this->Sql_Insert_Unique($where,$collaborator);
        
        $this->Collaborators[ $collaboration[ "ID" ] ]=$collaboration;
        
        $this->ApplicationObj()->AddHtmlStatusMessage("Add Collaboration");
        
        return $this->MyMod_Item_PostProcess($this->Sql_Select_Hash($where));
    }
}

?>