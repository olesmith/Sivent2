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
        
        $collaborations=$this->CollaborationsObj()->Sql_Select_Hashes($where,array(),"Name");

        return $collaborations;
    }
    
    //*
    //* function Collaborators_User_Table_Read, Parameter list: $user
    //*
    //* Reads users collaborations fro db.
    //*

    function Collaborators_User_Table_Read($userid)
    {
        if (empty($this->Items))
        {
            $where=array
            (
               "Friend" => $userid,
            );

            $this->Items=$this->Sql_Select_Hashes($where);
        }

        return $this->Items;
    }
}

?>