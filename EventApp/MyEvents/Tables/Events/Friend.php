<?php

class MyEventsTablesEventsFriend extends MyEventsTablesEventsOpen
{
    //*
    //* function ReadFriendEvents, Parameter list: $friend
    //*
    //* Reads events that $friend is inscribed in
    //*

    function ReadFriendEvents($friend,$history=TRUE)
    {
        if (!empty($friend) && empty($this->ApplicationObj()->Events))
        {
            $eventids=$this->Sql_Select_Unique_Col_Values("ID");

            $reventids=array();
            foreach ($eventids as $eventid)
            {
                $inscribed=$this->InscriptionsObj()->MySqlNEntries
                (
                   $this->ApplicationObj->SqlEventTableName
                   (
                      "Inscriptions",
                      "",
                      array("ID" => $eventid)
                   ),
                   array
                   (
                      "Unit" => $this->ApplicationObj()->Unit("ID"),
                      "Event" => $eventid,
                      "Friend" => $friend[ "ID" ],
                   )
                );

                if (!empty($inscribed))
                {
                    array_push($reventids,$eventid);
                }   
            }

            $where=array
            (
               "Unit" => $this->ApplicationObj()->Unit("ID"),
            );

            if (!empty($eventids))
            {
                $where[ "ID" ]=
                    "IN (".
                    $this->Sql_Table_Column_Values_Qualify($eventids).
                    ")";
            }

            if ($history)
            {
                $where[ "__Date" ]=
                    $this->Sql_Table_Column_Name_Qualify("EndDate").
                    "<".
                    $this->Sql_Table_Column_Value_Qualify($this->TimeStamp2DateSort());
            }
                
            $this->ApplicationObj()->Events=
                $this->Sql_Select_Hashes
                (
                   $where,
                   array_keys($this->ItemData),
                   FALSE,
                   "Date"
                );
        }
    }


    //*
    //* function FriendEventsHtmlTable, Parameter list:
    //*
    //* Generates friend events html table.
    //*

    function FriendEventsHtmlTable($friend)
    {
        $this->ApplicationObj()->EventGroup="Inscriptions";

        //Zero to force reread
        $this->ApplicationObj()->Events=array();
        $this->ReadFriendEvents($friend);
        
        if (empty($this->ApplicationObj()->Events)) { return ""; }
        
        return
            $this->H(3,$this->MyMod_Language_Message("Events_History_Table_Title")).
            $this->Html_Table
            (
                "",
                $this->EventsTable()
            );
    }
}

?>