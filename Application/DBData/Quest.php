<?php


class DBDataQuest extends DBDataCells
{
    //*
    //* function ShowQuest, Parameter list: 
    //*
    //* Displays trial version of the quest form.
    //* $type==1: Questionairy
    //* $type==2: Assessment.
    //*

    function ShowQuest()
    {
        $method=$this->ApplicationObj()->PertainsSetup
            [ $this->ApplicationObj()->Pertains ]
            [ "Table_Method" ];

        return $this->DBDataObj(TRUE)->$method();
    }
}

?>