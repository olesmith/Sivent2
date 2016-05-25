<?php

class EventsSubmissions extends EventsCaravans
{
    //*
    //* function Event_Submissions_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Submissions_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=FALSE;
        if (!empty($item[ "Submissions" ]) && $item[ "Submissions" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function Event_Submissions_Inscriptions_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has inscriptions for submissions.
    //*

    function Event_Submissions_Inscriptions_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=$this->Event_Submissions_Has($item);
        if (!empty($item[ "Submissions" ]) && $item[ "Submissions" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function Event_Submissions_Public, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Submissions_Public($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=$this->Event_Submissions_Has($item);
        if (empty($item[ "Submissions_Public" ]) || $item[ "Submissions_Public" ]!=2)
        {
            $res=FALSE;
        }

        return $res;
    }

    //*
    //* function Event_Submissions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Submissions_Open($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Submissions_Inscriptions_Has($item);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$item[ "Submissions_StartDate" ]
                  ||
                  $today>$item[ "Submissions_EndDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }

    //*
    //* function Event_Submissions_Inscriptions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has Submissions.
    //*

    function Event_Submissions_Inscriptions_Open($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Submissions_Has($item);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$item[ "Submissions_StartDate" ]
                  ||
                  $today>$item[ "Submissions_EndDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }

    
    //*
    //* function Event_Submissions_GroupDatas, Parameter list: $item,$group
    //*
    //* Returns data to include in table.
    //*

    function Event_Submissions_GroupDatas($item,$group)
    {
        $datas=array();
        if ($this->Event_Submissions_Has($item))
        {
            $datas=$this->GetGroupDatas($group,TRUE);
        }
        else
        {
            $datas=array("Submissions");
        }

        return $datas;
    }
    
    //*
    //* function Event_Submissions_Inscriptions_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Submissions_Inscriptions_DateSpan($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Interval($event,"Submissions_StartDate","Submissions_EndDate");
    }
    
    //*
    //* function Event_Submissions_Inscriptions_Status, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Submissions_Inscriptions_Status($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return $this->Date_Span_Status($event,"Submissions_StartDate","Submissions_EndDate");
    }

     //*
    //* function Event_Submissions_Table, Parameter list: $edit,$item,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Submissions_Table($edit,$item,$group)
    {
        return 
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->MyMod_Item_Table_Html
            (
               $edit,
               $item,
               $this->Event_Submissions_GroupDatas($item,$group)
            ).
            "";
    }
}

?>