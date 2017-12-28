<?php

class MyEventsCells extends MyEventsFriend
{
    //*
    //* function Event_Date_Span, Parameter list: $item=array()
    //*
    //* Generates and returns event date span.
    //*

    function Event_Date_Span($item=array())
    {
        if (empty($item)) { return $this->MyLanguage_GetMessage("Event_DateSpan_Title"); }
        
        $cell=$this->MyTime_Sort2Date($item[ "EventStart" ]);

        if ($item[ "EventStart" ]!=$item[ "EventEnd" ])
        {
            $cell=$this->Date_Span_Interval($item,"EventStart","EventEnd");
        }

        return $cell;
    }
    
    //*
    //* function Event_Inscriptions_Date_Span, Parameter list: $item=array()
    //*
    //* Generates and returns event date span.
    //*

    function Event_Inscriptions_Date_Span($item=array())
    {
        if (empty($item)) { return $this->MyLanguage_GetMessage("Event_Inscriptions_DateSpan_Title"); }
        
        $cell=$this->MyTime_Sort2Date($item[ "StartDate" ]);

        if ($item[ "StartDate" ]!=$item[ "EndDate" ])
        {
            $cell=$this->Date_Span_Interval($item,"StartDate","EndDate");
        }

        return $cell;
    }
    
    //*
    //* function Event_Inscriptions_Date_Span, Parameter list: $item=array()
    //*
    //* Generates and returns event date span.
    //*

    function Event_Inscriptions_Editable_Date($item=array())
    {
        if (empty($item)) { return $this->MyLanguage_GetMessage("Event_Inscriptions_Editable_Title"); }
        
        $cell=$this->MyTime_Sort2Date($item[ "EditDate" ]);

        return $cell;
    }

    
    //*
    //* function InscribeLink, Parameter list:$event=array(),$edit=0
    //*
    //* Handle  open events listing.
    //*

    function InscribeLink($event=array(),$edit=0)
    {
        if (empty($event)) { return "Inscrição"; }

        $inscribed=-1;
        if ($this->Profile()!="Public")
        {
            $inscribed=
                $this->InscriptionsObj()->MySqlNEntries
                (
                   $this->ApplicationObj->SqlEventTableName("Inscriptions","",$event),
                   array
                   (
                      "Friend" => $this->ApplicationObj->LoginData[ "ID" ],
                      "Event" => $event[ "ID" ]
                   )
                );
        }
        
        $open=TRUE;
        if ($event[ "EndDate" ]<$this->TimeStamp2DateSort())
        {
            $open=FALSE;
        }

        $res="";
        if ($inscribed==0)
        {
            if ($open)
            {
                $res=$this->EventsObj()->MyActions_Entry("Inscribe",$event);
            }
            else
            {
                $res=$this->MyMod_Language_Message("Events_Closed_Title");
            }
        }
        elseif ($inscribed>0)
        {
            $res=$this->EventsObj()->MyActions_Entry("Inscription",$event);
        }

        return preg_replace('/#Event/',$event[ "ID" ],$res);
    }

    
    //*
    //* function InscriptionTableExistsCell, Parameter list:
    //*
    //* Cretaes cell informing wheter inscription table has been created or not.
    //*

    function InscriptionTableExistsCell()
    {
        $cell="Não";
        if ($this->InscriptionsObj()->Sql_Table_Exists())
        {
            $cell="Sim";
        }

        return $cell;
    }
    

    //*
    //* function InscriptionTableUpdateLink, Parameter list: $pertains
    //*
    //* Cretaes link with CGI "CreateTable" set to 1.
    //*

    function InscriptionTableUpdateLink($pertains)
    {
        $args=$this->CGI_URI2Hash();

        $args[ "CreateTable" ]=1;
        $args[ "Pertains" ]=$pertains;

        return $this->Href
        (
           "?".
           $this->CGI_Hash2URI
           (
              $args
           ),
           "Atualizar"
        );
    }

    //*
    //* function NoOfInscriptionsCell, Parameter list:$edit=0,$event=array(),$data=""
    //*
    //* Returns number of inscriptions in sql table.
    //*

    function NoOfInscriptionsCell($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return $this->Language_Message("Events_Inscriptions_Cell_Noof_Title"); }
        
        $ninscribed="-";
        if ($this->InscriptionsObj()->Sql_Table_Exists($sqltable))
        {
            $ninscribed=$this->InscriptionsObj()->Sql_Select_NHashes
            (
               $this->UnitEventWhere(),
               $this->SqlEventTableName("Inscriptions",$event)
            );
        }

        return $ninscribed;
    }
        
    //*
    //* function Events_Open_Is, Parameter list: $event=array()
    //*
    //* Returns true if $evvent has inscriptions
    //*

    function Events_Open_Is($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $today=$this->MyTime_2Sort();

        $res=FALSE;
        if ($event[ "StartDate" ]<=$today && $event[ "EndDate" ]>=$today)
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function Events_Open_Premature, Parameter list: $event=array()
    //*
    //* Returns true if $event will open inscriptions later.
    //*

    function Events_Open_Premature($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $today=$this->MyTime_2Sort();

        $res=FALSE;
        if ($event[ "StartDate" ]>$today)
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function Events_Open_Get, Parameter list: 
    //*
    //* Returns open events.
    //*

    function Events_Open_Get()
    {
        $today=$this->MyTime_2Sort();
        return
            $this->Sql_Select_Unique_Col_Values
            (
               "ID",
               "StartDate<='".$today."'".
               " AND ".
               "EndDate>='".$today."'",
               "ID"
            );
    }

    
    //*
    //* function Events_Status_Cell, Parameter list: $event=array()
    //*
    //* Returns open/closed/premature status cell message.
    //*

    function Events_Status_Cell($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $msg="Events_Inscriptions_Cell_Status_Closed";
        if ($this->Events_Open_Is($event))
        {
            $msg="Events_Inscriptions_Cell_Status_Open";
        }
        elseif ($this->Events_Open_Premature($event))
        {
            $msg="Events_Inscriptions_Cell_Status_Premature";
        }
        
        return $this->MyLanguage_GetMessage($msg);
    }
}

?>