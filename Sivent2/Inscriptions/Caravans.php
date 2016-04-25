<?php


class InscriptionsCaravans extends InscriptionsCollaborations
{
    //*
    //* function Inscriptions_Caravans_Has, Parameter list: 
    //*
    //* Detects if current event has Caravans activated.
    //*

    function Inscriptions_Caravans_Has()
    {
        $event=$this->Event();

        return $this->EventsObj()->Event_Caravans_Has($event);
    }
    
    //*
    //* function Inscriptions_Caravans_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //* Calls EventObj() for the job.
    //*

    function Inscriptions_Caravans_Inscriptions_Open()
    {
        $event=$this->Event();
        return $this->EventsObj()->Event_Caravans_Inscriptions_Open($event);
    }
    
    //*
    //* function Inscription_Caravans_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Caravans_Table_Edit($edit)
    {
        $startdate=$this->Event("Caravans_StartDate");
        $enddate=$this->Event("Caravans_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
    //*
    //* function Inscription_Caravans_Table_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Inscription_Caravans_Table_DateSpan()
    {
        return
            $this->H
            (
               4,
               $this->MyTime_Sort2Date($this->Event("Caravans_StartDate")).
               " - ".
               $this->MyTime_Sort2Date($this->Event("Caravans_EndDate"))
            ).
            "";
    }
    
   //*
    //* function Inscription_Caravans_Table, Parameter list: $edit,$item,$group=""
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Caravans_Table($edit,$item,$group="")
    {
        if (empty($group)) { $group="Caravans"; }

        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$item);
        }

        $caravanstable=$this->Inscription_Caravans_Table_Show($edit,$item);
        
        return
            $this->EventsObj()->Event_Caravans_Table(0,$this->Event(),"Caravans").
            $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])).
            $this->Inscription_Caravans_Table_DateSpan().
            $this->MyMod_Item_Table_Html
            (
               $this->Inscription_Caravans_Table_Edit($edit),
               $item,
               $this->GetGroupDatas($group)
            ).
            $this->Buttons().
            $caravanstable.
            "";
    }
    
    //*
    //* function Inscription_Caravans_Show, Parameter list: $edit,&$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Caravans_Table_Show($edit,&$item)
    {
        if ($item[ "Caravans" ]==1) { return ""; }

        //var_dump(array_keys($this->CaravaneersObj()->ItemData("ID")));
        $this->CaravaneersObj()->ItemData("ID");
        $this->CaravaneersObj()->Sql_Table_Structure_Update();
        $this->CaravaneersObj()->Actions("Show");


        return 
            $this->CaravaneersObj()->CaravaneersObj()->Caravaneers_Table_Show($edit,$item).
            "";
    }
}

?>