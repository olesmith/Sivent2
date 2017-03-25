<?php

trait MyTime
{
    //*
    //* function MyTime_WeekDay, Parameter list: $weekday
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDay($weekday)
    {
        $lkey=$this->MyLanguage_GetLanguageKey();

        if (empty($this->ApplicationObj()->Messages[ "WeekDays" ])) { return ""; }

        $msg="";
        if (!empty($this->ApplicationObj()->Messages[ "WeekDays" ][ "Name".$lkey ]))
        {
            $msg=$this->ApplicationObj()->Messages[ "WeekDays" ][ "Name".$lkey ][ intval($weekday) ];
        }
        else
        {
            $msg=$this->ApplicationObj()->Messages[ "WeekDays" ][ intval($weekday) ];
        }

        return $msg;
    }

    //*
    //* function MyTime_WeekDays, Parameter list:
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDays()
    {
        $lkey=$this->MyLanguage_GetLanguageKey();

        if (empty($this->ApplicationObj()->Messages[ "WeekDays" ])) { return array(); }

        $msg="";
        if (!empty($this->ApplicationObj()->Messages[ "WeekDays" ][ "Name".$lkey ]))
        {
            $msg=$this->ApplicationObj()->Messages[ "WeekDays" ][ "Name".$lkey ];
        }
        
        if (empty($msg) && !empty($this->ApplicationObj()->Messages[ "WeekDays" ]))
        {
            $msg=$this->ApplicationObj()->Messages[ "WeekDays" ];
        }

        return $msg;
    }

    //* function MyTime_Month, Parameter list: $month,$long=FALSE
    //*
    //* Returns languaged $month name.
    //*

    function MyTime_Month($month,$long=FALSE)
    {
        $lkey=$this->MyLanguage_GetLanguageKey();

        $key="Months";
        if ($long) { $key.="Long"; }
        
        return $this->ApplicationObj()->Messages[ $key ][ "Name".$lkey ][ intval($month)-1 ];
    }

    //* function MyTime_Months, Parameter list:
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_Months()
    {
        $lkey=$this->MyLanguage_GetLanguageKey();

        return $this->ApplicationObj()->Messages[ "Months" ][ "Name".$lkey ];
    }

    //* function MyTime_Info, Parameter list:
    //*
    //* Reads file info.
    //*

    function MyTime_Info($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        if ($mtime==0) { return ""; }

        /* $lang=$this->GetLanguage(); */
        /* if ($lang=="") { $lang="PT"; } */

        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);

        $wday=$timeinfo[ "tm_wday" ];

        $timeinfo[ "WeekDay" ]=$this->ApplicationObj()->MyTime_WeekDay($timeinfo[ "tm_wday" ]);

        $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

        return $timeinfo;
    }

    //*
    //* function TimeStamp2Text, Parameter list: $mtime="",$sep=" "
    //*
    //* Format $mtime.
    //*

    function TimeStamp2Text($mtime="",$sep=" ")
    {
        $timeinfo=$this->MyTime_Info();

        return
            $timeinfo[ "WeekDay" ].
            $sep.
            join
            (
               "/",
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               ".",
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    //*
    //* function MyTime_FileName, Parameter list: $mtime="",$sep=" "
    //*
    //* Format $mtime for a file name..
    //*

    function MyTime_FileName($mtime="",$sep="-",$datesep=".",$timesep=".")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $datesep,
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               $timesep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    //* function MyTime_2Sort, Parameter list: $mtime="
    //*
    //* Returns date of $mtime's date key: YYYYMMDD.
    //* Current $mtime, if empty.
    //*

    function MyTime_2Sort($mtime="")
    {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return 
          ($timeinfo[ "tm_year" ]+1900).
          sprintf("%02d",$timeinfo[ "tm_mon" ]+1).          
          sprintf("%02d",$timeinfo[ "tm_mday" ]);
    }
    
    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Date2Hash($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        return
            array
            (
                "Year"  => substr($date,0,4),
                "Month" => substr($date,4,2),
                "Day"   => substr($date,6,2),
            );
    }

    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Sort2Date($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        $date=$this->MyTime_Date2Hash($date);
        
        return 
            $date[ "Day" ]."/".
            $date[ "Month" ]."/".
            $date[ "Year" ];
    }

    
    function MyTime_Date2Sort($date)
    {
        $comps=preg_split('/\//',$date);
        $formats=array("%02d","%02d","%d");

        $text="";
        for ($n=0;$n<count($formats);$n++)
        {
            $val=0;
            if (isset($comps[ $n ]))
            {
                $val=$comps[ $n ];
            }

            $val=sprintf($formats[$n],$val);
            $text=$val.$text;
        }

        return $text;
    }
    
    function MyTime_2Hash($mtime="")
    {
        if (empty($mtime)) { $mtime=time(); }

        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);

        $wday=$timeinfo[ "tm_wday" ];
        if ($wday==0) { $wday=6; }
        else          { $wday--; }

        $timeinfo[ "WeekDay" ]=$this->MyTime_WeekDay($wday);

        $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

        return $timeinfo;
    }
}

?>