<?php

include_once("Friend/Cell.php");
include_once("Friend/Row.php");
include_once("Friend/Where.php");
include_once("Friend/Read.php");
include_once("Friend/Update.php");
include_once("Friend/Table.php");
include_once("Friend/Html.php");
include_once("Friend/Form.php");

class Collaborators_Friend extends Collaborators_Friend_Form
{
    var $Collaborators=array();
    var $Collaborations=array();
    

    //*
    //* function Collaborators_Friend_Collaborations_Info, Parameter list:
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Info($edit,$userid,$titlekey="")
    {
        if (empty($titlekey)) { $titlekey="Collaborators_User_Table_Title"; }
        if (count($this->Collaborators)>=0)
        {
            return
                array
                (
                    $this->Htmls_H
                    (
                        3,
                        $this->MyLanguage_GetMessage($titlekey).
                        ": ".
                        $this->FriendsObj()->FriendID2Name($userid)
                    ),
                    $this->Htmls_H
                    (
                        5,
                        $this->MyLanguage_GetMessage("Inscription_Period").
                        ": ".
                        $this->EventsObj()->Event_Collaborations_Inscriptions_DateSpan().
                        ". ".
                        $this->EventsObj()->Event_Collaborations_Inscriptions_Status()
                    ),
                );
        }

        return array();
    }
    
    //*
    //* function Collaborators_Friend_Collaborations_Handle, Parameter list:
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Handle()
    {
        $userid=$this->CGI_GETint("Friend");

        echo
            $this->Htmls_Text
            (
                $this->Collaborators_Friend_Collaborations_Form(1,$userid)
            );
        
    }
}

?>