<?php

class InscriptionsTablesCaravans extends InscriptionsTablesCollaborations
{
    //*
    //* function Inscription_Caravans_Link, Parameter list: 
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Caravans_Link($item)
    {
        $message="Caravans_Inscribe_Link";
        if (!$this->Inscriptions_Caravans_Inscriptions_Open())
        {
            $message="Caravans_Inscriptions_Closed";
        }
        
        if ($item[ "Caravans" ]==2)
        {
            $message="Caravans_Inscribed_Link";
        }

        return $this->Inscription_Type_Link("Caravans",$message);
    }
    
    //*
    //* function Inscription_Caravans_Row, Parameter list: 
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Caravans_Rows($item)
    {
         $eventdatas=array("Caravans","Caravans_StartDate","Caravans_EndDate");
        $inscrdatas=array();
        if ($item[ "Caravans" ]==2)
        {
            array_push($inscrdatas,"Caravans","Caravans_Name","Caravans_NParticipants","Caravans_Status");
        }
        
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "Caravans",
               $this->Inscription_Caravans_Link($item),
               array("Caravans","Caravans_StartDate","Caravans_EndDate"),
               $inscrdatas
            );
    }
    
    //*
    //* function Inscription_Caravans_Table, Parameter list: $edit,$item,$group=""
    //*
    //* Creates inscrition collaboration html table.
    //*

    function Inscription_Caravans_Table($edit,$item,$group="")
    {
        if (!$this->Inscriptions_Caravans_Has()) { return array(); }

        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        $table=$this->Inscription_Caravans_Rows($item);
        $type=$this->InscriptionTablesType($item);
        if ($type!="Caravans")
        {
            return $this->Inscription_Caravans_Rows($item);
        }
        
        
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
        
        $buttons="";
        $html="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
            $html.=$this->StartForm();
        }

        $caravanstable=$this->FrameIt($this->Inscription_Caravans_Table_Show($edit,$item));

        array_push
        (
            $table,
            array
            (
               $this->FrameIt
               (
                  $this->EventsObj()->Event_Caravans_Table_Html(0,$this->Event(),"Caravans")
               )
            ),
            array
            (
               $this->FrameIt
               (
                  $this->H
                  (
                     5,
                     $this->MyLanguage_GetMessage("Inscription_Period").
                     ", ".
                     $this->GetRealNameKey($this->ItemDataSGroups[ $group ]).
                     ": ".
                     $this->Inscription_Caravans_Table_DateSpan()
                  ).
                  $this->MyMod_Item_Table_Html
                  (
                     $this->Inscription_Caravans_Table_Edit($edit),
                     $item,
                     $this->GetGroupDatas($group)
                  ).
                  $buttons
               ),
            ),
            //array($buttons),
            array($caravanstable)
         );

        
        $html.=
            $this->Html_Table("",$table).
            "";

        if ($edit==1)
        {
            $html.=
                $this->MakeHidden("Update",1).
                $this->EndForm();
        }
        
        return array(array($this->FrameIt($html)));
    }
    
    //*
    //* function Inscription_Caravans_Show, Parameter list: $edit,&$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Caravans_Table_Show($edit,&$item)
    {
        if ($edit==1)
        {
            $this->MyMod_Item_Update_SGroup($item,"Caravans");
        }
                                            
        //if ($item[ "Caravans" ]==1) { return "No"; }

        return $this->Inscription_Event_Caravans_Table($edit,$item);
    }
    
    //*
    //* function Inscription_Event_Caravaneers_Table, Parameter list: $edit,&$item
    //*
    //* Creates a table listing inscription colaborations.
    //*

    function Inscription_Event_Caravans_Table($edit,&$item)
    {
        $this->CaravaneersObj()->ItemData("ID");
        $this->CaravaneersObj()->Sql_Table_Structure_Update();
        $this->CaravaneersObj()->Actions("Show");
        
        return 
            $this->CaravaneersObj()->CaravaneersObj()->Caravaneers_Table_Show($edit,$item).
            "";
    }
}

?>