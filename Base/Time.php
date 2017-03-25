<?php


class Time extends Language
{
    //var $TimeDataMessages="Time.php";
    var  $WDays=NULL;

    var $SetTimeNames=array();
    var $SetTimes=array();
    var $Timings=array();

    function InitTime()
    {
        /* $this->WDays=$this->GetMessage($this->TimeDataMessages,"WDays"); */
        /* $this->WeekDays=$this->GetMessage($this->TimeDataMessages,"WeekDays"); */
        /* $this->MonthsLong=$this->GetMessage($this->TimeDataMessages,"MonthsLong"); */
        /* $this->Months=$this->GetMessage($this->TimeDataMessages,"Months"); */

        array_push($this->SetTimeNames,"Exec");
        array_push($this->SetTimes,time());
    }

    function InitTimer($name)
    {
        if ($this->Debug==0) { return; }

        array_push($this->SetTimeNames,$name);
        array_push($this->SetTimes,time());
    }

    function WDays()
    {
        if (!$this->WDays)
        {
            $this->WDays=$this->GetRealNameKey($this->TimeDataMessages,"WDays");
        }

        return $this->WDays;
    }
    function WDay($wday)
    {
        return $this->WDays[ $wday ];
    }

    
    function SaveTimer()
    {
        if ($this->Debug==0) { return; }

        $elapsed=array_pop($this->SetTimes);
        $elapsed=time()-$elapsed;

        $hours=floor($elapsed/3600);
        $elapsed-=$hours*3600;

        $mins=floor($elapsed/60);
        $elapsed-=$mins*60;

        $string=array_pop($this->SetTimeNames).": ";
        if ($hours>0) { $string.=$hours."h "; }
        if ($hours>0 || $mins>0) { $string.=$hours."h "; }
         $string.=$elapsed."s ";
        array_push($this->Timings,$string);
    }

  function DateText($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }

