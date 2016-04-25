<?php

class CollaboratorsTableRead extends CollaboratorsTableRow
{
    //*
    //* function Collaborators_Table_Collaborations_Read, Parameter list: 
    //*
    //* Read all event collaborations;
    //*

    function Collaborators_Table_Collaborations_Read()
    {
        $where=array();
        $where[ "Event" ]=$this->Event("ID");
        
        $collaborations=$this->CollaborationsObj()->Sql_Select_Hashes($where);

        return $collaborations;
    }
}

?>