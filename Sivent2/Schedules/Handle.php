<?php


class SchedulesHandle extends SchedulesUpdate
{
    var $Date=array();
    var $Dates=array();
    
    var $Place=array();
    var $Places=array();
    var $Room=array();
    var $Rooms=array();
    var $SubmissionsData=array("ID","Title","Friend","Friend2","Friend3","Author1","Author2","Author2");
    var $Submissions=array();
    var $Speakers=array();
    var $Schedules_Submissions=array();
    var $Schedules_Authors=array();
     
    //*
    //* function HandleScheduleSelectTable, Parameter list: 
    //*
    //* Central schedule handler.
    //*

    function HandleScheduleSelectsTable()
    {
        return
            array
            (
               array($this->H(2,$this->MyLanguage_GetMessage("Schedule_Limit_Title"))),
               array
               (
                  $this->B("Data:"),
                  $this->DatesSelectField(),
                  $this->B("Local:"),
                  $this->PlacesSelectField(),
               ),
               array($this->Button("submit","GO")),
            );
    }

    //*
    //* function HandleScheduleSelectsForm, Parameter list: 
    //*
    //* Central schedule handler.
    //*

    function HandleScheduleSelectsForm()
    {
        return
            $this->StartForm().
            $this->H(1,$this->GetRealNameKey($this->Event(),"Title")).
            $this->FrameIt($this->HandleScheduleSelectsTable()).
            $this->EndForm().
            "";
    }
    
    //*
    //* function HandleSchedule, Parameter list: 
    //*
    //* Central schedule handler.
    //*

    function HandleSchedule()
    {
        $this->ReadSubmissions();
        
        $edit=0;
        if (preg_match('/^EditSchedule$/',$this->CGI_GET("Action"))) { $edit=1; }
        
        $start=$end="";
        if ($edit==1)
        {
            $start=$this->StartForm();
            $end=
                $this->MakeHidden("Save",1).
                $this->EndForm().
                "";
        }
        
        echo
            $this->H(1,$this->MyLanguage_GetMessage("Schedule_Title")).
            $this->Html_Table
            (
               "",
               array
               (
                  $this->HandleScheduleSelectsForm().
                  $start.
                  join
                  (
                     $this->BR(),
                     $this->DatesSchedulesTables($edit)
                  ).
                  $end
               )
            ).
            "";
            
    }
}

?>