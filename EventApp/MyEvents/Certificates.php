<?php

class MyEvents_Certificates extends MyEvents_Certificate
{
    //*
    //* function Event_Certificates_Has, Parameter list: $item
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Event_Certificates_Has($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $res=FALSE;
        if (!empty($event[ "Certificates" ]) && $event[ "Certificates" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function Event_Certificates_Published, Parameter list: $event
    //*
    //* Returns true or false, whether event should provide certificates.
    //*

    function Event_Certificates_Published($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $res=$this->EventsObj()->Event_Certificates_Has($event);

        if (empty($event[ "Certificates_Published" ]) || $event[ "Certificates_Published" ]!=2)
        {
            $res=FALSE;
        }

        return $res;
    }


    
    //*
    //* function Event_Certificate_Table, Parameter list: $edit,$event,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Certificate_Table($edit,$event,$group)
    {
        $rdatas=$this->GetGroupDatas($group);

        if ($event[ "Certificates" ]!=2)
        {
            $rdatas=array("Certificates");
        }

        return
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->MyMod_Item_Table_Html($edit,$event,$rdatas).
            "";
    }
}

?>