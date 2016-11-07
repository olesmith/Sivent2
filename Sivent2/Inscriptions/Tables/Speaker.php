<?php

class InscriptionsTablesSpeaker extends InscriptionsCells
{
    //*
    //* function Friend_Speaker_Link, Parameter list: 
    //*
    //* Creates inscription speaker info row (no details).
    //*

    function Friend_Speaker_Link()
    {
        return $this->Inscription_Type_Link("Speaker","Speaker_Link");
    }
    
     //*
    //* function Friend_Speaker_Row, Parameter list: 
    //*
    //* Creates $friend speaker info row (no details).
    //*

    function Friend_Speaker_Row($friend,$speaker)
    {                
        return
            $this->Inscription_Type_Rows
            (
               $friend,
               "Speaker",
               $this->Friend_Speaker_Link(),
               array("EventStart","EventEnd")
            );
    }
   
    //*
    //* function Friend_Speaker_Tables, Parameter list: $edit,$friend,$inscription=array()
    //*
    //* Checks whether person in $inscription is a speaker. If so, displays table
    //* with editable travel info and event schedule.
    //*

    function Friend_Speaker_Tables($edit,$friend,$inscription=array())
    {
        $where=$this->UnitEventWhere(array("Friend" => $friend[ "ID" ]));
        $speaker=$this->SpeakersObj()->Sql_Select_Hash($where);

        $form=array(array());
        if (!empty($speaker))
        {
            $edit=$this->SpeakersObj()->CheckEditAccess($speaker);
            
            $type=$this->InscriptionTablesType($inscription);
            if ($type!="Speaker" && !empty($type))
            {
                return $this->Friend_Speaker_Row($inscription,$speaker);
            }
        
            $this->SpeakersObj()->ItemData("ID");
            $this->SpeakersObj()->ItemDataGroups("Basic");
            $this->SpeakersObj()->Actions("Show");
            
            $this->SpeakersObj()->ItemHash=$speaker;

            $button="";
            if ($edit==1)
            {
                $button=
                   $this->Html_Input_Button_Text
                   (
                      $this->MyLanguage_GetMessage("Speaker_Button_Save"),
                      "SaveSpeaker",
                      1
                   );
            }
            
            $form=
                $this->H(3,$this->MyLanguage_GetMessage("Speaker_Data_Table_Title")).
                $this->SpeakersObj()->MyMod_Item_Group_Tables_Form
                (
                   $edit,
                   "SaveSpeaker",
                   $this->SpeakersObj()->MyMod_Item_SGroups($edit,2),
                   $speaker,
                   TRUE,
                   TRUE, //plural
                   "Speaker_",
                   $button
                ).
                $this->Inscription_Speaker_Schedule_Table($speaker).
                "";

            $form=array(array($this->FrameIt($form)));
        }
        
        return $form;
    }
        
    //*
    //* function Inscription_Speaker_Schedule_Table, Parameter list: $speaker
    //*
    //* Creates inscription speaker schedule table.
    //*

    function Inscription_Speaker_Schedule_Table($speaker)
    {
        $datas=array("No","Date","Time","Submission","Place","Room");

        return
            $this->H(3,$this->MyLanguage_GetMessage("Schedule_Speaker_Table_Title")).
            $this->FrameIt
            (
               $this->SchedulesObj()->MyMod_Items_Table_Html
               (
                  0,
                  $this->SchedulesObj()->Speaker2Schedules($speaker,$datas),
                  $datas
               )
            ).
            "";
    }
}

?>