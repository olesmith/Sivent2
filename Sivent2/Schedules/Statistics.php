<?php

class Schedules_Statistics extends Schedules_Update
{
    //*
    //* function Schedules_Statistics_Rows, Parameter list: $event=array()
    //*
    //* Creates Statistics info table rows.
    //*

    function Schedules_Statistics_Rows($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        if (!$this->EventsObj()->Event_Submissions_Has($event)) { return array(); }
        
        return
            array
            (
                array
                (
                    $this->H(4,$this->MyMod_ItemsName())
                ),
                $this->B
                (
                    $this->MyLanguage_GetMessage("Schedules_Statistics_TitleRow")
                ),
                array_merge
                (
                    array
                    (
                        $this->Sql_Select_NHashes
                        (
                            array
                            (
                                "Unit" => $this->Unit("ID"),
                                "Event" => $event[ "ID" ],
                            )
                        ),
                        $this->Schedules_NRooms($event),
                        $this->Schedules_NDates($event),
                        $this->Schedules_NTimes($event),
                        $this->Schedules_TimeLoad($event),
                    ),
                    array("")
                ),
            );

    }
    
    //*
    //* function Schedules_NRooms, Parameter list: $event=array()
    //*
    //* Creates Statistics info schedules number of rooms cell.
    //*

    function Schedules_NRooms($event=array())
    {
        return 
            $this->Sql_Select_Unique_Col_NValues
            (
                "Room",
                array
                (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $event[ "ID" ],
                )
            );
    }

    //*
    //* function Schedules_NDates, Parameter list: $event=array()
    //*
    //* Creates Statistics info schedules number of rooms cell.
    //*

    function Schedules_NDates($event=array())
    {
        return 
            $this->Sql_Select_Unique_Col_NValues
            (
                "Date",
                array
                (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $event[ "ID" ],
                )
            );
    }

    //*
    //* function Schedules_NTimes, Parameter list: $event=array()
    //*
    //* Creates Statistics info schedules number of rooms cell.
    //*

    function Schedules_NTimes($event=array())
    {
        return
            $this->Sql_Select_Unique_Col_NValues
            (
                "Time",
                array
                (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $event[ "ID" ],
                )
            );
    }

    
    //*
    //* function Schedules_TimeLoad, Parameter list: $event=array()
    //*
    //* Creates Statistics info schedules total timeload cell.
    //*

    function Schedules_TimeLoad($event=array())
    {
        $timeids=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Unit" => $this->Unit("ID"),
                    "Event" => $event[ "ID" ],
                ),
                array("Time")
            );
        
        $timeids=$this->MyHash_HashesList_Key($timeids,$key="Time");

        $chmins=0;
        foreach (array_keys($timeids) as $timeid)
        {
            $chmin=$this->TimesObj()->Sql_Select_Hash_Value($timeid,"Duration");            
            $chmins+=count($timeids[ $timeid ])*$chmin;
        }

        $onehour=60;

        $rchmins=intval($chmins);
        $nhours=$rchmins/$onehour;
        
        $rchmins-=$nhours*$onehour;

        return
            sprintf("%02d",$nhours)." hs ".
            sprintf("%02d",$rchmins)." min".
            "";
     }
    
}

?>