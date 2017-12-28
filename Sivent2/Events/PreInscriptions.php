<?php

class EventsPreInscriptions extends EventsAssessments
{
    //*
    //* function Event_PreInscriptions_Has, Parameter list: $event=array()
    //*
    //* Detects whether we have preinscriptions or not.
    //*

    function Event_PreInscriptions_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        //Older version
        //if (!$this->SubmissionsObj()->Sql_Table_Field_Exists("PreInscriptions")) { return FALSE; }
        
        $where=$this->UnitEventWhere(array("PreInscriptions" => 2),$event);
        
        $nsubmissions=$this->SubmissionsObj()->Sql_Select_NHashes($where);

        $res=FALSE;
        if ($nsubmissions>0) { $res=TRUE; }

        if (empty($event[ "PreInscriptions_StartDate" ]) || empty($event[ "PreInscriptions_EndDate" ]))
        {
            $res=FALSE;
        }

        return $res;
    }
    
    //*
    //* function Event_PreInscriptions_DateSpan, Parameter list: $edit=0,$item=array(),$data=""
    //*
    //* Returns PreInscriptions date span info.
    //*

    function Event_PreInscriptions_DateSpan($edit=0,$item=array(),$data="")
    {
        if (empty($item)) { return $this->MyLanguage_GetMessage("PreInscriptions_Period"); }

        return
            $this->MyTime_Sort2Date($item[ "PreInscriptions_StartDate" ]).
            " - ".
            $this->MyTime_Sort2Date($item[ "PreInscriptions_EndDate" ]).
            "";
    }
    
    //*
    //* function Event_PreInscriptions_Status, Parameter list: $edit=0,$item=array(),$data=""
    //*
    //* Returns PreInscriptions status: open or closed.
    //*

    function Event_PreInscriptions_Status($edit=0,$item=array(),$data="")
    {
        if (empty($item)) { return $this->MyLanguage_GetMessage("Events_Status"); }

        $date=$this->MyTime_2Sort();
        $message="";
        if ($date<$item[ "PreInscriptions_StartDate" ])
        {
            $message="Events_ToOpen_Title";
        }
        elseif ($date<=$item[ "PreInscriptions_EndDate" ])
        {
            $message="Events_Open_Title";
        }
        else
        {
            $message="Events_Closed_Title";
        }
        
        return $this->MyLanguage_GetMessage($message);
    }
    
    //*
    //* function Event_PreInscriptions_Open, Parameter list: $event=array()
    //*
    //* Returns PreInscriptions status: open or closed.
    //*

    function Event_PreInscriptions_Open($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $date=$this->MyTime_2Sort();
        
        $res=FALSE;
        if (
              !empty($event[ "PreInscriptions_StartDate" ])
              &&
              $date>=$event[ "PreInscriptions_StartDate" ]
              &&
              !empty($event[ "PreInscriptions_EndDate" ])
              &&
              $date<=$event[ "PreInscriptions_EndDate" ]
           )
        {
            $res=TRUE;
        }

        return $res;
    }
    
    
}

?>