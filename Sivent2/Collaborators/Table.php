<?php

include_once("Table/Cell.php");
include_once("Table/Row.php");
include_once("Table/Read.php");
include_once("Table/Update.php");

class CollaboratorsTable extends CollaboratorsTableUpdate
{
    var $Items=array();
    
    
    //*
    //* function Collaborators_User_Table_Show, Parameter list: $edit,$userid,$group="Basic"
    //*
    //* Shows user collaborations table.
    //*

    function Collaborators_User_Table_Show($edit,$userid,$titlekey="",$group="")
    {
        if (empty($titlekey)) { $titlekey="Collaborators_User_Table_Title"; }
        if (empty($group)) { $group="Basic"; }
        
        $this->ItemData("ID");
        $this->ItemDataGroups($group);
        $this->Collaborators_User_Table_Read($userid);

        if (count($this->Items)>=0)
        {
            return
                $this->H
                (
                   3,
                   $this->MyLanguage_GetMessage($titlekey).
                   ": ".
                   $this->FriendsObj()->FriendID2Name($userid)
                ).
                $this->H
                (
                   5,
                   $this->MyLanguage_GetMessage("Inscription_Period").
                   ": ".
                   $this->EventsObj()->Event_Collaborations_Inscriptions_DateSpan().
                   ". ".
                   $this->EventsObj()->Event_Collaborations_Inscriptions_Status()
                ).
                $this->Collaborators_User_Table_Form($edit,$userid,$group);
        }

        return "";
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

        $html="";
        if ($edit==1)
        {
            if ($this->CGI_POSTint("Update")==1)
            {
                $this->Items=$this->UpdateItems($this->Items);
            }
            
            $html.=        
                $this->StartForm().
                $this->Buttons().
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
    
    //*
    //* function Collaborators_Friend_Collaborations_Html, Parameter list:
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Handle()
    {
        $userid=$this->CGI_GETint("Friend");

        echo
            $this->Collaborators_User_Table_Show(1,$userid);
        
    }
}

?>