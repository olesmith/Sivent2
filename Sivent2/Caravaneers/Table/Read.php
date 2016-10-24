<?php


class Caravaneers_Table_Read extends Caravaneers_Table_Data
{
    //* function Caravaneers_Table_ReadN, Parameter list: $inscription
    //*
    //* Read currently allocated Caravaneers for $inscription.
    //*

    function Caravaneers_Table_ReadN($inscription)
    {
        return 
            $this->Sql_Select_NHashes($this->Caravaneers_Table_Where($inscription));
    }

    //*
    //* function Caravaneers_Table_Read, Parameter list: $inscription
    //*
    //* Read currently allocated Caravaneers for $inscription.
    //*

    function Caravaneers_Table_Read($inscription)
    {
        return
            $this->Sql_Select_Hashes
            (
               $this->Caravaneers_Table_Where($inscription),
               array(),
               "ID",
               TRUE
            );
    }
}

?>