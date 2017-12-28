<?php

class Friends_Inscriptions extends Friends_Events
{
    var $Inscriptions_Friend_Table_Event_Data=array("Name","EventStart","EventEnd");
    var $Inscriptions_Friend_Table_Inscription_Data=array("Inscription","GenCert","CTime","Status","Name","Email",);
    
    //*
    //* function Friend__Read, Parameter list: $friend=array()
    //*
    //* Reads suitable Inscriptions for friend.
    //*

    function Friend_Inscriptions_Read($friend=array())
    {
        if (empty($friend))
        {
            $friend=$this->LoginData();
        }

        $eventids=$this->UnitsObj()->Event_IDs_Get();

        $inscriptions=array();
        foreach ($eventids as $eventid)
        {
            $table=$this->Unit("ID")."__".$eventid."_Inscriptions";
            $inscriptions[ $eventid ]=
                $this->InscriptionsObj()->Sql_Select_Hashes
                (
                   array
                   (
                      "Unit" => $this->Unit("ID"),
                      "Event" => $eventid,
                      "Friend" => $friend[ "ID" ],
                   ),
                   array(),
                   "",
                   FALSE,
                   $table
                );

            foreach (array_keys($inscriptions[ $eventid ]) as $id)
            {
                $inscriptions[ $eventid ][ $id ][ "Table" ]=$table;
            }
        }

        return $inscriptions;
    }

    //*
    //* function Friend_Inscriptions_Event_Titles, Parameter list: 
    //*
    //* Creates title row.
    //*

    function Friend_Inscriptions_Event_Titles()
    {
        return
            array
            (
               array
               (
                  $this->MultiCell
                  (
                     $this->GetRealNameKey($this->ApplicationObj()->SubModulesVars[ "Events" ],"ItemName"),
                     count($this->Inscriptions_Friend_Table_Event_Data)
                  ),
                  $this->MultiCell
                  (
                     $this->GetRealNameKey($this->ApplicationObj()->SubModulesVars[ "Inscriptions" ],"ItemName"),
                     count($this->Inscriptions_Friend_Table_Inscription_Data)
                  ),
               ),
               array_merge
               (
                  $this->EventsObj()->MyMod_Data_Titles($this->Inscriptions_Friend_Table_Event_Data),
                  $this->InscriptionsObj()->MyMod_Data_Titles($this->Inscriptions_Friend_Table_Inscription_Data)
               )
            );
    }
    
    //*
    //* function Friend_Inscriptions_Event_Row, Parameter list: $friend,$eventid,$einscriptions
    //*
    //* Show $eventid inscriptions for $friend
    //*

    function Friend_Inscriptions_Event_Row($friend,$eventid,$einscriptions)
    {
        $event=$this->EventsObj()->Sql_Select_Hash(array("ID" => $eventid));

        $firsts=array();
        foreach ($this->Inscriptions_Friend_Table_Event_Data as $data)
        {
            array_push($firsts,$this->EventsObj()->MyMod_Item_Cell(0,$event,$data));
        }
        
        $rows=array();
        foreach ($einscriptions as $eventid => $einscription)
        {
            $row=$firsts;
            
            foreach ($this->Inscriptions_Friend_Table_Inscription_Data as $data)
            {
                array_push($row,$this->InscriptionsObj()->MyMod_Item_Cell(0,$einscription,$data));
            }
            
            array_push($rows,$row);
        }
        
        return $rows;
    }
    
    //*
    //* function , Parameter list: $friend=array()
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Inscriptions_Table($friend=array())
    {
        $this->EventsObj()->ItemData();
        $this->EventsObj()->Actions();
        
        $this->InscriptionsObj()->ItemData();
        $this->InscriptionsObj()->Actions();
        
        $inscriptions=$this->Friend_Inscriptions_Read($friend);

        $table=array();
        foreach ($inscriptions as $eventid => $einscriptions)
        {
            $table=array_merge($table,$this->Friend_Inscriptions_Event_Row($friend,$eventid,$einscriptions));
        }

        echo
            $this->H(1,$this->MyLanguage_GetMessage("Friend_Inscriptions_Table_Title")).
            $this->Html_Table
            (
               $this->Friend_Inscriptions_Event_Titles(),
               $table
            ).
            "";
    }
}

?>