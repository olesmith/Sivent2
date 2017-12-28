<?php

include_once("Emails/Attachments.php");
include_once("Emails/Read.php");
include_once("Emails/Cells.php");
include_once("Emails/Table.php");
include_once("Emails/Form.php");
include_once("Emails/Send.php");

class ItemsEmails extends ItemsEmailsSend
{
    //*
    //* function ShowEmails, Parameter list: $where=array(),$friendkeys=array("Friend"),$fixedvars=array()
    //*
    //* Show email listings.
    //*

    function ShowEmails($rwhere=array(),$friendkeys=array("Friend"),$fixedvars=array())
    {
        if (!is_array($friendkeys)) { $friendkeys=array($friendkeys); }

        $emails=$this->ReadEmails($rwhere,$friendkeys);

        $row=array();
        $titles=array();
        foreach ($friendkeys as $friendkey)
        {
            $title="";
            if ($friendkey=="ID") { $title=$this->ItemsName; }
            else                  { $title=$this->MyMod_Data_Title($friendkey); }

            array_push($titles,$title);

            array_push
            (
               $row,
               $this->H(3,count($emails[ $friendkey ])." Emails")
            );

            $remails=array();
            foreach ($emails[ $friendkey ] as $email)
            {
                array_push
                (
                   $remails,
                   $email[ "Name" ]
                );
            }

            array_push
            (
               $row,
               $this->FrameIt(join(";<BR>",$remails))
            );


        }

        return
            $this->EmailsSearchForm($fixedvars).
            $this->Html_Table
            (
               $titles,
               array($row)
            ).
            "";
    }

    //*
    //* function HandleSendEmails, Parameter list: $where=array(),$friendkeys=array("Friend"),$fixedvars=array()
    //*
    //* Handles form for emailing items.
    //*

    function HandleSendEmails($rwhere=array(),$friendkeys=array("Friend"),$fixedvars=array())
    {
        return $this->SendEmailForm(1,$rwhere,$friendkeys,$fixedvars);
    }




 }
?>