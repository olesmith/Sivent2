<?php


class Friends_Handle extends Friends_Inscriptions
{
    //*
    //* function MyMod_Handle_Show, Parameter list: $friend=array()
    //*
    //* Overrides MyMod_Handle_Show.
    //* Prints list of $friend inscriptions and call parent.
    //*

    function MyMod_Handle_Show($title="")
    {
        echo parent::MyMod_Handle_Show($title);
        
        $this->Friend_Inscriptions_Table($this->ItemHash);    
    }
    
    //*
    //* function MyMod_Handle_Edit, Parameter list: $friend=array()
    //*
    //* Overrides MyMod_Handle_Edit.
    //* Prints list of $friend inscriptions and call parent.
    //*

    function MyMod_Handle_Edit($title="",$formurl=NULL,$title="",$noupdate=FALSE)
    {
        echo parent::MyMod_Handle_Edit($title,$formurl,$title,$noupdate);
        
        $this->Friend_Inscriptions_Table($this->ItemHash);
    }
}

?>