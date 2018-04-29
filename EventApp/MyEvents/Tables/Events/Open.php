<?php

class MyEventsTablesEventsOpen extends MyEventsInfo
{
    //*
    //* function ReadOpenEvents, Parameter list:
    //*
    //* Reads open events.
    //*

    function ReadOpenEvents()
    {
        if (empty($this->ApplicationObj()->Events))
        {
            $today=$this->TimeStamp2DateSort();

            $this->ApplicationObj()->Events=
                $this->Sql_Select_Hashes
                (
                   array
                   (
                      "Unit" => $this->CGI_GETint("Unit"),
                      "__Date" =>
                        $this->Sql_Table_Column_Name_Qualify("StartDate").
                        "<=".
                        $this->Sql_Table_Column_Value_Qualify($today).
                        " AND ".
                        $this->Sql_Table_Column_Name_Qualify("EndDate").
                        ">=".
                        $this->Sql_Table_Column_Value_Qualify($today),
                   ),
                   array_keys($this->ItemData),
                   FALSE,
                   "Date"
                );
        }
    }

    //*
    //* function OpenEventsHtmlTable, Parameter list:
    //*
    //* Generates open events html table.
    //*

    function OpenEventsHtmlTable()
    {
         //$this->ItemData();
        $this->ItemDataGroups();
       
        $this->ApplicationObj()->EventGroup="Inscriptions";

        $this->ApplicationObj()->Events=array();
        $this->ReadOpenEvents();
        
        return
            $this->H(3,$this->MyMod_Language_Message("Events_Open_Table_Title")).
            $this->Html_Table
            (
                "",
                $this->Events_Table
                (
                    0,
                    $this->ApplicationObj()->Events
                )
            );
    }
}

?>