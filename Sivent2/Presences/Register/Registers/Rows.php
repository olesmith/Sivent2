<?php


class Presences_Register_Registers_Rows extends Presences_Register_Registers_Read
{
    //*
    //* function Presences_Schedule_Registers_Titles, Parameter list: $schedules
    //*
    //* Shows list of presences in $schedule.
    //*

    function Presences_Schedule_Registers_Titles($schedules)
    {
        $titles=$this->FriendsObj()->GetDataTitles($this->Presences_Friends_Data());
        $titles1=array();
        foreach (array_keys($titles) as $id) { array_push($titles1,""); }
        $titles2=array();
        foreach (array_keys($titles) as $id) { array_push($titles2,""); }
        
        
        foreach ($schedules as $schedule)
        {
                array_push
                (
                   $titles2,
                   $this->SchedulesObj()->MyMod_Data_Fields_Show("Date",$schedule)
                );
                
                 array_push
                (
                   $titles1,
                   $this->SchedulesObj()->MyMod_Data_Fields_Show("Room",$schedule)
                );
                
                array_push
                (
                   $titles,
                   $this->SchedulesObj()->MyMod_Data_Fields_Show("Time",$schedule)                
                );
        }

        return array($titles1,$titles2,$titles);
    }
    
    //*
    //* function Presences_Schedule_Registers_Friend_Row, Parameter list: $n,$schedule,$schedules,$friend,&$fpresences
    //*
    //* Creates $friend row.
    //*

    function Presences_Schedule_Registers_Friend_Row($edit,$n,$schedule,$schedules,$friend,&$fpresences)
    {
        if ($this->CGI_POSTint("Register")==1)
        {
            $this->Presences_Schedule_Registers_Friend_Row_Update($schedule,$schedules,$friend,$fpresences);
        }
        
        unset($this->FriendsObj()->ItemData[ "Email" ][ "Iconify" ]);
        
        $row=
            $this->FriendsObj()->MyMod_Items_Table_Row
            (
               0,
               $n,
               $friend,
               $this->Presences_Friends_Data()
            );
        
        foreach ($schedules as $fschedule)
        {
            array_push
            (
               $row,
               $this->Presences_Schedule_Register_Friend_Field($edit,$fschedule,$friend,$fpresences)
            );
        }

        return $row;
    }
    
    //*
    //* function Presences_Schedule_Register_Friend_Field, Parameter list: $n,$schedule,$schedules,$friend,&$fpresences
    //*
    //* Returns $schedule/$friend field.
    //*

    function Presences_Schedule_Register_Friend_Field($edit,$fschedule,$friend,$fpresences)
    {
        $scheduleid=$fschedule[ "ID" ];
                
        $checked=FALSE;
        if (!empty($fpresences[ $fschedule[ "ID" ] ])) { $checked=TRUE; }

        $field="";
        if ($edit==1)
        {
            $field=
                $this->Html_Input_CheckBox_Field
                (
                   $this->Presences_Schedule_Register_CGI_Key($fschedule,$friend),
                   1,
                   $checked
                );
        }
        else
        {
            if ($checked) { $field="\$\\cdot\$"; }
        }

        return $field;
    }
}

?>