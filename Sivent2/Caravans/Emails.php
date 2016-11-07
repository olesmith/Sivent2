<?php

class Caravans_Emails extends Caravans_Access
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