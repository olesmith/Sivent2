<?php

class MyFriends_Events_Read extends ModulesCommon
{
    //*
    //* function Friend_Events_Read, Parameter list: $where
    //*
    //* Reads events according to $where.
    //*

    function Friend_Events_Read($where)
    {
        return $this->EventsObj()->Sql_Select_Hashes_ByID($where,array(),"ID","Date DESC");
    }

    //*
    //* function Friend_Events_Read_IDs, Parameter list: $where
    //*
    //* Reads events according to $where.
    //*

    function Friend_Events_Read_IDs($eventids)
    {
        return
            $this->Friend_Events_Read
            (
                array
                (
                    "ID" => $this->Sql_Where_IN($eventids),
                    "Visible" => 1,
                )
            );
    }

    //*
    //* function Friend_Events_Read_Open, Parameter list: $friend=array()
    //*
    //* Reads active events, that is events with open inscriptions.
    //*

    function Friend_Events_Read_All()
    {
        return
            $this->Friend_Events_Read_IDs
            (
                $this->EventsObj()->Sql_Select_Unique_Col_Values("ID")
            );
    }
    
    //*
    //* function Friend_Events_Read_Open, Parameter list: $friend=array()
    //*
    //* Reads active events, that is events with open inscriptions.
    //*

    function Friend_Events_Read_Open()
    {
        return
            $this->Friend_Events_Read_IDs
            (
                $this->EventsObj()->Events_Open_Get()
            );
    }
    
    //*
    //* function Friend_Events_Read_Inscribed, Parameter list: $friend=array()
    //*
    //* Reads suitable events for friend.
    //*

    function Friend_Events_Read_Inscribed($friend=array())
    {
        if (empty($friend))
        {
            $friend=$this->LoginData();
        }
        
        $events=array();
        foreach ($this->EventsObj()->Sql_Select_Unique_Col_Values("ID","","ID") as $event)
        {
            $inscr=
                $this->Sql_Select_Unique_Col_Values
                (
                   "ID",
                   array("Friend" => $friend[ "ID" ]),
                   "ID",
                   $this->ApplicationObj->SqlEventTableName("Inscriptions","",array("ID" => $event))
                );

            if (count($inscr)>0) { $events[ $event ]=TRUE; }
        }
        
        $events=array_keys($events);
        #sort($events,SORT_NUMERIC);

        return $this->Friend_Events_Read_IDs($events);
    }
    
    
}

?>