<?php


class Presences_Register_Registers_Read extends Presences_Register_Registers_Where
{
    //*
    //* function Presences_Schedule_Friend_Read_Entries, Parameter list: $schedule,$friendid
    //*
    //* Reads $friendid/$schedule entry. Should be unique!
    //*

    function Presences_Schedule_Friend_Read_Entries($schedule,$friendid)
    {
        return
            $this->Sql_Select_Hashes
            (
               $this->Presences_Schedule_Friend_Where($schedule,$friendid),
               array("ID")
            );
    }
    
    //*
    //* function Presences_Schedule_Friends_Presences_Read, Parameter list: $schedule,$schedules
    //*
    //* Reads friend to list in precences table.
    //*

    function Presences_Schedule_Friends_Presences_Read($schedule,$schedules)
    {
        return $this->MyHash_HashesList_Key
        (
            $this->Sql_Select_Hashes
            (
               $this->UnitEventWhere
               (
                  array
                  (
                     "Schedule" => $this->MyHash_HashesList_Values($schedules,"ID"),
                  )
               ),
               array("ID","Friend","Schedule")
            ),
            "Friend"
        );
    }

    //*
    //* function Presences_Schedule_Friends_Presences_Read, Parameter list: $schedule
    //*
    //* Reads friend to list in precences table.
    //*

    function Presences_Schedule_Friends_PreInscriptions_Read($schedule)
    {
        return $this->MyHash_HashesList_Key
        (
            $this->PreInscriptionsObj()->Sql_Select_Hashes
            (
               $this->UnitEventWhere
               (
                  array
                  (
                     "Submission" => $schedule[ "Submission" ],
                  )
               ),
               array("ID","Friend")
            ),
            "Friend"
        );
    }

    
    //*
    //* function Presences_Schedule_Friends_Read, Parameter list: $schedule,$schedules,$presences
    //*
    //* Reads friend to list in precences table.
    //*

    function Presences_Schedule_Friends_Read($schedule,$schedules,$presences)
    {
        return $this->MyMod_Sort_List
        (
           $this->FriendsObj()->Sql_Select_Hashes_ByID
           (
              array
              (
                 "ID" => array_merge
                 (
                    array_keys($this->Presences_Schedule_Friends_PreInscriptions_Read($schedule)),
                    array_keys($presences)
                 ),
              ),
              array("ID","Name","TextName","Email")
           ),
           "TextName"
        );
    }
}

?>