<?php

class App_Head_Table extends App_Events
{
    //*
    //* function AppEventTableGroup, Parameter list: &$table,$event,$msgkey,$datas,$datekeys
    //*
    //* Overrides EventApp::AppEventInfoTable.
    //*

    function AppEventTableGroup(&$table,$event,$msgkey,$datas,$datekeys)
    {
         $rtable=
            $this->EventsObj()->MyMod_Item_Table
            (
               0,
               $event,
               array($datas)
             );

         $title=$this->MyLanguage_GetMessage($msgkey);
        if (!empty($datekeys))
        {
            if (empty($datekeys[1])) { $datekeys[1]=""; }
            $title.=
                ": ".
                $this->EventsObj()->Date_Span_Interval($event,$datekeys[0],$datekeys[1]);
        }
         
        array_push
        (
           $table,
           array
           (
               $this->B($this->MyLanguage_GetMessage($msgkey).":"),
               $this->EventsObj()->Date_Span_Interval($event,$datekeys[0],$datekeys[1])
           )
        );
        
        if (count($rtable)>0)
        {
            $table=array_merge
            (
               $table,
               array($rtable[0])
            );
        }

   }

    //*
    //* function AppEventInfoTable, Parameter list: $event
    //*
    //* Overrides EventApp::AppEventInfoTable.
    //*

    function AppEventInfoTable($event)
    {
        return $this->EventInfoRow($event);
        
    }
    
    //*
    //* function AppEventInfoPostTable, Parameter list: 
    //*
    //* Overrides EventApp::AppEventInfoTable.
    //*

    function AppEventInfoPostTable()
    {
        $event=$this->Event();

        /* $tabledata= */
        /*     array */
        /*     ( */
        /*        array */
        /*        ( */
        /*           "Name","Date","Status" */
        /*        ), */
        /*        array */
        /*        ( */
        /*           "Place","Place_Address","Place_Site", */
        /*        ), */
        /*        array */
        /*        ( */
        /*           "EventStart","EventEnd","Inscriptions_Public", */
        /*        ), */
        /*     ); */

        /* $table= */
        /*     array_merge */
        /*     ( */
        /*        $this->EventInfoRow($event), */
        /*        $this->EventsObj()->MyMod_Item_Table */
        /*        ( */
        /*           0, */
        /*           $event, */
        /*           $tabledata */
        /*        ) */
        /*     ); */
        
        $table=$this->EventInfoRow($event);
        $groupdefs=
            array
            (
               "Event1" => array
               (
                  "Title" => "Event_Inscriptions_Title",
                  "Data" => array(),
                  "AccessMethod" => "",
                  "Dates" => array("StartDate","EndDate"),
               ),
               "Event2" => array
               (
                  "Title" => "Event_Inscriptions_Edit_Title",
                  "Data" => array(),
                  "AccessMethod" => "",
                  "Dates" => array("StartDate","EditDate"),
               ),
               "Collaborations" => array
               (
                  "Title" => "Event_Inscriptions_Collaborations_Open",
                  "Data" => array(),
                  "AccessMethod" => "Event_Collaborations_Inscriptions_Has",
                  "Dates" => array("Collaborations_StartDate","Collaborations_EndDate"),
               ),
               "Caravans" => array
               (
                  "Title" => "Event_Inscriptions_Caravans_Open",
                  "Data" => array(),
                  "AccessMethod" => "Event_Caravans_Inscriptions_Open",
                  "Dates" => array("Caravans_StartDate","Caravans_EndDate"),
               ),
               "Submissions" => array
               (
                  "Title" => "Event_Inscriptions_Submissions_Open",
                  "Data" => array(),
                  "AccessMethod" => "Event_Submissions_Inscriptions_Has",
                  "Dates" => array("Submissions_StartDate","Submissions_EndDate"),
               ),
               "PreInscriptions" => array
               (
                  "Title" => "Event_Inscriptions_PreInscriptions_Open",
                  "Data" => array(),
                  "AccessMethod" => "Event_PreInscriptions_Has",
                  "Dates" => array("PreInscriptions_StartDate","PreInscriptions_EndDate"),
               ),
            );

        foreach ($groupdefs as $group => $def)
        {
            if (!empty($def[ "AccessMethod" ]))
            {
                $method=$def[ "AccessMethod" ];
                if (!$this->EventsObj()->$method($event))
                {
                    continue;
                }
            }

            $this->AppEventTableGroup
            (
               $table,
               $event,
               $def[ "Title" ],
               $def[ "Data" ],
               $def[ "Dates" ]
            );
        }
               
        return $table;
    }
    
    //*
    //* function EventPlaceCell Parameter list: $event=array()
    //*
    //* Creates cell with event place title. 
    //*

    function EventPlaceCell($event=array())
    {
        $cell="";
        if (!empty($event[ "Place" ]))
        {
            $comps=array($event[ "Place" ]);
            if (!empty($event[ "Place_Address" ]))
            {
                array_push($comps,$event[ "Place_Address" ]);
            }

            if (!empty($event[ "Place_Site" ]))
            {
                array_push($comps,$event[ "Place_Site" ]);
            }
            
            $cell=join(" - ",$comps);
        }

        return $cell;
    }
    
    //*
    //* function EventTitleCell Parameter list: $event=array()
    //*
    //* Creates cell with event title, 
    //*

    function EventTitleCell($event=array())
    {
        $titlecell=
            $this->H(3,$this->GetRealNameKey($event,"Title")).
            $this->H(4,$this->Event_Inscriptions_DateSpan($event)).
            $this->H(5,$this->EventPlaceCell($event)).
            "";

        return $titlecell;
    }

    
    //*
    //* function EventInfoRow Parameter list: $event=array()
    //*
    //* Creates row with event-logos and titlecell.
    //*

    function EventInfoRow($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $logos=$this->EventLogos();

        $titlecell=$this->EventTitleCell($event);

        if (count($logos)==2)
        {
            return
                array
                (
                   array
                   (
                      $this->MultiCell($logos[0],2),
                      $this->MultiCell($titlecell,2),
                      $this->MultiCell($logos[1],2),
                   ),
                );
        }
        elseif (count($logos)==1)
        {
            return
                array
                (
                   array
                   (
                      $this->MultiCell($logos[0],6),
                   ),
                   array
                   (
                      $this->MultiCell($titlecell,6),
                   ),
                );
        }
        else
        {
            return
                array
                (
                   array
                   (
                      $this->MultiCell($titlecell,6),
                   ),
                );
        }
    }

    
    //*
    //* function EventLogos, Parameter list: $event=array()
    //*
    //* Returns event logo as list of (2) imgs.
    //*

    function EventLogos($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $imgs=array();
        for ($no=1;$no<=2;$no++)
        {
            $img=$this->EventsObj()->MyMod_Data_Field_Logo($event,"HtmlIcon".$no);
            if (!empty($img))
            {
                array_push($imgs,$img);
            }
        }

        //Double if no second
        if (count($imgs)==0) { $imgs=array(); }
        //if (count($imgs)==1) { array_push($imgs,$imsgs[0]); }

        return $imgs;
    }
    
}
