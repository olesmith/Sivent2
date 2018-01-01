<?php



trait EventMod_Import_Titles
{
    

    //* function EventMod_Import_Events_Titles, Parameter list: $dest_event,$items1,$src_event=array(),$items2=array()
    //*
    //* Generates src/dest compare table title row.
    //*

    function EventMod_Import_Events_Titles($dest_event,$dest_items,$src_event,$src_items)
    {
        return
            array
            (
                $this->EventMod_Import_Events_Title_Info($dest_event,$src_event),
                $this->EventMod_Import_Events_Title_Events($dest_event,$dest_items,$src_event,$src_items),
                $this->EventMod_Import_Events_Title_Datas($dest_event,$src_event,$src_items)
            );
    }

    
    //* function EventMod_Import_Event_Name, Parameter list: $event,$items
    //*
    //* Returns Name of $event, if key set.
    //*

    function EventMod_Import_Events_Title_Name($event,$items)
    {
        $name="";
        if (!empty($event[ "Name" ]))
        {
            $name=
                join
                (
                    "<BR>",
                    array
                    (
                        $event[ "Name" ],
                        "ID: ".$event[ "ID" ],
                        "SQL Table: ".$this->EventMod_Import_Event_SQL_Table($event),
                        count($items)." ".$this->ItemsName
                    )
                );
        }

        return $name;
    }
    
    //* function EventMod_Import_Events_Titles, Parameter list: $dest_event,$src_event
    //*
    //* Generates src/dest compare table event title row.
    //*

    function EventMod_Import_Events_Title_Info($dest_event,$src_event)
    {
        $datas=$this->EventMod_Import_Events_Datas_Show();
        
        return
            array
            (
                $this->MultiCell("",1),
                $this->MultiCell
                (
                    $this->MyLanguage_GetMessage("Event_Data_Import_SRC_Title"),
                    count($datas)
                ),
                "&gt;&gt;",
                $this->MultiCell
                (
                    $this->MyLanguage_GetMessage("Event_Data_Import_DEST_Title"),
                    count($datas)
                ),
            );
    }
    //* function EventMod_Import_Events_Titles, Parameter list: $dest_event,$src_event
    //*
    //* Generates src/dest compare table event title row.
    //*

    function EventMod_Import_Events_Title_Events($dest_event,$dest_items,$src_event,$src_items)
    {
        $datas=$this->EventMod_Import_Events_Datas_Show();
        
        return
            array
            (
                $this->MultiCell("",1),
                $this->MultiCell
                (
                    $this->EventMod_Import_Events_Title_Name($src_event,$src_items),
                    count($datas)
                ),
                $this->MyLanguage_GetMessage("Event_Data_Import_Select_All_Title"),
                $this->MultiCell
                (
                    $this->EventMod_Import_Events_Title_Name($dest_event,$dest_items),
                    count($datas)
                ),
            );
    }

    //* function EventMod_Import_Events_Title_Datas, Parameter list: $dest_event,$src_event=array()
    //*
    //* Generates src/dest compare table datas title row.
    //*

    function EventMod_Import_Events_Title_Datas($dest_event,$src_event,$src_items)
    {
        if (empty($src_items)) { return array(); }
        
        $datas=$this->EventMod_Import_Events_Datas_Show();

        $titles=$this->MyMod_Data_Titles($datas);
        
        return
            array_merge
            (
                array("No"),
                $titles,
                array
                (
                    $this->EventMod_Import_Events_CheckBox_All()
                ),
                $titles
            );
    }
}

?>