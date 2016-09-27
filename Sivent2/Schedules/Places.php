<?php

class SchedulesPlaces extends SchedulesRooms
{
    var $PlacesSelectField="Places";
    var $PlaceGETField="Place";
    
    //*
    //* function Places, Parameter list: 
    //*
    //* Reads event pĺaces, if necessary.
    //*

    function Places()
    {
        if (empty($this->Places))
        {
            $this->Places=
                $this->PlacesObj()->Sql_Select_Hashes_ByID
                (
                   array
                   (
                      "Unit" => $this->Unit("ID"),
                      "Event" => $this->Event("ID"),
                    )
                );
        }

        return $this->Places;
    }
    
    //*
    //* function Place, Parameter list: $pid=""
    //*
    //* Reads event place, if necessary.
    //*

    function Place($pid="")
    {
        if (empty($this->Place))
        {
            $place=$this->CGI_GETOrPOSTint($this->PlaceGETField);
            if (!empty($place))
            {
                $this->Place=
                    $this->PlacesObj()->Sql_Select_Hash
                    (
                       array
                       (
                          "ID" => $place,
                          "Unit" => $this->Unit("ID"),
                          "Event" => $this->Event("ID"),
                        )
                    );
            }
        }

        if (!empty($key)) { return $this->Place[ $key ]; }
        
         return $this->Place;
    }
    
    //*
    //* function SchedulePlaces, Parameter list: 
    //*
    //* Returns dates to include in schedule.
    //*

    function SchedulePlaces()
    {
        $placeids=$this->CGI2Places();

        $places=array();
        foreach ($this->Places() as $rid => $place)
        {
            if (preg_grep('/^'.$place[ "ID" ].'$/',$placeids))
            {
                array_push($places,$place);
            }
        }

        return $places;
    }

    
    //*
    //* function CGI2Places, Parameter list: 
    //*
    //* Creates multiple rooms select field.
    //*

    function CGI2Places()
    {
        $placeids=$this->CGI_POSTint($this->PlacesSelectField);
        if (empty($placeids))
        {
            $place=$this->CGI_GETOrPOSTint($this->PlaceGETField);
            if (!empty($place))
            {
                $placeids=array($place);
            }
            else
            {
                $placeids=array();
                foreach ($this->Places() as $rid => $place)
                {
                    array_push($placeids,$place[ "ID" ]);
                }
            }
        }

        return $placeids;
    }
    
    //*
    //* function PlacesSelectField, Parameter list: $places=array()
    //*
    //* Creates multiple rooms select field.
    //*

    function PlacesSelectField($places=array())
    {
        if (empty($places)) { $places=$this->Places(); }
        
        return
            $this->Html_Select_Multi_Field
            (
               $places,
               $this->PlacesSelectField,
               "ID",
               "#Name",
               "",
               $this->CGI2Places(),
               $addempty=FALSE
            );
    }

    //*
    //* function PlaceScheduleTitle, Parameter list: $date
    //*
    //* Generates date scedule date.
    //*

    function PlaceScheduleTitle($place)
    {
        return
            $this->MyLanguage_GetMessage("Schedule_Place_Title").": ".
            $place[ "Name" ].", ".$place[ "Title" ].
            "";
    }

    
    //*
    //* function PlaceSchedulesTableHtml, Parameter list: $edit,$date,$place
    //*
    //* Generates $date and $place schedule html table.
    //*

    function PlaceSchedulesTableHtml($edit,$date,$place)
    {
        $rooms=$this->ScheduleRooms($place);
        
        if (count($rooms)==0) { return array(); }

         $times=$this->DateTimes($date);
        
        $this->TimesRoomsInitTopology($date,$times,$rooms);
        if ($edit==0)
        {
            //Shrink consecutive activities.
            $this->TimesRoomsEditTopology($times,$rooms);
        }

       $table=
            array
            (
               $this->H
               (
                  2,
                  $this->DateScheduleTitle($date)
               ),
               $this->H
               (
                  3,
                  $this->PlacesObj()->PlaceTitle($place)
               ),
               array
               (
                  "Class" => 'head',
                  "TitleRow" => TRUE,
                  "Row" => $this->TimesScheduleRoomsTitleRow($edit,$date,$place,$rooms),
               ),
            );

        foreach ($times as $id => $time)
        {
            array_push
            (
               $table,
               $this->TimesRoomsTopologyCells($edit,$date,$time,$place,$rooms)
            );
            
            if ($edit==1)
            {
                $table=
                    array_merge
                    (
                       $table,
                       $this->TimesScheduleRoomsDiagnosticsRows($edit,$date,$time,$place,$rooms)
                    );
            }
        }
        
        if ($edit==1)
        {
            array_push($table,array($this->Buttons()));
        }
        
        $method="Html_Table";
        if ($this->ApplicationObj()->LatexMode) { $method="Latex_Table_Multi"; }
        
        return
            array
            (
               $this->H
               (
                  2,
                  $this->DateScheduleTitle($date)
               ).
               $this->H
               (
                  3,
                  $this->PlacesObj()->PlaceTitle($place)
               ).
               $this->$method
               (
                  "",
                  $this->PlaceSchedulesTable($edit,$date,$place)
               )
            );
    }

    
    //*
    //* function PlaceSchedulesTable, Parameter list: $edit,$date,$place
    //*
    //* Generates $date and $place scedule.
    //*

    function PlaceSchedulesTable($edit,$date,$place)
    {
        $rooms=$this->ScheduleRooms($place);
        
        if (count($rooms)==0) { return array(); }

        $times=$this->DateTimes($date);
        
        $this->TimesRoomsInitTopology($date,$times,$rooms);
        if ($edit==0)
        {
            //Shrink consecutive activities.
            $this->TimesRoomsEditTopology($times,$rooms);
        }

       $table=
            array
            (
               array
               (
                  "Class" => 'head',
                  "TitleRow" => TRUE,
                  "Row" => $this->TimesScheduleRoomsTitleRow($edit,$date,$place,$rooms),
               ),
            );
        foreach ($times as $id => $time)
        {
            array_push
            (
               $table,
               $this->TimesRoomsTopologyCells($edit,$date,$time,$place,$rooms)
            );
            
            if ($edit==1)
            {
                $table=
                    array_merge
                    (
                       $table,
                       $this->TimesScheduleRoomsDiagnosticsRows($edit,$date,$time,$place,$rooms)
                    );
            }
        }
        
        if ($edit==1)
        {
            array_push($table,array($this->Buttons()));
        }
        
        return $table;
    }
}

?>