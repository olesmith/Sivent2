<?php

class MyEventsHandle extends MyEventsCreate
{
    //*
    //* function HandleOpenEvents, Parameter list:
    //*
    //* Handle  open events listing.
    //*

    function HandleOpenEvents()
    {
        $this->InscriptionsObj()->InitActions();

        echo
            $this->OpenEventsHtmlTable().
             "";
    }

    
    //*
    //* function HandleEventDatas, Parameter list:
    //*
    //* Handle EventDatas edit.
    //*

    function HandleEventDatas()
    {
        $this->DatasObj(TRUE);

        echo
            $this->EventDatasInfoTable().
            $this->DatasObj()->EventDatasForm($this->Event()).
            "";

        
     }
}

?>