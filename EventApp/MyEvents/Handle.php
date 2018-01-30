<?php

class MyEvents_Handle extends MyEvents_Certificates
{
    //*
    //* function HandleOpenEvents, Parameter list:
    //*
    //* Handle  open events listing.
    //*

    function MyEvents_Handle_Open()
    {
        $this->InscriptionsObj()->InitActions();

        echo
            $this->OpenEventsHtmlTable().
             "";
    }

    //*
    //* function MyEvents_Handle_Conf, Parameter list:
    //*
    //* Handle  open events listing.
    //*

    function MyEvents_Handle_Conf($edit=1)
    {
        if (empty($group)) { $group="Basic"; }

        $event=$this->Event();
        
        echo
            $this->H
            (
                1,
                $this->GetRealNameKey
                (
                    $this->Actions("Conf"),
                    "Title"
                )
            ).
            $this->Html_Table
            (
                "",
                array
                (
                    array
                    (
                        $this->MyEvents_Handle_Conf_Group($event,$edit,"Conf_Basic"),
                        $this->MyEvents_Handle_Conf_Group($event,$edit,"Conf_Place")
                    ),
                    array
                    (
                        $this->MyEvents_Handle_Conf_Group($event,$edit,"Conf_Occurs"),
                        $this->MyEvents_Handle_Conf_Group($event,$edit,"Conf_Inscriptions"),
                    ),
                    array
                    (
                        $this->MyEvents_Handle_Conf_Group($event,$edit,"Conf_Admin"),
                    ),
                    array($this->Buttons())
                )
            ).
             "";
    }
    
    //*
    //* function MyEvents_Handle_Conf_Basic, Parameter list: ($event,$edit,$group)
    //*
    //* 
    //*

    function MyEvents_Handle_Conf_Group($event,$edit,$group)
    {
        return
            $this->MyMod_Item_Group_Table_HTML
            (
                $edit,
                $group,
                $event
            ).
             "";
    }

}

?>