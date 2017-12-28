<?php

class InscriptionsTablesSubmissions extends InscriptionsTablesSchedules
{
    //*
    //* function Friend_Submissions_Link, Parameter list: $friend
    //*
    //* Creates inscription submissions link.
    //*

    function Friend_Submissions_Link($friend)
    {
        $message="Submissions_Inscribe_Link";
        if (!$this->Inscriptions_Submissions_Inscriptions_Open())
        {
            $message="Submissions_Inscriptions_Closed";
        }
        
        $nsubmissions=
            $this->SubmissionsObj()->FriendNSubmissions
            (
               $friend[ "ID" ],
               array("Status"   => 2)
            );

        if ($nsubmissions>0)
        {
            $message="Submissions_Inscribed_Link";
        }
        
        return $this->Inscription_Type_Link("Submissions",$message);
    }
    
    //*
    //* function Inscription_Submissions_Rows, Parameter list: 
    //*
    //* Creates inscription collaboration info row (no details).
    //*

    function Friend_Submissions_Rows($friend,$inscription)
    {
        return
            $this->Inscription_Type_Rows
            (
               $inscription,
               "Submissions",
               $this->Friend_Submissions_Link($friend),
               array
               (
                   "Submissions",
                   "Submissions_StartDate",
                   "Submissions_EndDate",
               )
            );
    }
    
    //*
    //* function Friend_Submissions_Table, Parameter list: $edit,$friend,$inscription,$group=""
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Friend_Submissions_Table($edit,$friend,$inscription,$group="")
    {
        if (!$this->Friend_Submissions_Should($friend))
        { return array(); }
        
        $type=$this->InscriptionTablesType($inscription);
        if ($type!="Submissions")
        {
            return $this->Friend_Submissions_Rows($friend,$inscription);
        }

        $this->SubmissionsObj()->Sql_Table_Structure_Update();
        
        $this->SubmissionsObj()->Actions("Edit");
        $this->SubmissionsObj()->ItemData("ID");
        $this->SubmissionsObj()->ItemDataGroups("Basic");
        
        if (empty($group)) { $group="Submissions"; }
        
        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php",$this->ItemDataSGroups);
        }
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$inscription);
        }
        
        $table=$this->Friend_Submissions_Rows($friend,$inscription);
        array_push
        (
           $table,
           array($this->Friend_Submissions_Table_Show($edit,$friend,$inscription))
        );
        
        return $table;
    }
}

?>