      $lang=$this->GetLanguage();

      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);

      //$timeinfo[ "WeekDay" ]=$this->WeekDays[ $lang ][ $timeinfo[ "tm_wday" ] ];

      return
          join("/",array($timeinfo[ "MDay" ],$timeinfo[ "Month" ],$timeinfo[ "Year" ]));   
  }

  function DateTextExtensive($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }

      $lang=$this->GetLanguage();
      if ($lang=="") { $lang="PT"; }

      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);


      $monthname=$this->GetMessage
      (
         $this->TimeDataMessages,
          "MonthsLong"
       );

      return
          $timeinfo[ "MDay" ].
          " de ".
          $monthname[ $timeinfo[ "tm_mon" ] ]." de ".
          $timeinfo[ "Year" ];   
  }
  function DateLatexExtensive($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }

      $lang=$this->GetLanguage();
      if ($lang=="") { $lang="PT"; }

      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);


      $monthname=$this->GetMessage
      (
         $this->TimeDataMessages,
          "MonthsLong"
       );

      return
          "\\underline{".$timeinfo[ "MDay" ]."}/".
          "\\underline{".$monthname[ $timeinfo[ "tm_mon" ] ]."}/".
          "\\underline{".$timeinfo[ "Year" ]."}";   
  }

  function STimeStamp2Text($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }

     $mtime=intval($mtime);
     $timeinfo=localtime($mtime,TRUE);

     $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
     $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
     $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

     return join(":",array($timeinfo[ "Hour" ],$timeinfo[ "Min" ],$timeinfo[ "Sec" ]));          
  }

  function Date2Sort($date)
  {
      return $this->MyTime_Date2Sort($date);
  }

  function TimeStamp2DateSort($mtime="")
  {
      return $this->MyTime_2Sort($mtime);
  }

  function TimeStamp2HourMinSort($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
      $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);

      return $timeinfo[ "Hour" ].$timeinfo[ "Min" ];          
  }

  function LTimeStamp2DateSort($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);
      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
      $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
      $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

      return $timeinfo[ "Year" ].$timeinfo[ "Month" ].$timeinfo[ "MDay" ].".".
             $timeinfo[ "Hour" ].$timeinfo[ "Min" ].$timeinfo[ "Sec" ];          
  }

  function MTime2FName($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);
      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
      $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
      $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

      return $timeinfo[ "Year" ].".".$timeinfo[ "Month" ].".".$timeinfo[ "MDay" ]."-".
             $timeinfo[ "Hour" ].".".$timeinfo[ "Min" ].".".$timeinfo[ "Sec" ];          
  }

  function CurrentYear($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_year" ]+1900;
  }

  function CurrentDate($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_mday" ];
  }

  function CurrentMonth($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_mon" ]+1;
  }

  function CurrentHour($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_hour" ];
  }

  function CurrentMinute($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_min" ];
  }

  function CurrentSecond($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return $timeinfo[ "tm_sec" ];
  }



  function MTime2Name($mtime="")
  {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
      $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);
      $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
      $timeinfo[ "Hour" ]=sprintf("%02d",$$timeinfo[ "tm_hour" ]);
      $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
      $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

      return $timeinfo[ "MDay" ]."/".$timeinfo[ "Month" ]."/".$timeinfo[ "Year" ]." ".
             $timeinfo[ "Hour" ].":".$timeinfo[ "Min" ];          
  }



  function SortTime2Date($date)
  {
      return $this->MyTime_Sort2Date($date);
  }

  function AddMonths2Date($date,$nmonths=1)
  {
      $comps=preg_split('/\//',$date);
      if (count($comps)>=3)
      {
          $year=$comps[2];
          $mon=$comps[1];
          $date=$comps[0];

          $mon+=$nmonths;
          while ($mon>12) { $year--; $mon-=12; }

          return sprintf("%02d/%02d/%d",$date,$mon,$year);
      }

      return $date;
  }

  function AddMonths2SortDate($date,$nmonths=1)
  {
      $year=substr($date,0,4);
      $mon=substr($date,4,2);
      $date=substr($date,6,2);

      $mon+=$nmonths;
      while ($mon>12) { $year--; $mon-=12; }

      return sprintf("%d%02d%02d",$year,$mon,$date);

      return $date;
  }

  function Date2SortTime($date)
  {
      $comps=preg_split('/\//',$date);
      if (count($comps)>=3)
      {
          $date=$comps[2].$comps[1].$comps[0];
      }

      return $date;
  }

  function Date2WeekDay($date,$month,$year)
  {
      $julian=gregoriantojd($month,$date,$year);
      $wday=jddayofweek($julian)+1;

      if ($wday==1)
      {
          $wday=7;
      }
      else
      {
          $wday--;
      } 

      return $wday;
  }
  
    //*
    //* function GetNextDate, Parameter list: $sortkey
    //*
    //* Returns the next date.
    //*
    //*

    function GetNextDate($sortkey)
    {
        $year=substr($sortkey,0,4);
        $mon=substr($sortkey,4,2);
        $date=substr($sortkey,6,2);

        if ($date<28)
        {
            $date++;
        }
        elseif ($mon==2)
        {
            $mon++;
            $date=1; //leap year not considered
        }
        elseif ($mon==4 || $mon==6 || $mon==9 || $mon==11)
        {
            if ($date<30)
            {
                $date++;
            }
            else
            {
                $mon++;
                $date=1;
            }
        }
        else
        {
            if ($date<31)
            {
                $date++;
            }
            else
            {
                if ($mon<12)
                {
                    $mon++;
                    $date=1;
                }
                else
                {
                    $year++;
                    $mon=1;
                    $date=1;
                 }
            }
        }

        return $year.sprintf("%02d",$mon).sprintf("%02d",$date);
    }

    //*
    //* function GetPrevDate, Parameter list: $sortkey
    //*
    //* Returns the previous date.
    //*
    //*

    function GetPrevDate($sortkey)
    {
        $year=substr($sortkey,0,4);
        $mon=substr($sortkey,4,2);
        $date=substr($sortkey,6,2);

        if ($date>1)
        {
            $date--;
        }
        elseif ($mon==3) //february
        {
            $mon--;
            $date=28; //leap year not considered
        }
        elseif ($mon==5 || $mon==7 || $mon==10 || $mon==12)
        {
            $mon--;
            $date=30;
        }
        elseif ($mon>1)
        {
            $mon--;
            $date=31;
        }
        else
        {
            $year--;
            $mon=12;
            $date=31;
        }

        return $year.sprintf("%02d",$mon).sprintf("%02d",$date);
    }

    //*
    //* function FormatDateSpan, Parameter list: $datekey1,$datekey2
    //*
    //* Formats date span, $datekey1-$datekey2.
    //*
    //*

    function FormatDateSpan($datekey1,$datekey2)
    {
        $year1=substr($datekey1,0,4);
        $mon1=substr($datekey1,4,2);
        $date1=substr($datekey1,6,2);
        
        $year2=substr($datekey2,0,4);
        $mon2=substr($datekey2,4,2);
        $date2=substr($datekey2,6,2);

        if ($year1!=$year2)
        {
            return $datekey1." - ".$datekey2;
        }
        elseif ($mon1!=$mon2)
        {
            return 
                $date1."/".$mon1.
                " - ".
                $date2."/".$mon2." ".
                $year1;
        }
        else
        {
            return 
                $date1."-".$date2.
                "/".$mon2." ".
                $year1;
        }
    }


}
?>