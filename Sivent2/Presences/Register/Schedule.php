<?php

class Presences_Register_Schedule extends Presences_Access
{
    
    //*
    //* function Presences_Register_Schedule_Read, Parameter list: $scheduleid=0
    //*
    //* Handles registrations for schedule.
    //*

    function Presences_Register_Schedule_Read($scheduleid=0)
    {
        if (empty($scheduleid))
        {
            $scheduleid=$this->CGI_POSTOrGETint("Schedule");
        }
        $where=$this->UnitEventWhere(array("ID" => $scheduleid));
        
        return $this->SchedulesObj()->Sql_Select_Hash($where);
    }

        
    //*
    //* function Presences_Register_Schedule_Show, Parameter list: $schedule=array()
    //*
    //* Handles registrations for schedule.
    //*

    function Presences_Register_Schedule_Show($schedule=array())
    {
        if (empty($schedule)) { $schedule=$this->Presences_Register_Schedule_Read(); }

        $table=
            $this->SchedulesObj()->MyMod_Item_Table
            (
               0,
               $schedule,
               $this->Presences_Schedule_Data()
            );

        array_push
        (
           $table,
           array($this->Presences_Register_Submission_Select_Form($schedule))
        );

        return
            $this->H(1,$this->MyLanguage_GetMessage("Precense_Register_Title")).
            $this->SchedulesObj()->Html_Table
            (
               "",
               $table
            ).
            "";
    }
    
    //*
    //* function Presences_Register_Submission_Select_Form, Parameter list: $schedule=array()
    //*
    //* 
    //*

    function Presences_Register_Submission_Select_Form($schedule)
    {
        return
            $this->StartForm().
            $this->Presences_Register_Submission_Select($schedule).
            $this->MakeHidden('GO',1).
            $this->MakeButton('submit',"GO").
            $this->EndForm().
            "";
    }
    
    //*
    //* function Presences_Register_Submission_Select, Parameter list: $schedule=array()
    //*
    //* Creates select field for choosing activity.
    //*

    function Presences_Register_Submission_Select($schedule)
    {
        $where=array();
        $where=$this->UnitEventWhere($where);

        $submissionids=$this->SchedulesObj()->Sql_Select_Unique_Col_Values("Submission",$where);

        $where=array("ID" => $submissionids);
        $where=$this->UnitEventWhere($where);

        $datas=array("ID","Name","Title","Author");
        
        $submissions=$this->SubmissionsObj()->Sql_Select_Hashes_ByID($where,$datas,"ID","Name,Title,Author","ID");
        foreach (array_keys($submissions) as $sid)
        {
            $submissions[ $sid ][ "Name" ]=
                $this->FilterHash("#Name: #Title",$submissions[ $sid ]);
            $submissions[ $sid ][ "Title" ]=
                $this->FilterHash("#Name: #Author",$submissions[ $sid ]);

            $scheduleids=$this->SchedulesObj()->Sql_Select_Unique_Col_Values("ID",array("ID" => $submissions[ $sid ][ "ID" ]));
            $scheduleid=array_shift($scheduleids);
            
            $submissions[ $sid ][ "Value" ]=$scheduleid;
        }

        return
            $this->Html_Select_Hashes2Field
            (
               "Schedule",
               $submissions,
               $schedule[ "ID" ],
               "Name",
               "Title"
            );
    }
}

?>