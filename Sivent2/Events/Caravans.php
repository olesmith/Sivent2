<?php

class EventsCaravans extends EventsCollaborations
{
    //*
    //* function Event_Caravans_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Caravans_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=FALSE;
        if (!empty($item[ "Caravans" ]) && $item[ "Caravans" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function Event_Caravans_Inscriptions_Open, Parameter list: $item=array()
    //*
    //* Returns TRUE if event has Caravans.
    //*

    function Event_Caravans_Inscriptions_Open($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }
        if (empty($item)) { return FALSE; }

        $res=$this->Event_Caravans_Has($item);
        if ($res)
        {
            $today=$this->MyTime_2Sort();
            if (
                  $today<$item[ "Caravans_StartDate" ]
                  ||
                  $today>$item[ "Caravans_EndDate" ]
               )
            {
                $res=FALSE;
            }
        }

        return $res;
    }

    
    //*
    //* function Event_Caravans_GroupDatas, Parameter list: $item,$group
    //*
    //* Returns data to include in table.
    //*

    function Event_Caravans_GroupDatas($item,$group)
    {
        $datas=array();
        if ($this->Event_Caravans_Has($item))
        {
            $datas=$this->GetGroupDatas($group,TRUE);
        }
        else
        {
            $datas=array("Caravans");
        }

        return $datas;
    }
    

     //*
    //* function Event_Caravans_Table, Parameter list: $edit,$item,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Caravans_Table($edit,$item,$group)
    {
        return
            array_merge
            (
               array($this->H(3,$this->GetRealNameKey($this->ItemDataSGroups($group)))),
               
               $this->MyMod_Item_Table
               (
                  $edit,
                  $item,
                  $this->Event_Caravans_GroupDatas($item,$group)
               )
            );
    }
    
    //*
    //* function Event_Caravans_Table_Html, Parameter list: $edit,$item,$group
    //*
    //* Creates info table concerning Certificates.
    //*

    function Event_Caravans_Table_Html($edit,$item,$group)
    {
        return
            $this->Html_Table
            (
               "",
               $this->Event_Caravans_Table($edit,$item,$group)
            ).
            "";
    }
}

?>