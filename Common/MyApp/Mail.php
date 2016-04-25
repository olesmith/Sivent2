<?php

trait MyApp_Mail
{
    //*
    //* function MyApp_Mail_Init, Parameter list: 
    //*
    //* Initializes mailing, if no.
    //*

    function MyApp_Mail_Init()
    {
        if ($this->Mail)
        {
            $this->MailInfo=$this->ReadPHPArray($this->MailSetup);
        }

    }

}

?>