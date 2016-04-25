<?php

global $ClassList;
$ClassList=array();
array_push($ClassList,"Log");

class Log extends Mail
{
    /* var $LogFile="Logs/#Date.log"; */
    /* var $LogRegex='Logs\/(\d\d\d\d)(\d\d)(\d\d).log'; */
    /* var $Year,$Month,$Date; */
    /* var $LogLevel=5; */

    /* var $LogGETVars=array(); */
    /* var $LogPOSTVars=array(); */

    /* function Log() */
    /* { */
    /* } */

    /* function InitLog($hash=array()) */
    /* { */
    /*     if (is_array($hash)) */
    /*     { */
    /*         if (isset($hash[ "LogFile" ])) */
    /*         { */
    /*             $this->LogFile=$hash[ "LogFile" ]; */
    /*         } */
    /*     } */
    /*     elseif (isset($hash)) */
    /*     {  */
    /*         $this->LogFile=$hash; */
    /*     } */


    /*     $datestamp=$this->TimeStamp2DateSort(); */

    /*     $year=$this->GetCGIVarValue("Year"); */
    /*     $month=$this->GetCGIVarValue("Month"); */
    /*     $date=$this->GetCGIVarValue("Date"); */

    /*     $match=array(); */
    /*     if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$datestamp,$match)) */
    /*     { */
    /*         if ($year==NULL || $year=="")   { $year=$match[1];  } */
    /*         if ($month==NULL || $month=="") { $month=$match[2]; } */
    /*         if ($date==NULL || $date=="")   { $date=$match[3];  } */
    /*     } */

    /*     $this->Year=$year; */
    /*     $this->Month=$month; */
    /*     $this->Date=$date; */
    /* } */


    /* function LogMessage($action,$msgs,$level=5) */
    /* { */
    /*     $logobj=NULL; */
    /*     if (!empty($this->ApplicationObj)) */
    /*     { */
    /*         $logobj=$this->ApplicationObj->LogsObject(TRUE); */
    /*     } */
    /*     else //if (!empty($this->LogsObject())) */
    /*     { */
    /*         $logobj=$this->LogsObject(TRUE); */
    /*     } */

    /*     if ($logobj) */
    /*     { */
    /*         $logobj->LogEntry($msgs,$level); */
    /*     } */

    /*     return; */
    /* } */

    /* function FileNames2YMD($files) */
    /* { */
    /*     $year=$this->Year; */
    /*     $month=$this->Month; */
    /*     $date=$this->Date; */

    /*     $vars=array */
    /*     ( */
    /*      "Years" => array(), */
    /*      "Months" => array(), */
    /*      "Dates" => array(), */
    /*     ); */

    /*     sort($files); */

    /*     for ($n=0;$n<count($files);$n++) */
    /*     { */
    /*         $match=array(); */
    /*         if (preg_match('/'.$this->LogRegex.'/',$files[$n],$match)) */
    /*         { */
    /*             $ryear=$match[1]; */
    /*             $rmonth=$match[2]; */
    /*             $rdate=$match[3]; */
    /*             if (!preg_grep('/'.$ryear.'/',$vars[ "Years" ])) */
    /*             { */
    /*                 array_push($vars[ "Years" ],$ryear); */
    /*             } */

    /*             if ($year=="*" || $ryear==$year) */
    /*             { */
    /*                 if (!preg_grep('/'.$ryear."\/".$rmonth.'/',$vars[ "Months" ])) */
    /*                 { */
    /*                     array_push($vars[ "Months" ],$ryear."/".$rmonth); */
    /*                 } */

    /*                 if ($monht=="*" || $rmonth==$month) */
    /*                 { */
    /*                     if (!preg_grep('/'.$ryear."\/".$rmonth."\/".$rdate.'/',$vars[ "Dates" ])) */
    /*                     { */
    /*                         array_push($vars[ "Dates" ],$ryear."/".$rmonth."/".$rdate); */
    /*                     } */
    /*                 }  */
    /*             } */
    /*         } */
    /*     } */

