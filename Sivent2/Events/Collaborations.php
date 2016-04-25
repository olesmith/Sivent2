<?php

class EventsCollaborations extends EventsCreate
{
    //*
    //* function Event_Collaborations_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Collaborations_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=FALSE;
        if ($item[ "Collaborations" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function Event_Collaborations_Inscriptions_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Collaborations_Inscriptions_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Collaborations_Has($item);
        if ($res)
        {
            $res=FALSE;
            if ($item[ "Collaborations_Inscriptions" ]==2)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* function Event_Collaborations_Inscriptions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Collaborations_Inscriptions_Open($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Collaborations_Inscriptions_Has($item);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$item[ "Collaborations_StartDate" ]
                  ||
                  $today>$item[ "Collaborations_EndDate" ]
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
        if ($this->Event_Collaborations_Has($item))
        {
            $datas=$this->GetGroupDatas($group);
        }
        else
        {
            $datas=array("Collaborations");
        }

        return $datas;
    }
    

     //*
    //* function Event_Collaborations_Table, Parameter list: $edit,$item,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Collaborations_Table($edit,$item,$group)
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