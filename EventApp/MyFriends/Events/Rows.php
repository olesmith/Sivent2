<?php


class MyFriends_Events_Rows extends MyFriends_Events_Read
{
    //*
    //* function Friend_Event_Datas, Parameter list:
    //*
    //* Returns event datas.
    //*

    function Friend_Event_Datas()
    {
        return $this->EventsObj()->MyMod_Data_Group_Datas_Get("Short");
    }

    //*
    //* function Friend_Event_Datas, Parameter list:
    //*
    //* Returns event datas.
    //*

    function Friend_Event_Datas_N()
    {
        return count($this->EventsObj()->MyMod_Data_Group_Datas_Get("Short"));
    }

    
    //*
    //* function Friend_Event_Titles, Parameter list:
    //*
    //* Returns event title row.
    //*

    function Friend_Event_Titles()
    {
        return array
        (
            $this->Html_Table_Head_Row
            (
                $this->EventsObj()->MyMod_Data_Titles
                (
                    $this->Friend_Event_Datas()
                )
            )
        );
    }

    //*
    //* function Friend_Event_Rows, Parameter list: $event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Rows($friend,$event)
    {
        $datas=$this->Friend_Event_Datas();
        
        $rows=array($this->EventsObj()->MyMod_Item_Row(0,$event,$datas));
        $ceventid=$this->CGI_GETint("Event");
        
        if ($ceventid==$event[ "ID" ])
        {
            $rows=
                array_merge
                (
                    $rows,
                    $this->Friend_Event_Certificates_Row($friend,$event),
                    $this->Friend_Event_Payments_Row($friend,$event),
                    $this->Friend_Event_Info_Row($event)
                );
       
        }
        
        return $rows;
    }
    
    //*
    //* function Friend_Event_Info_Cell_Width, Parameter list:
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Info_Cell_Width()
    {
        return $this->Friend_Event_Datas_N()-4;
    }

    
    //*
    //* function Friend_Event_Certificates_Row, Parameter list: $friend,$event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Certificates_Row($friend,$event)
    {
        $table=$this->CertificatesObj()->Certificates_Friend_Tables($friend,$event);

        $row=array();
        if (count($table)>1)
        {
            $title=array_shift($table); //first row is event title
            $row=
                array
                (
                    "",
                    $this->H
                    (
                        5,
                        $this->CertificatesObj()->MyMod_ItemsName().
                        ": ".
                        $this->MyMod_Data_Fields_Show("Name",$event)
                    ).
                    $this->Html_Table
                    (
                        $this->CertificatesObj()->Certificates_Table_Titles(),
                        $table
                    )
                );
        }

        return array($row);
    }

    //*
    //* function Friend_Event_Payments_Row, Parameter list: $friend,$event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Payments_Row($friend,$event)
    {
        $row=array();
        if ($this->EventsObj()->Event_Payments_Has($event))
        {
            $row=
                array
                (
                    "","","","",
                    $this->MultiCell
                    (
                        $this->Friend_Event_Payments_Cell($event),
                        $this->Friend_Event_Info_Cell_Width(),
                        "left"
                    )
                );
        }
                
        return array($row);
    }

    
    //*
    //* function Friend_Event_Info_Row, Parameter list: $event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Info_Cell($event)
    {
        $cell="";
        if (!empty($event[ "Info" ]))
        {
            $cell=
                $this->H(5,$this->MyLanguage_GetMessage("Event_Info_Title").":").
                $this->Span($this->EventsObj()->Event_Inscriptions_InfoCell($event)).
                "";
        }
        
        return $cell;
    }

    
     //*
    //* function Friend_Event_Info_Row, Parameter list: $event
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Event_Info_Row($event)
    {
        $row=array();
        if (!empty($event[ "Info" ]))
        {
            $row=
                array
                (
                    "","","","",
                    $this->MultiCell
                    (
                        $this->Friend_Event_Info_Cell($event),
                        $this->Friend_Event_Info_Cell_Width(),
                        "left"
                    )
                );       
        }
        
        return $row;
    }

   //*
    //* function Friend_Event_Payments_Cell, Parameter list:
    //*
    //* Creates event payments cell.
    //*

    function Friend_Event_Payments_Cell($event)
    {
        //Active event?
        $ceventid=$this->CGI_GETint("Event");
        if ($ceventid!=$event[ "ID" ]) { return ""; }
        
        //Event payments?
        if (!$this->EventsObj()->Event_Payments_Has($event))
        {
            return "";
        }

        
        $html=
            $this->H(5,$this->EventsObj()->MyMod_Data_Title("Payments_Type").":").
            $this->BR().
            $this->EventsObj()->MyMod_Item_Table_Html
            (
                0,
                $event,
                array
                (
                    "Payments_Institution",
                    "Payments_Name",
                    "Payments_Agency",
                    "Payments_Operation",
                    "Payments_Account",
                    "Payments_Variation",
                )
            ).
            $this->BR().
            $this->H(5,$this->MyLanguage_GetMessage("Event_Payments_Info_Table_Title").":").
            $this->Friend_Event_Payments_Values($event).
            $this->BR().
            "";

        if (!empty($event[ "Payments_URL" ]))
        {
            $html.=
                $this->MyLanguage_GetMessage("Event_Payments_Info_URL_Title").":".
                $this->A
                (
                    $event[ "Payments_URL" ],
                    $event[ "Payments_URL" ],
                    array("TARGET" => "_blank")
                ).
                $this->BR().$this->BR().
                "";
        }

        $html.=$event[ "Payments_Info" ];
            
        return $html;
        
    }

    //*
    //* function Friend_Event_Payments_Values, Parameter list:
    //*
    //* Creates event payments values table.
    //*

    function Friend_Event_Payments_Values($event)
    {
        $where=$this->UnitEventWhere();
        $where[ "Event" ]=$event[ "ID" ];
        $this->LotsObj()->ItemData();
        
        $types=$this->TypesObj()->Sql_Select_Hashes($where);
        $lots=$this->LotsObj()->Sql_Select_Hashes($where);

        $table=array();
        $datas=array("No","LimitDate");


        foreach ($types as $type)
        {
            array_push($datas,"Value_".$type[ "ID" ]);
        }
        
        $titles=$this->LotsObj()->MyMod_Data_Titles($datas);

        $titles[0]=$this->LotsObj()->MyMod_ItemName()." ".$titles[0];
        
        
        $n=1;
        foreach ($lots as $lot)
        {
            $row=$this->LotsObj()->MyMod_Items_Table_Row(0,$n,$lot,$datas);

            array_push($table,$row);
        }

        return $this->Html_Table($titles,$table);
    }
  
}

?>