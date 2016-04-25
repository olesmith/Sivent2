<?php

class MyEventsDataGroups extends MyEventsDatas
{

    //*
    //* function HandleEventDataGroups, Parameter list:
    //*
    //* Handle EventDatas edit.
    //*

    function HandleEventDataGroups()
    {
        $this->GroupDatasObj(TRUE);

        echo
            $this->EventDatasInfoTable().
            $this->GroupDatasObj()->EventGroupDatasForm($this->ItemHash).
            "";

        
     }
}

?>