<?php

class EventsCells extends EventsAccess
{
    //*
    //* function Event_Title_Show, Parameter list: $edit=0,$event=array(),$data=""
    //*
    //* Generates event title cell.
    //*

    function Event_Title_Show($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return $this->MyMod_ItemName(); }

        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Data_Fields_Show("Name",$event),
                array
                (
                    "TITLE" => $this->MyMod_Data_Fields_Show("Title",$event)
                )
            );
    }
    
    //*
    //* function Event_Period_Show, Parameter list: $edit=0,$event=array(),$data=""
    //*
    //* Generates event period show: fromdate-todate.
    //*

    function Event_Period_Show($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return $this->MyLanguage_GetMessage("Event_Period_Title"); }

        return $this->EventsObj()->Event_DateSpan($event);
    }
    
    //*
    //* function Event_Inscriptions_Period_Show, Parameter list: $edit=0,$event=array(),$data=""
    //*
    //* Generates event inscriotions period show: fromdate-todate.
    //*

    function Event_Inscriptions_Period_Show($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return $this->MyLanguage_GetMessage("Event_Inscriptions_Period_Title"); }

        return $this->EventsObj()->Event_Inscriptions_DateSpan($event);
    }
    
    //*
    //* function Event_Period_Show, Parameter list: $edit=0,$event=array(),$data=""
    //*
    //* Generates event period show: fromdate-todate.
    //*

    function Event_Place_Show($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return $this->MyLanguage_GetMessage("Event_Place_Title"); }

        $site="";
        if (!empty($event[ "Place_Site" ]))
        {
            $site=$this->MyMod_Data_Fields_Show("Place_Site",$event);
        }
        
        return
            array
            (
                $event[ "Place" ],
                $event[ "Place_Address" ],
                $site
            );
    }
    
    //*
    //* function Event_Inscription_Action, Parameter list: $edit=0,$event=array(),$data=""
    //*
    //* Generates event inscription cell: inscribe or access inscription.
    //*

    function Event_Inscription_Action($edit=0,$event=array(),$data="")
    {
        if (empty($event)) { return ""; }

        $status=$event[ "Status" ];

        $cell="-";
        if ($this->IsInscribed($event))
        {
            $cell=$this->MyActions_Entry("Inscription",$event);
        }
        elseif ($status==2)
        {
            $cell=$this->MyActions_Entry("Inscribe",$event);
        }

        return $cell;
    }
    
    //*
    //* function Event_Caravans_Info, Parameter list: $event=array()
    //*
    //* Generates event info text.
    //*

    function Event_Inscriptions_Info($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $text="";
        if (!empty($event[ "Info" ]))
        {
            
            $text=
                $this->MyMod_Data_Fields_Text_Show("Info",$event,$event[ "Info" ],array("NoBR" => TRUE)).
                $this->BR();
        }

        
        return $text;
    }
    
     //*
    //* function Event_Caravans_InfoCell, Parameter list: $edit,$item=array()
    //*
    //* Generates event info cell;
    //*

    function Event_Inscriptions_InfoCell($event=array())
    {
        if (empty($event)) { return $this->MyLanguage_GetMessage("Event_Inscriptions_InfoCell_Title"); }

        $msgs=array();
        if ($this->Event_Collaborations_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Collaborations_Has")
            );
        }
        
        if ($this->Event_Submissions_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Submissions_Has")
            );
        }
        
        if ($this->Event_Caravans_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Caravans_Has")
            );
        }

        $cell=$this->Event_Inscriptions_Info($event);
        
        if (count($msgs)>0)
        {
            $cell=$this->HtmlList($msgs);
            if ($this->EventsObj()->Friend_Inscribed_Is($event,$this->LoginData()))
            {
                $cell.=
                    $this->MyLanguage_GetMessage("Event_Inscriptions_InfoCell_Message_Inscribed").
                    "";
            }
            else
            {
                $cell.=
                    $this->MyLanguage_GetMessage("Event_Inscriptions_InfoCell_Message_Inscribe").
                    "";
            }
        }
        
        return $cell;
    }
}

?>