    /*     return $vars; */
    /* } */


    /* function FileNames2Menu($files) */
    /* { */
    /*     $nperline=6; */
    /*     $year=$this->Year; */
    /*     $month=$this->Month; */
    /*     $date=$this->Date; */

    /*     $vars=$this->FileNames2YMD($files); */

    /*     $yhrefs=array(); */
    /*     $ncount=count($vars[ "Years" ]); */
    /*     for ($n=0,$nn=1;$n<$ncount;$n++) */
    /*     { */
    /*         $ryear=$vars[ "Years" ][ $n ]; */

    /*         $href=$ryear; */
    /*         if ($year!=$ryear) */
    /*         { */
    /*             $href="?Log=1&Year=".$ryear."&Month=*&Date=*"; */
    /*             $name=$ryear; */

    /*             $href=$this->HRef($href,$name,"Logs ".$name); */
    /*         } */

    /*         if ( ($nn % $nperline)==0 && $nn<$ncount) { $href.="<BR>"; } */

    /*         array_push($yhrefs,$href); */
    /*         $nn++; */
    /*     } */

    /*     $mhrefs=array(); */
    /*     $ncount=count($vars[ "Months" ]); */
    /*     for ($n=0,$nn=1;$n<$ncount;$n++) */
    /*     { */
    /*         $rmonth=$vars[ "Months" ][ $n ]; */

    /*         $comps=preg_split('/\//',$rmonth); */
    /*         $year=$comps[0]; */
    /*         $month=$comps[1]; */

    /*         $href=$month."/".$year; */
    /*         if ($this->Month!=$month) */
    /*         { */
    /*             $href="?Log=1&Year=".$ryear."&Month=".$month."&Date=*"; */
    /*             $name=$month."/".$year; */

    /*             $href=$this->HRef($href,$name,"Logs ".$name); */
    /*         } */

    /*         if ( ($nn % $nperline)==0 && $nn<$ncount) { $href.="<BR>"; } */

    /*         array_push($mhrefs,$href); */
    /*         $nn++; */
    /*     } */

    /*     $dhrefs=array(); */
    /*     $ncount=count($vars[ "Dates" ]); */
    /*     for ($n=0,$nn=1;$n<$ncount;$n++) */
    /*     { */
    /*         $rmonth=$vars[ "Dates" ][ $n ]; */

    /*         $comps=preg_split('/\//',$rmonth); */
    /*         $year=$comps[0]; */
    /*         $month=$comps[1]; */
    /*         $date=$comps[2]; */

    /*         $href=$date."/".$month."/".$year; */
    /*         if ($this->Date!=$date) */
    /*         { */
    /*             $href="?Log=1&Year=".$ryear."&Month=".$month."&Date=".$date; */
    /*             $name=$date."/".$month."/".$year; */

    /*             $href=$this->HRef($href,$name,"Logs ".$name); */
    /*         } */

    /*         if ( ($nn % $nperline)==0 && $nn<$ncount) { $href.="<BR>"; } */

    /*         array_push($dhrefs,$href); */
    /*         $nn++; */
    /*     } */

    /*     print  */
    /*         "<CENTER>\n". */
    /*         "<B>Year:</B> [ ".join(" |\n ",$yhrefs)." ]<BR><BR>\n". */
    /*         "<B>Month:</B> [ ".join(" |\n ",$mhrefs)." ]<BR><BR>\n". */
    /*         "<B>Date:</B> [ ".join(" |\n ",$dhrefs)." ]<BR><BR>\n". */
    /*         "</CENTER>\n"; */
    /* } */

    /* function LogSearchForm($titles) */
    /* { */
    /*     $table=array(); */
    /*     for ($n=0;$n<count($titles);$n++) */
    /*     { */
    /*         $key="Log_Search_".$n; */

    /*         $search=$this->GetPOST($key); */
    /*         array_push */
    /*         ( */
    /*            $table, */
    /*            array */
    /*            ( */
    /*               "<B>".$titles[$n].":</B>", */
    /*               $this->MakeInput($key,$search,10) */
    /*            ) */
    /*         ); */
    /*     } */

