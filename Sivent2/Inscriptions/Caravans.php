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
    //* function Inscriptions_Caravans_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Caravans_Show_Should($item=array())
    {
        $res=
            $this->EventsObj()->Event_Caravans_Has($this->Event())
            /* || */
            /* $this->Inscription_Caravaneers_Has($item) */
            ;

        return $res;
    }
    
    //*
    //* function Inscriptions_Caravans_Show_Name, Parameter list: 
    //*
    //* Generates  name for Submissions link.
    //*

    function Inscriptions_Caravans_Show_Name($data,$item=array())
    {
        $title="";
        if ($this->Inscriptions_Caravans_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions_Caravans_Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Caravans_Show_Title($data,$item=array())
    {
        $title="";
        if ($this->Inscriptions_Caravans_Has($item))
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Caravans_Show_Inscriptions_Title");
        }

        return $title;
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
            $this->MyTime_Sort2Date($this->Event("Caravans_StartDate")).
            " - ".
            $this->MyTime_Sort2Date($this->Event("Caravans_EndDate")).
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
        
        $buttons="";
        $html="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
            $html.=$this->StartForm();
        }

        $caravanstable=$this->Inscription_Caravans_Table_Show($edit,$item);

        $table=
            array_merge
            (
               $this->EventsObj()->Event_Caravans_Table(0,$this->Event(),"Caravans"),
               array
               (
                  $this->H
                  (
                     5,
                     $this->MyLanguage_GetMessage("Inscription_Period").
                     ", ".
                     $this->GetRealNameKey($this->ItemDataSGroups[ $group ]).
                     ": ".
                     $this->Inscription_Caravans_Table_DateSpan()
                  )
               ),
               $this->MyMod_Item_Table
               (
                  $this->Inscription_Caravans_Table_Edit($edit),
                 $item,
                 $this->GetGroupDatas($group)
               ),
               array($buttons),
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
        
        return $this->FrameIt($html);
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