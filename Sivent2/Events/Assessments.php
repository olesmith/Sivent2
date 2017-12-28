<?php

class EventsAssessments extends EventsSubmissions
{
    //*
    //* function Event_Assessments_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Assessments_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        
        $res=FALSE;
        if (!empty($item[ "Assessments" ]) && $item[ "Assessments" ]==2)
        {
            $res=TRUE;
        }

        if (!$this->Event_Submissions_Has($item))
        {
            $res=False;
        }

        return $res;
    }

    //*
    //* function Event_Assessments_Inscriptions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Assessments_Inscriptions_Open($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Assessments_Has($item);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$item[ "Assessments_StartDate" ]
                  ||
                  $today>$item[ "Assessments_EndDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }

    
    //*
    //* function Event_Collaboration_GroupDatas, Parameter list: $item,$group
    //*
    //* Returns data to include in table.
    //*

    function Event_Collaboration_GroupDatas($item,$group)
    {
        $datas=array();
        if ($this->Event_Assessments_Has($item))
        {
            $datas=$this->GetGroupDatas($group);
        }
        else
        {
            $datas=array("Assessments");
        }

        return $datas;
    }
    
    //*
    //* function Event_Assessments_Inscriptions_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Assessments_Inscriptions_DateSpan($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Interval($event,"Assessments_StartDate","Assessments_EndDate");
    }
    
    //*
    //* function Event_Assessments_Inscriptions_Status, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Assessments_Inscriptions_Status($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Status($event,"Assessments_StartDate","Assessments_EndDate");
    }
    

     //*
    //* function Event_Assessments_Table, Parameter list: $edit,$item,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Assessments_Table($edit,$item,$group)
    {
        return 
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->MyMod_Item_Table_Html
            (
               $edit,
               $item,
               $this->Event_Collaboration_GroupDatas($item,$group)
            ).
            "";
    }
}

?>