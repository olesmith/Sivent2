<?php



trait EventMod_Import_Read
{
    //* function EventMod_Import_Event_SQL_Table, Parameter list: $event=array()
    //*
    //* Reads all events, except current event.
    //*

    function EventMod_Import_Event_SQL_Table($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
       return
            preg_replace
            (
                '/_(\d+)_'.$this->ModuleName.'$/',
                "_".$event[ "ID" ]."_".$this->ModuleName,
                $this->SqlTableName()
            );
    }

    
    //* function EventMod_Import_Events_Read, Parameter list: $item=array()
    //*
    //* Reads all events, except current event.
    //*

    function EventMod_Import_Events_Read()
    {
        $current_event=$this->Event();
        $events=
            $this->EventsObj()->Sql_Select_Hashes
            (
                array(),
                array("ID","Name","Title"),
                "Name"
            );

        foreach (array_keys($events) as $id)
        {
            if ($current_event[ "ID" ]==$events[ $id ][ "ID" ])
            {
                unset($events[ $id ]);
            }
            else
            {
                $events[ $id ][ "Name" ].=
                    " (".
                    $this->Sql_Select_NHashes
                    (
                        array(),
                        $this->EventMod_Import_Event_SQL_Table($events[ $id ])
                    ).
                    " Items)";
            }
            
        }

        return $events;
    }
    
    //* function EventMod_Import_Event_Read_Items, Parameter list: $event=array()
    //*
    //* Reads all items in event module table.
    //*

    function EventMod_Import_Event_Read_Items($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $sql_table=
            preg_replace
            (
                '/_(\d+)_'.$this->ModuleName.'$/',
                "_".$event[ "ID" ]."_".$this->ModuleName,
                $this->SqlTableName()
            );

        return
            $this->Sql_Select_Hashes
            (
                array(),
                $this->EventMod_Import_Events_Datas_Read(),
                "ID",False,
                $this->EventMod_Import_Event_SQL_Table($event)
            );
    }
}

?>