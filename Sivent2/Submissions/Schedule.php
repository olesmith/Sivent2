<?php



class SubmissionsSchedule extends SubmissionsTable
{
    //*
    //* function Submission_Schedules_Read, Parameter list: $datas,$submission=array()
    //*
    //* Reads and sorts submissions scheduled slots.
    //*

    function Submission_Schedules_Read($datas,$submission=array())
    {
        $where=$this->UnitEventWhere(array("Submission" => $submission[ "ID" ]));
        $schedules=$this->SchedulesObj()->Sql_Select_Hashes($where,$datas);
        
        $rschedules=array();
        foreach (array_keys($schedules) as $sid)
        {
            $schedules[ $sid ][ "Sort" ]=
                $this->TimesObj()->Sql_Select_Hash_Value
                (
                   array("ID" => $schedules[ $sid ][ "Time" ]),
                   "Sort"
                );
        }

        return $this->SortList($schedules,array("Sort","ID"));
    }
    
    //*
    //* function Submission_Schedules, Parameter list: $submission=array()
    //*
    //* Displays submissions scheduled slots.
    //*

    function Submission_Schedules($submission=array())
    {
        $datas=array("ID","Date","Time","Place","Room");
        $rdatas=$datas;
        $rdatas[0]="No";
        
        $where=$this->UnitEventWhere(array("Submission" => $submission[ "ID" ]));

        return
            $this->H(3,$this->MyLanguage_GetMessage("Submissions_Schedule_Table_Title")).
            $this->SchedulesObj()->MyMod_Items_Table_Html
            (
               0,
               $this->Submission_Schedules_Read($datas,$submission),
               $rdatas
            );
    }

}

?>