<?php

class PreInscriptionsInscriptionRead extends PreInscriptionsSubmissions
{
    //*
    //* function PreInscriptions_Submissions_Read_Datas, Parameter list:
    //*
    //* Reads data to show for submissions in pre-inscriptions table.
    //*

    function PreInscriptions_Submissions_Read_Datas()
    {
        $datas=$this->SubmissionsObj()->GetGroupDatas("PreInscriptions");
        $datas[0]="ID";

        return $datas;
    }
    //*
    //* function PreInscriptions_Submissions_Datas, Parameter list:
    //*
    //* Reads data to show for submissions in pre-inscriptions table.
    //*

    function PreInscriptions_Submissions_Show_Datas()
    {
        $datas=$this->PreInscriptions_Submissions_Read_Datas();
        $datas[0]="No";

        return $datas;
    }
    
    
    //*
    //* function PreInscriptions_Inscription_Read, Parameter list: $inscription,$datas=array()
    //*
    //* Reads Schedule Preinscriptions for $incription.
    //*

    function PreInscriptions_Inscription_Read($inscription,$datas=array())
    {
        if (empty($datas)) $datas=array("ID","Friend","Submission");

        if (empty($this->PreInscriptions))
        {
            $this->PreInscriptions=array();
            foreach (
                       $this->Sql_Select_Hashes
                       (
                          $this->PreInscriptions_Submissions_Sql_Where($inscription),
                          $datas
                       ) as $preinscription
                    )
            {
                //By submission id
                $this->PreInscriptions[ $preinscription[ "Submission" ] ]=$preinscription;
            }
        }
       
        return $this->PreInscriptions;
    }
    
    //*
    //* function PreInscriptions_Submissions_Read, Parameter list:
    //*
    //* Reads Schedule Preinscriptions for $incription.
    //*

    function PreInscriptions_Submissions_Read()
    {
        $where=$this->UnitEventWhere(array("PreInscriptions" => 2));
        $datas=$this->PreInscriptions_Submissions_Read_Datas();
        $datas[0]="ID";

        $this->Submissions=$this->SubmissionsObj()->Sql_Select_Hashes($where,$datas,"Name,Title");
    }
    
    //*
    //* function PreInscriptions_Submissions_Read, Parameter list:
    //*
    //* Reads Schedule Preinscriptions for $incription.
    //*

    function PreInscriptions_Submission($submissionid)
    {
        $submission=array();
        foreach ($this->Submissions as $sid => $rsubmission)
        {
            if ($rsubmission[ "ID" ]==$submissionid)
            {
                $submission=$rsubmission;
                break;
            }
        }

        return $submission;
    }
    
    //*
    //* function PreInscriptions_Submissions_Read_Times, Parameter list: 
    //*
    //* Reads $this->Submissions schedule times. Returns id of all times referenced.
    //*

    function PreInscriptions_Submissions_Read_Times()
    {
       //Submissions times
        $timeids=array();
        foreach (array_keys($this->Submissions) as $sid)
        {
            $where=$this->UnitEventWhere(array("Submission" => $this->Submissions[ $sid ][ "ID" ]));
            $rscheduleids=$this->SchedulesObj()->Sql_Select_Unique_Col_Values("ID",$where);

            $times=array();
            foreach ($rscheduleids as $rscheduleid)
            {
                $time=
                    $this->SchedulesObj()->Sql_Select_Hash_Value
                    (
                       array("ID" => $rscheduleid),
                       "Time"
                    );

                array_push($times,$time);
            }
            
            $this->Submissions[ $sid ][ "Times" ]=$times;

            foreach ($times as $time)
            {
                $timeids[ $time ]=TRUE;
            }
        }

        $timeids=array_keys($timeids);

        return $timeids;
    }

}

?>