<?php

class MyInscriptionsInscriptionTables extends MyInscriptionsInscriptionSGroups
{
    
    //*
    //* function InscriptionHtmlTable, Parameter list: $edit,$buttons=FALSE,$inscription,$title="",$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionHtmlTable($edit,$buttons=FALSE,$inscription,$title="",$includeassessments=FALSE)
    {
        $table=$this->InscriptionTable($edit,$buttons,$inscription,$includeassessments);
        if (!empty($title)) { array_unshift($table,$title); }

        return $this->Html_Table("",$table);
    }
    
    //*
    //* function InscriptionEventTable, Parameter list: $edit
    //*
    //* Creates Inscription event data table
    //*

    function InscriptionEventTable($edit)
    {        
        return $this->FrameIt
        (
            $this->Html_Table
            (
               "",
               $this->EventsObj()->MyMod_Item_Group_Tables
               (
                  $this->InscriptionEventTableSGroups,
                  $this->ApplicationObj->Event()
               )
            )
        ).
        $this->BR().
        "";
    }

    //*
    //* function InscriptionFriendTable, Parameter list: $edit,$friend=array()
    //*
    //* Creates Inscription friend data table
    //*

    function InscriptionFriendTable($edit,$friend=array())
    {
        if (empty($friend)) { $friend=$this->Friend; }

        $table=$this->FriendsObj()->ItemTable
        (
           $edit,
           $friend,
           FALSE,
           $this->InscriptionFriendTableData
        );

        array_push
        (
           $table,
           $this->InscriptionMessageRow()
        );

        array_unshift
        (
            $table,
            $this->H
            (
               1,
               $this->Messages("Friend_Table_Title")
            )
        );

        return $table;
    }
    

    //*
    //* function InscriptionDiagList, Parameter list: $inscription
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionDiagList($inscription)
    {
        $lkey="Friend_Data_Diag_";
        
        $messages=array();
        foreach ($this->InscriptionSGroups(0) as $id => $groups)
        {
            foreach ($groups as $group => $edit)
            {
                foreach ($this->MyMod_Item_Group_Data($group,TRUE) as $data)
                {
                    if ($this->MyMod_Data_Field_Is_Compulsory($data))
                    {
                        if (empty($inscription[ $data ]))
                        {
                            array_push
                            (
                               $messages,
                               $this->GetDataTitle($data).
                               ": ".
                               $this->Messages($lkey."Message")."."
                            );
                        }
                    }
                }
            }
        }

        if (count($messages)>0)
        {
            return
                $this->H(5,$this->Messages($lkey."Error").":").
                $this->DIV
                (
                   $this->HtmlList($messages),
                   array("ALIGN" => 'left') 
                );
        }

        return $this->H(5,$this->Messages($lkey."OK").".");
    }
    
    
    //*
    //* function InscriptionTable, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionTable($edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE)
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }

        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $this->SGroups_NumberItems=TRUE;
        $table=$this->MyMod_Item_Group_Tables
        (
           $this->InscriptionSGroups($edit),
           $inscription,
           $buttons
        );

        array_unshift($table,$this->InscriptionDiagList($inscription));

        if ($edit==1 && $buttons) 
        {
            array_push($table,$this->Buttons());
        }

        return $table;
    }
}

?>