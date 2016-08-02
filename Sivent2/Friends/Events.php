<?php


class FriendsEvents extends FriendsCollaborations
{
    //*
    //* function Friend_Events_Read, Parameter list: $friend=array()
    //*
    //* Reads suitable events for friend.
    //*

    function Friend_Events_Read($friend=array())
    {
        if (empty($friend))
        {
            $friend=$this->LoginData();
        }
        
        $events=array();
        foreach ($this->EventsObj()->Events_Open_Get() as $event)
        {
            $events[ $event ]=TRUE;
        }
        
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
        sort($events,SORT_NUMERIC);

        return $this->EventsObj()->Sql_Select_Hashes(array("ID" => $this->Sql_Where_IN($events)));
    }
    
    //*
    //* function Friend_Event_Rows, Parameter list: $event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Rows($event)
    {
        $row=$this->EventsObj()->MyMod_Item_Row(0,$event,$this->EventsObj()->GetGroupDatas("Basic"));

        return
            array
            (
               $row,
               array
               (
                  "","","","",
                  $this->MultiCell
                  (
                     $this->EventsObj()->Event_Inscriptions_InfoCell($event),
                     count($row)-4,
                     "left"
                  )
               )
            );
    }

    
    //*
    //* function FriendEventsTable, Parameter list: $friend=array()
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Events_Table($friend=array())
    {
        $this->EventsObj()->ItemData();
        $this->EventsObj()->Actions();

        $table=array();
        $n=1;
        foreach ($this->Friend_Events_Read($friend) as $event)
        {
            $event[ "No" ]=$n;
            $table=
                array_merge
                (
                   $table,
                   $this->Friend_Event_Rows($event)
                );
            $n++;
        }
        
        echo
            $this->H(1,$this->MyLanguage_GetMessage("Friend_Events_Table_Title")).
            $this->Html_Table
            (
               $this->EventsObj()->GetDataTitles($this->EventsObj()->GetGroupDatas("Basic")),
               $table
            ).
            "";
        exit();
    }
}

?>