<?php

class InscriptionsRead extends InscriptionsOverrides
{
    //*
    //* function Inscriptions_Read_Friend_IDs, Parameter list: $where=array()
    //*
    //* Returns friend IDs inscribed, according to $where.
    //*

    function Inscriptions_Read_Friend_IDs($where=array())
    {
        return $this->Sql_Select_Unique_Col_Values("Friend",$where);
    }

}

?>