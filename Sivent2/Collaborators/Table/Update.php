<?php

class Collaborators_Table_Update extends Collaborators_Table_Read
{
    //*
    //* function Collaborators_Table_Collaborations_Update, Parameter list: $userid,$collaborations,$collaborators
    //*
    //* Does the updating: adding and removing, according to CGI.
    //*

    function Collaborators_Table_Collaborations_Update($userid,$collaborations,&$collaborators)
    {
        $nchanged=0;
        
        foreach ($collaborations as $collaboration)
        {
            if ($collaboration[ "Inscriptions" ]!=2) { continue; }
            
            $value=$this->CGI_POSTint($this->Collaborators_Table_Collaborations_Cell_Name($collaboration));

            $collaborator=array();
            if (!empty($collaborators[ $collaboration[ "ID" ] ]))
            {
                $collaborator=$collaborators[ $collaboration[ "ID" ] ];
            }
            
            if ($value==1 && empty($collaborator))
            {
                $collaborator=$this->Collaborators_Table_Collaborations_Update_Add($userid,$collaboration);
                $collaborators[ $collaboration[ "ID" ] ]=$collaboration;
                $nchanged++;
            }
            elseif ($value==0 && !empty($collaborator) && $collaborator[ "Homologated" ]!=2)
            {
                $this->Collaborators_Table_Collaborations_Update_Delete($userid,$collaboration,$collaborator);
                unset($collaborators[ $collaboration[ "ID" ] ]);
                $nchanged++;
            }
        }

        return $nchanged;
    }
    
    //*
    //* function Collaborators_Table_Collaborations_Update_Delete, Parameter list: $userid,$collaboration,$collaborator
    //*
    //* Removes $collaborator.
    //*

    function Collaborators_Table_Collaborations_Update_Delete($userid,$collaboration,$collaborator)
    {
        $where=array
        (
           "Friend" => $userid,
           "Collaboration" => $collaboration[ "ID" ],
        );
        
        $res=$this->CollaboratorsObj()->Sql_Delete_Items($where);

        return $res;
    }

        
    //*
    //* function Collaborators_Table_Collaborations_Update_Add, Parameter list: $userid,$collaboration
    //*
    //* Creates new collaboration, ensuring uniqueness.
    //*

    function Collaborators_Table_Collaborations_Update_Add($userid,$collaboration)
    {
        $where=array
        (
           "Friend" => $userid,
           "Collaboration" => $collaboration[ "ID" ],
        );
        
        $collaborator=$where;
        $collaborator[ "TimeLoad" ]=$collaboration[ "TimeLoad" ];
        $collaborator[ "Homologated" ]=1;
        
        
        $this->Sql_Insert_Unique($where,$collaborator);
        
        return $this->PostProcessItem($this->Sql_Select_Hash($where));
    }
}

?>