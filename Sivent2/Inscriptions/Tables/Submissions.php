<?php

class InscriptionsTablesSubmissions extends InscriptionsTablesSchedules
{
    //*
    //* function Inscription_Submissions_Link, Parameter list: 
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Submissions_Link($item)
    {
        $message="Submissions_Inscribe_Link";
        if (!$this->Inscriptions_Submissions_Inscriptions_Open())
        {
            $message="Submissions_Inscriptions_Closed";
        }
        
        $nsubmissions=
            $this->SubmissionsObj()->FriendNSubmissions
            (
               $item[ "Friend" ],
               array("Status"   => 2)
            );

        if ($nsubmissions>0)
        {
            $message="Submissions_Inscribed_Link";
        }
        
        return $this->Inscription_Type_Link("Submissions",$message);
    }
    
    //*
    //* function Inscription_Submissions_Row, Parameter list: 
    //*
    //* Creates inscription collaboration info row (no details).
    //*

    function Inscription_Submissions_Rows($item)
    {
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "Submissions",
               $this->Inscription_Submissions_Link($item),
               array("Submissions","Submissions_StartDate","Submissions_EndDate")
            );
    }
    
    //*
    //* function Inscription_Submissions_Table, Parameter list: 
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Submissions_Table($edit,$item,$group="")
    {
        if (!$this->Inscriptions_Submissions_Has()) { return array(); }
        
        if (!$this->Inscriptions_Submissions_Inscriptions_Open()) { $edit=0; }

        $type=$this->InscriptionTablesType($item);
        if ($type!="Submissions")
        {
            return $this->Inscription_Submissions_Rows($item);
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
            $this->Inscription_Group_Update($group,$item);
        }

        $table=$this->Inscription_Submissions_Rows($item);
        array_push
        (
           $table,
           array($this->Inscription_Submissions_Table_Show(0,$item))
        );
        
        return $table;
    }
}

?>