    /*     return */
    /*         $this->StartForm("?Log=1"). */
    /*         $this->HtmlTable("",$table). */
    /*         "<CENTER>". */
    /*         $this->MakeHidden("Year",$this->Year). */
    /*         $this->MakeHidden("Month",$this->Month). */
    /*         $this->MakeHidden("Date",$this->Date). */
    /*         $this->MakeHidden("Go",1). */
    /*         $this->Button("submit","Go"). */
    /*         "</CENTER>". */
    /*         $this->EndForm()."<BR>"; */

    /* } */


    /* function ShowLog() */
    /* { */
    /*     $logfile=$this->LogFile; */
    /*     $logdate=$this->Year.$this->Month.$this->Date; */

    /*     $logfile=preg_replace('/#Module/',$this->ModuleName,$logfile); */
    /*     $logfile=preg_replace('/#Date/',$logdate,$logfile); */

    /*     $rtable=array */
    /*     ( */
    /*      array("<B>Year:</B>",$this->Year), */
    /*      array("<B>Month:</B>",$this->Month), */
    /*      array("<B>Date:</B>",$this->Date) */
    /*     ); */

    /*     $titles=array("Time","Module","Level","IP/Host","Login ID","Login", */
    /*                   "Acess Type","Action","Message"); */

    /*     $vals=array(); */
    /*     preg_match('/(\d\d\d\d)(\d\d)(\d\d)\.log$/',$logfile,$vals); */
    /*     array_shift($vals); */
    /*     $vals=array_reverse($vals); */

    /*     $date=join("/",$vals); */

    /*     $logtable=array(); */

    /*     if ($this->GetPOST("Go")==1) */
    /*     { */
    /*         if (!is_file($logfile)) */
    /*         { */
    /*             print $this->H(2,"No such logfile: ".$logfile); */
    /*             return; */
    /*         } */

    /*         $search=array(); */
    /*         for ($n=0;$n<count($titles);$n++) */
    /*         { */
    /*             array_push($search,$this->GetPOST("Log_Search_".$n)); */
    /*         } */

    /*         $handle = @fopen($logfile, "r"); */
    /*         if ($handle) */
    /*         { */
    /*             while (($line = fgets($handle, 4096)) != false) */
    /*             { */
    /*                 $comps=preg_split('/\t/',$line); */

    /*                 $include=TRUE; */
    /*                 for ($m=0;$m<count($titles);$m++) */
    /*                 { */
    /*                     if ($search[$m]!="") */
    /*                     { */
    /*                         $rsearch=strtolower($search[$m]); */
    /*                         $rcomp=strtolower($comps[$m]); */
    /*                         if (!preg_match('/'.$rsearch.'/',$rcomp)) */
    /*                         { */
    /*                             $include=FALSE;                             */
    /*                         } */
    /*                     } */
    /*                 } */

    /*                 if ($include) */
    /*                 { */
    /*                     array_push($logtable,$comps); */
    /*                 } */
    /*             } */

    /*             fclose($handle); */
    /*         } */
    /*     } */


    /*     print */
    /*         $this->HtmlTable("",$rtable). */
    /*         $this->H(2,"Search Log: ".$date). */
    /*         $this->H(3,"Regular Expressions Allowed"). */
    /*         $this->LogSearchForm($titles). */
    /*         $this->HtmlTable($titles,$logtable); */

    /*     $this->LogMessage("SearchLog","Date: $date"); */
    /* } */

    /* function LogsTable() */
    /* { */
    /*     $logfile=$this->LogFile; */

    /*     $path=dirname($logfile); */
    /*     $file=basename($logfile); */

    /*     $regex=preg_replace('/#Module\./',$this->ModuleName.".",$file); */
    /*     $regex=preg_replace('/#Date\./',"[0-9]+.",$regex); */

    /*     $files=$this->DirFiles($path,$regex); */

    /*     $this->FileNames2Menu($files); */
    /*     $this->ShowLog(); */
    /* } */
}
?>