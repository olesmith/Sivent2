<?php

class MyEvents_Handle extends MyEvents_Certificates
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

}

?>