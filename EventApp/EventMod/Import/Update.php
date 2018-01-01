<?php



trait EventMod_Import_Update
{
    //* function EventMod_Import_Events_Update_Compulsories, Parameter list: $item
    //*
    //* Returns a module specific $hash of compulsory values.
    //* Supposed to be overriden by specific modules!!!
    //* When overriding, include call to parent (this function).
    //*

    function EventMod_Import_Events_Update_Compulsories($dest_event,$src_item)
    {
        $dest_item=$src_item;
        $dest_item[ "Unit"  ]=$dest_event[ "Unit" ];
        $dest_item[ "Event" ]=$dest_event[ "ID" ];
        
        return $dest_item;
    }

    
    //* function EventMod_Import_Events_Update, Parameter list: $dest_event,$dest_items,$src_event,$src_items
    //*
    //* Updates import form: add items.
    //*

    function EventMod_Import_Events_Update($dest_event,&$dest_items,$src_event,$src_items)
    {
        $import=$this->CGI_POSTint("Import");
        if ($import<=0) { return 0; }

        $added=0;
        foreach ($src_items as $src_item)
        {
            $src_id=$src_item[ "ID" ];

            $cgikey="Import_".$src_id;
            
            $import=$this->CGI_POSTint("Import_".$src_id);

            if ($import==1)
            {
                $exists=False;
                foreach ($dest_items as $dest_item)
                {
                    if ($dest_item[ "ID" ]==$src_id) { $exists=True; }
                }

                if (!$exists)
                {
                    $dest_item=
                        $this->EventMod_Import_Events_Update_Compulsories($dest_event,$src_item);
                    
                    $dest_item[ "Unit" ]=$dest_event[ "Unit" ];
                    $dest_item[ "Event" ]=$dest_event[ "ID" ];

                    $res=
                        $this->Sql_Insert_Item
                        (
                            $dest_item,
                            $this->EventMod_Import_Event_SQL_Table($dest_event)
                        );
                
                    $added++;

                    array_push($dest_items,$dest_item);
                }
            }
        }

        if ($added>0)
        {
            $this->ApplicationObj()->AddHtmlStatusMessage($added." ".$this->ItemsName." added");
            
            #Used as default in source event select in future imports
            $this->EventsObj()->Sql_Update_Item_Value_Set
            (
                $dest_event[ "ID" ],
                "Updated_From",
                $src_event[ "ID" ]
            );
        }

        return $added;
    }
}

?>