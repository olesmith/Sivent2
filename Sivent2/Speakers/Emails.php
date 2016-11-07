<?php

class Speakers_Emails extends Speakers_Access
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
                array("Friend"),
                $fixedvars
            ).
            "";
    }

 
}

?>