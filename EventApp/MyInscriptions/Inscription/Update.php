<?php

class MyInscriptions_Inscription_Update extends MyInscriptions_Inscription_Tables
{
    //*
    //* function UpdateInscription, Parameter list: 
    //*
    //* Updates  inscription.
    //*

    function UpdateInscription()
    {
        if (empty($this->Inscription[ "ID" ]))
        {
           if ($this->MayDoInscribe())
            {
                $this->DoInscribe();
            }
        }

        if (!empty($this->Inscription[ "ID" ]))
        {
            $this->Inscription=$this->UpdateItem
            (
               $this->Inscription,
               $this->InscriptionSGroupsDatas(1,TRUE)
            );
        }
    }
}

?>