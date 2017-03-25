<?php


class Schedules_Handle extends Schedules_Statistics
{
    var $Date=array();
    var $Dates=array();
    
    var $Place=array();
    var $Places=array();
    var $Room=array();
    var $Rooms=array();
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
            //$this->FrameIt($this->HandleScheduleSelectsTable()).
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
        if ($this->CGI_GETOrPOSTint("Latex")==1)
        {
            $this->ApplicationObj()->LatexMode=TRUE;
            $edit=0;
        }

        
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

        if ($this->ApplicationObj()->LatexMode)
        {
            $tables=$this->DatesSchedulesTables(0);

            $latex="";
            foreach ($tables as $rtables)
            {
                foreach ($rtables as $rlatex)
                {
                    $latex.=
                        $rlatex.
                        "\n\n\\clearpage\n\n".
                        "";
                }
            }

            $latex=
                $this->GetLatexSkel("Head.Land.tex").
                $latex.
                $this->GetLatexSkel("Tail.tex").
                "";
               

            //$this->ShowLatexCode($latex);
            $this->RunLatexPrint
            (
               "Presences.".
               //$this->Text2Sort($texfile).".".
               $this->MTime2FName().
               ".tex",
               $latex
             );

            exit();
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