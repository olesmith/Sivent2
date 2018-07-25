<?php

include_once("../EventApp/UnitMod.php");
include_once("EventMod/Import.php");
include_once("EventMod/May.php");


class EventMod extends UnitMod
{
    use EventMod_Import,EventMod_May;
    
    var $Uploads_Item2GGI=array("Event","Unit"); //Uploads, reverse path order
    
   //*
    //* function Latex_PDF, Parameter list: $file,$latex
    //*
    //* Filters out Unit and Event and calls parent Latex_PDF.
    //*

    function Latex_PDF($file,$latex, $printpdf = true, $runbibtex = false, $copypdfto = false)
    {
        return $this->ApplicationObj()->Latex_PDF($file,$latex,$printpdf,$runbibtex,$copypdfto);
    }
    //*
    //* function , Parameter list: $date1,$date2
    //*
    //* Returns: formatted date span string.
    //*

    function Date_Span_Interval($item,$key1,$key2)
    {
        $cell=$this->MyTime_Sort2Date($item[ $key1 ]);

        if (!empty($key2) && !empty($item[ $key2 ]))
        {

            if (empty($item[ $key2 ])) { $item[ $key2 ]=$item[ $key1 ]; }
            $date1=$this->MyTime_Date2Hash($item[ $key1 ]);
            $date2=$this->MyTime_Date2Hash($item[ $key2 ]);

            if ($date1[ "Year" ]==$date2[ "Year" ])
            {
                if ($date1[ "Month" ]==$date2[ "Month" ])
                {
                    if ($date1[ "Day" ]==$date2[ "Day" ])
                    {
                        $cell=
                            $date1[ "Day" ]."/".$date1[ "Month" ]."/".$date1[ "Year" ];
                    }
                    else
                    {
                        $cell=
                            $date1[ "Day" ]." - ".$date2[ "Day" ].
                            "/".
                            $date1[ "Month" ]."/".$date1[ "Year" ];
                    }
                }
                else
                {
                    $cell=
                        $date1[ "Day" ]."/".$date1[ "Month" ].
                        " - ".
                        $date2[ "Day" ]."/".$date2[ "Month" ].
                        "/".
                        $date1[ "Year" ];
                }
            }
            else
            {
                $cell=
                    $date1[ "Day" ]."/".$date1[ "Month" ]."/".$date1[ "Year" ].
                    " - ".
                    $date2[ "Day" ]."/".$date2[ "Month" ]."/".$date2[ "Year" ];
            }
        }

        return $cell;
    }

    //*
    //* function , Parameter list: $date1,$date2,$date=0
    //*
    //* Returns:
    //* 0 if $date is smaller than both dates.
    //* 1 if $date inbetween dates
    //* 2 if $date greater that both dates.
    //*

    function Date_Span_Position($item,$key1,$key2,$date=0)
    {
        #today
        if (empty($date)) { $date=$this->MyTime_2Sort(); }
        
        $res=1;
        $date1=$item[ $key1 ];
        $date2=$item[ $key2 ];
        
        if     ($date<$date1 && $date<$date2) { $res=0; }
        elseif ($date>$date1 && $date>$date2) { $res=2; }

        return $res;
    }

    //*
    //* function , Parameter list: $date1,$date2,$date=0
    //*
    //* Returns:
    //* 0 if $date is smaller than both dates.
    //* 1 if $date inbetween dates
    //* 2 if $date greater that both dates.
    //*

    function Date_Span_Position_Status_Message($message_keys,$item,$key1,$key2,$date=0)
    {
        $res=$this->Date_Span_Position($item,$key1,$key2,$date);

        $msg="";
        if (!empty($message_keys[ $res ]))
        {
            $msg=$message_keys[ $res ];
        }

        return $msg;
    }

    //*
    //* function Date_Span_Status, Parameter list: $date1,$date2,$date=0
    //*
    //* Returns formatted messgae according to date dates span status.
    //*

    function Date_Span_Status($item,$key1,$key2,$date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }
        
        
        $res=$this->Date_Span_Position($item,$key1,$key2,$date);

        $key="Events_ToOpen_Title";
        if ($res==1)
        {
            $key="Events_Open_Title";
        }
        elseif ($res==2)
        {
            $key="Events_Closed_Title";
        }

        return $this->MyLanguage_GetMessage($key);
    }


    //*
    //* function Unit_Events_Has, Parameter list: $unit=array()
    //*
    //* Returns TRUE if current unit has events registered.Otherwise FALSE.
    //*

    function Unit_Events_Has($unit=array())
    {
        if (empty($unit)) { $unit=$this->Unit("ID"); }
        if (is_array($unit)) { $unit=$unit[ "ID" ]; }
        
        $res=$this->MyMod_Item_Children_Has
        (
           "EventsObj",
           array("Unit" => $unit)
        );

        return $res;
     }

    //*
    //* function Current_User_Event_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Event_Coordinator_Is($event=array(),$unit=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Coordinator_Is($event,$unit);
    }
    
    //*
    //* function Event_Inscriptions_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_Inscriptions_DateSpan($event=array())
    {
        return $this->EventsObj()->Event_Inscriptions_DateSpan($event);
    }

    //*
    //* function Event_DateSpan, Parameter list: $edit
    //*
    //* Returns date span title.
    //*

    function Event_DateSpan($event=array())
    {
        return $this->EventsObj()->Event_DateSpan($event);
    }

    //*
    //* function Event_Place, Parameter list: $edit
    //*
    //* Returns event place.
    //*

    function Event_Place($event=array())
    {
        return $this->EventsObj()->Event_Place($event);
    }

    //*
    //* function UnitEventWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => and Event => sql where clause.
    //*

    function UnitEventWhere($where=array(),$event=array(),$unit=array())
    {
        if (empty($event)) $event=$this->Event();
        if (empty($unit))  $unit=$this->Unit();

        if (!is_array($event))
        {
            $event=array("ID" => $event);
        }
        
        $where[ "Unit" ]=$unit[ "ID" ];
        $where[ "Event" ]=$event[ "ID" ];

        return $where;
    }


    //*
    //* sub Event, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Event($key="")
    {
        return $this->ApplicationObj()->CGI_GET2Hash("Event","EventsObj",$key,"Event",FALSE);
    }

    //*
    //* function PrintDocHeads, Parameter list: 
    //*
    //* Overrides Application::PrintDocHeads.
    //*

    function PrintDocHeads()
    {
        $this->ApplicationObj()->MyApp_Interface_Head();
    }


    //*
    //* function SetEvent, Parameter list: 
    //*
    //* Sets $this->ApplicationObj->Event to $event.
    //*

    function SetEvent($event)
    {
        $this->ApplicationObj->Event=$event;
    }
    
    //*
    //*
    //* function SqlEventTableName, Parameter list: $table="",$event=array()
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlEventTableName($module,$event=array())
    {
        return $this->ApplicationObj()->SqlEventTableName($module,"",$event);
    }
    
}

?>