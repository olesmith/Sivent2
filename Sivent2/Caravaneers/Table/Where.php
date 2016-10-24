<?php


class Caravaneers_Table_Where extends Caravaneers_Table_CGI
{
    //*
    //*
    //* function Caravaneers_Table_Where, Parameter list: $inscription
    //*
    //* Read currently allocated Caravaneers for $inscription.
    //*

    function Caravaneers_Table_Where($inscription)
    {
        $where=
            $this->UnitEventWhere
            (
               array
               (
                  "Friend" => $inscription[ "Friend" ],
               )
            );

        if ($this->LatexMode())
        {
            $where[ "Status" ]=1;
        }

        return $where;
    }
}

?>