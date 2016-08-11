<?php


class Presences_Register_Registers_Update extends Presences_Register_Registers_Table
{
    //*
    //* function Presences_Schedule_Registers_Friend_Row_Update, Parameter list: $schedule,$schedules,$friend,&$fpresences
    //*
    //* Updates $schedules presences rows for $friend.
    //*

    function Presences_Schedule_Registers_Friend_Row_Update($schedule,$schedules,$friend,&$fpresences)
    {        
        foreach ($schedules as $fschedule)
        {
            $scheduleid=$fschedule[ "ID" ];
                
            $oldvalue=0;
            if (!empty($fpresences[ $scheduleid ])) { $oldvalue=1; }

            $newvalue=$this->Presences_Schedule_Register_CGI_Value($fschedule,$friend);

            if ($oldvalue!=$newvalue)
            {
                //var_dump("upd ".$friend[ "Name" ].": ".$fschedule[ "Date" ]);
                //var_dump("$oldvalue!=$newvalue");

                if ($newvalue==1)
                {
                    //Make sure entry exists
                    $fpresences[ $scheduleid ]=$this->Presences_Schedule_Friend_Add($fschedule,$friend);
                }
                else
                {
                    //Make sure no entries exists
                    unset($fpresences[ $scheduleid ]);
                    $this->Presences_Schedule_Friend_Delete($fschedule,$friend);
                }
            }
        }
    }
    
    
    //*
    //* function Presences_Schedule_Friend_Add, Parameter list: $schedule,$friend
    //*
    //* Updates $schedules presences rows for $friend.
    //*

    function Presences_Schedule_Friend_Add($schedule,$friend)
    {
        $presences=$this->Presences_Schedule_Friend_Read_Entries($schedule,$friend);

        $presence=array();
        if (empty($presences))
        {
            $presence=$this->Presences_Schedule_Friend_Where($schedule,$friend);
            $this->MyHash_2_Hash_Transfer
            (
               $schedule,
               $presence,
               $this->Presences_Schedule_Transfer_Data()
            );
            
            $this->Sql_Insert_Item($presence);
            //var_dump("added: ".$presence[ "ID" ]);
        }
        else
        {
            if (count($presences)>1)
            {
                var_dump("More than one item already...");
                var_dump($presences);
            }
            
            var_dump("Trying to add, present friend...");
        }
        
        return $presence;
    }

    
    //*
    //* function Presences_Schedule_Friend_Delete, Parameter list: $schedule,$friend
    //*
    //* Deletes $schedules presences rows for $friend.
    //*

    function Presences_Schedule_Friend_Delete($schedule,$friend)
    {
        $presences=$this->Presences_Schedule_Friend_Read_Entries($schedule,$friend);

        $presence=array();
        if (!empty($presences))
        {
            if (count($presences)>1)
            {
                var_dump("More than one item already...");
                var_dump($presences);
            }
            
            foreach ($presences as $presence)
            {
                //var_dump("delete: ".$presence[ "ID" ]);
                $this->Sql_Delete_Item($presence[ "ID" ]);
            }
        }
        else
        {
            var_dump("Trying to delete, absent friend...".count($presences)." entries..");
        }
        
        return $presence;
    }
}

?>