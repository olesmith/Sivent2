<?php


class FriendsHandle extends FriendsInscriptions
{
    //*
    //* function MyMod_Handle_Show, Parameter list: $friend=array()
    //*
    //* Overrides MyMod_Handle_Show.
    //* Prints list of $friend inscriptions and call parent.
    //*

    function MyMod_Handle_Show($title="")
    {
        $this->Friend_Inscriptions_Table($this->ItemHash);
    
        parent::MyMod_Handle_Show($title);
    }
    
    //*
    //* function MyMod_Handle_Edit, Parameter list: $friend=array()
    //*
    //* Overrides MyMod_Handle_Edit.
    //* Prints list of $friend inscriptions and call parent.
    //*

    function MyMod_Handle_Edit($title="")
    {
        $this->Friend_Inscriptions_Table($this->ItemHash);
    
        parent::MyMod_Handle_Edit($title);
    }
}

?>