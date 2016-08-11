<?php

include_once("Registers/CGI.php");
include_once("Registers/Where.php");
include_once("Registers/Read.php");
include_once("Registers/Rows.php");
include_once("Registers/Table.php");
include_once("Registers/Update.php");


class Presences_Register_Registers extends Presences_Register_Registers_Update
{    
    //*
    //* function Presences_Schedule_Registers_Show, Parameter list: $schedule,$schedules
    //*
    //* Shows list of presences in $schedule.
    //*

    function Presences_Schedule_Registers_Show($schedule,$schedules)
    {
        $edit=1;
        $method="Html_Table";
        if ($this->ApplicationObj()->LatexMode) { $method="LatexTable"; $edit=0; }
        
        $table=$this->Presences_Schedule_Registers_Table(1,$schedule,$schedules);
        if (empty($table))
        {
            return
                $this->H(2,$this->MyLanguage_GetMessage("Precenses_Table_Empty_Title")).
                "";
        }
        return
            $this->Html_Form
            (
               $this->H(2,$this->MyLanguage_GetMessage("Precenses_Table_Title")).
               $this->$method
               (
                  $this->Presences_Schedule_Registers_Titles($schedules),
                  $this->Presences_Schedule_Registers_Table($edit,$schedule,$schedules)
               ),
               $edit,
               "",
               array("Register" => 1)
            ).
            "";
        
    }
}

?>