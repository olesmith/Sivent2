<?php

class MyInscriptions_Inscription_Messages extends MyInscriptions_Inscription_Read
{
    //*
    //* function InscriptionMessageRow, Parameter list: $inscription=array()
    //*
    //* Creates Inscription message, based on $inscription
    //*

    function InscriptionMessageRow($inscription=array())
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }

        $msg="";
        if (empty($inscription[ "ID" ]))
        {
            $msg=
                $this->Span
                (
                    $this->Messages("Inscription_Not_Inscribed"),
                    array("CLASS" => 'errors')
                );
        }
        else
        {
            $msg=
                $this->Span
                (
                    $this->Messages("Inscription_Inscribed").
                    " ".
                    $this->InscriptionReceitLink($inscription),
                    array("CLASS" => 'success')
                );
         
        }

        return
            array
            (
                $this->B($this->MyLanguage_GetMessage("Friend_Data_Status_Title").":"),
                $msg
            );
    }
    
    //*
    //* function InscriptionMessageRows, Parameter list: $inscription=array()
    //*
    //* Creates Inscription message, based on $inscription
    //*

    function InscriptionMessageRows($inscription=array())
    {
        $rows=
            array
            (
                $this->InscriptionMessageRow($inscription)
            );

        return $rows;
    }
}

?>