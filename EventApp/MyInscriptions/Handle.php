<?php


class MyInscriptions_Handle extends MyInscriptions_Inscription
{
    //*
    //* function HandleEmails, Parameter list:
    //*
    //* Handle friend inscription. 
    //*

    function HandleEmails()
    {
        $where=array();
        $fixedvars=$where;

        $this->MailFilters=array
        (
           $this->Event(),
        );
        
        echo 
            $this->HandleSendEmails($where,array("Friend"),$fixedvars).
             "";
    }
}

?>