<?php



trait EventMod_Import_Handle
{
    //* function EventMod_Import_Event_CGI, Parameter list: $dest_event,$events
    //*
    //* Detects CGI value of src event.
    //*

    function EventMod_Import_Event_CGI($dest_event)
    {
        $src_eventid=$this->CGI_POSTint("Source_Event");
        if (empty($src_eventid))
        {
            $src_eventid=$dest_event[ "Updated_From" ];
            if (empty($src_eventid))
            {
                $src_eventid=0;
            }
        }

        $src_event=array("ID" => 0);
        if ($src_eventid>0)
        {
            $src_event=$this->EventsObj()->Sql_Select_Hash
            (
                array("ID" => $src_eventid),
                array("ID","Name","Title")
            );
        }
        
        return $src_event;
    }
    
    //* function EventMod_Import_Event_Table, Parameter list: $edit,$dest_event,$dest_items,$src_event
    //*
    //* Creates the import table.
    //*

    function EventMod_Import_Event_Table($edit,$dest_event,$dest_items,$src_event)
    {
        $importable="";
        if (!empty($src_event[ "ID" ]))
        {
            $importable=
                $this->EventMod_Import_Events_Form
                (
                    $edit,
                    $dest_event,
                    $dest_items,
                    $src_event,
                    $this->EventMod_Import_Event_Read_Items($src_event)
                );
        }

        return $importable;
    }
    
    //* function EventMod_Import_Events_Handle, Parameter list: $item=array()
    //*
    //* Import from other event handler.
    //*

    function EventMod_Import_Events_Handle()
    {
        $edit=1;
        
        $events=$this->EventMod_Import_Events_Read();
        array_reverse($events);
        
        $dest_event=$this->Event();
        $dest_items=$this->EventMod_Import_Event_Read_Items($dest_event);

        $src_event=$this->EventMod_Import_Event_CGI($dest_event);
        
        echo
            $this->H
            (
                1,
                $this->MyLanguage_GetMessage("Event_Data_Import_Form_Title").
                ": ".$this->ItemsName
            ).
            $this->EventMod_Import_Menu_Horisontal().
            $this->StartForm().
            $this->H
            (
                2,
                $this->MyLanguage_GetMessage("Event_Data_Import_Select_Title").": ".
                $this->Html_SelectField
                (
                    $events,
                    "Source_Event",
                    "ID",
                    "#Name",
                    "Title",
                    $src_event[ "ID" ]
                ).
                $this->Html_Input_Button_Make("submit","GO")
            ).
            $this->EndForm().
            $this->EventMod_Import_Event_Table
            (
                $edit,
                $dest_event,
                $dest_items,
                $src_event
            ).
            "";
    }
}

?>