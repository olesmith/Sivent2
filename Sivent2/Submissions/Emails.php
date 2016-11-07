<?php

class Submissions_Emails extends Submissions_Access
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
        
        echo 
            $this->HandleSendEmails
            (
                array
                (
                ),
                array("Friend","Friend2","Friend3"),
                $fixedvars
            ).
            "";
    }

 
}

?>