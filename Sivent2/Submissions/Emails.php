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
                $this->Authors_Datas("Friend"),
                $fixedvars
            ).
            "";
    }

 
}

?>