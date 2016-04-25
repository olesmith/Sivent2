<?php

include_once("Table/Cell.php");
include_once("Table/Row.php");
include_once("Table/Read.php");
include_once("Table/Update.php");

class CollaboratorsTable extends CollaboratorsTableUpdate
{
    var $Items=array();
    
    //*
    //* function Collaborators_User_Table_Read, Parameter list: $user
    //*
    //* Reads users collaborations fro db.
    //*

    function Collaborators_User_Table_Read($userid)
    {
        if (empty($this->Items))
        {
            $where=array
            (
               "Friend" => $userid,
            );

            $this->Items=$this->Sql_Select_Hashes($where);
        }

        return $this->Items;
    }
    
    //*
    //* function Collaborators_User_Table_Show, Parameter list: $edit,$userid,$group="Basic"
    //*
    //* Shows user collaborations table.
    //*

    function Collaborators_User_Table_Show($edit,$userid,$group="Basic")
    {
        
        $this->ItemData("ID");
        $this->ItemDataGroups($group);
        $this->Collaborators_User_Table_Read($userid);

        return $this->Collaborators_User_Table_Form($edit,$userid,$group);
    }

    //*
    //* function Collaborators_User_Table_Form, Parameter list: $edit,$user,$group="Basic"
    //*
    //* 
    //*

    function Collaborators_User_Table_Form($edit,$userid,$group="Basic")
    {
        
        $this->ItemData("ID");
        $this->ItemDataGroups($group);
        $this->Collaborators_User_Table_Read($userid);
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Items=$this->UpdateItems($this->Items);
        }

        $html="";
        if ($edit==1)
        {
            $html.=
                $this->StartForm("","post",0,array(),array("Friend")).
                "";
        }
        
        $html.=
            $this->Collaborators_Table_Collaborations_Html($edit,$userid).
            "";

        if ($edit==1)
        {
            $html.=        
                $this->MakeHidden("Friend",$userid).
                $this->MakeHidden("Update",1).
                $this->Buttons().
                $this->EndForm().
                "";
        }

        return $html;
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
        
        $rdatas=$this->CollaborationsObj()->GetGroupDatas("Inscription");
        $datas=array("Homologated","TimeLoad");
        $empties=array("-","-");

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
                   $collaboration,$rdatas,
                   $collaborator,$datas,
                   $empties
                );
                
                array_push($table,$row);
            }
        }

        return $table;
        
    }
        
    
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
}

?>