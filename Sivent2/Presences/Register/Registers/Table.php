<?php


class Presences_Register_Registers_Table extends Presences_Register_Registers_Rows
{
    //*
    //* function Presences_Schedule_Registers_Table, Parameter list: $schedule,$schedules
    //*
    //* Shows list of presences in $schedules.
    //*

    function Presences_Schedule_Registers_Table($edit,$schedule,$schedules)
    {
        $presences=$this->Presences_Schedule_Friends_Presences_Read($schedule,$schedules);

        $table=array();
        $n=1;
        foreach ($this->Presences_Schedule_Friends_Read($schedule,$schedules,$presences) as $friend)
        {
            $friendid=$friend[ "ID" ];
            $presences[ $friendid ]=$this->MyHash_HashesList_Key($presences[ $friendid ],"Schedule");
            array_push
            (
               $table,
               $this->Presences_Schedule_Registers_Friend_Row
               (
                  $edit,
                  $n++,
                  $schedule,
                  $schedules,
                  $friend,
                  $presences[ $friendid ]
               )
            );
        }

        if ($edit==1 && count($table)>0)
        {
            $buttons=$this->Buttons();
            //array_unshift($table,$buttons);
            array_push($table,$buttons);
        }
        
        return $table;
    }
}

?>