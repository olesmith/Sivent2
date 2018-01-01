<?php

trait EventMod_Import_Form
{
    //* function EventMod_Import_Events_Form, Parameter list: $edit,$dest_event,$dest_items,$event2=array(),$src_items=array()
    //*
    //* Generates src/dest compare from with table.
    //*

    function EventMod_Import_Events_Form($edit,$dest_event,$dest_items,$src_event=array(),$src_items=array())
    {
        if ($edit==1)
        {
            $this->EventMod_Import_Events_Update($dest_event,$dest_items,$src_event,$src_items);
        }

        return
            $this->StartForm().
            $this->Html_Table
            (
                $this->EventMod_Import_Events_Titles
                (
                    $dest_event,
                    $dest_items,
                    $src_event,
                    $src_items
                ),
                $this->EventMod_Import_Events_Table
                (
                    $edit,
                    $dest_event,
                    $dest_items,
                    $src_event,
                    $src_items
                )
            ).
            $this->MakeHidden("Source_Event",$this->CGI_POSTint("Source_Event")).
            $this->MakeHidden("Import",1).
            $this->EndForm().
            "";
            
    }
}

?>