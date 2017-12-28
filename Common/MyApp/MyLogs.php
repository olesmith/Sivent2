<?php

include_once("MyLogs/CGI.php");
include_once("MyLogs/Sql.php");
include_once("MyLogs/Cells.php");
include_once("MyLogs/Rows.php");
include_once("MyLogs/Tables.php");


include_once("MyLogs/Years.php");
include_once("MyLogs/Months.php");
include_once("MyLogs/Dates.php");
include_once("MyLogs/Menu.php");


include_once("MyLogs/Hosts.php");
include_once("MyLogs/Logins.php");


include_once("MyLogs/Info.php");
include_once("MyLogs/Handle.php");



trait MyLogs
{
    use
        MyLogs_CGI,
        MyLogs_Sql,
        MyLogs_Cells,
        MyLogs_Rows,
        MyLogs_Tables,
        
        MyLogs_Years,
        MyLogs_Months,
        MyLogs_Dates,
        
        MyLogs_Menu,
        MyLogs_Hosts,
        MyLogs_Logins,
        MyLogs_Info,
        MyLogs_Handle;
    
    var $Tables=array();
    
    var $Years=array();
    var $Months=array();
    var $Dates=array();
    
    var $Logs_Search_Vars=
        array
        (
            "IP","Profile","Login","ModuleName","Action",
        );
    var $LogGETVars=
        array
        (
            "ModuleName","Action",
        );
    var $LogPOSTVars=
        array
        (
            "Edit","Update","Transfer","Save"
        );

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending Year_%02d,Month
    //*

    function SqlTableName($table="")
    {
        $table=$this->Logs_CGI_Table();
        $date=$this->CGI_GETint("Date");
        if (!empty($date))
        {
            $date=sprintf("%d",$date);
            $year=substr($date,0,4);
            $month=substr($date,4,2);

            $table=
                $year."__".
                sprintf("%02d",$month)."__".
                "Logs";
        }
        
        if (empty($table))
        {
            $table=
                $this->CurrentYear()."__".
                sprintf("%02d",$this->CurrentMonth())."__".
                "Logs";
        }

        return $table;
    }
   
    //*
    //* function Entry2SqlTableName, Parameter list: 
    //*
    //* Makes logging go to right table.
    //*

    function CurrentSqlTableName()
    {
        return
            $this->CurrentYear()."__".
            sprintf("%02d",$this->CurrentMonth())."__".
            "Logs";
    }
    
    //*
    //* function LogEntry, Parameter list: $msgs,$level=5
    //*
    //* Log entry $msg.
    //*

    function LogEntry($msgs,$level=5)
    {
        if (is_array($msgs)) { $msgs=join("\n",$msgs); }

        $msgs=preg_replace('/\'/',"\\'",$msgs);
        $log=array
        (
           "ATime"   => time(),
           "CTime"   => time(),
           "MTime"   => time(),
           "Year"     => $this->CurrentYear(),
           "Month"    => $this->CurrentYear().sprintf("%02d",$this->CurrentMonth()),
           "Date"    => $this->TimeStamp2DateSort(),
           "Debug"   => $level,
           "Login"   => $this->ApplicationObj->LoginData[ "ID" ],
           "Profile" => $this->ApplicationObj->Profile,
           "Message" => $msgs,
           "IP"      => $_SERVER['REMOTE_ADDR'],
           "PID"     => getmypid(),
           "Host"    => gethostbyaddr($_SERVER['REMOTE_ADDR']),
           "URL"     => $_SERVER['REQUEST_URI'],
        );

        foreach ($this->LogGETVars as $getvar)
        {
            if (isset($_GET[ $getvar ]))
            {
                $log[ $getvar ]=$this->GetGET($getvar);
            }
        }

        foreach ($this->LogPOSTVars as $getvar)
        {
            if (isset($_POST[ $getvar ]))
            {
                $log[ "POST_".$getvar ]=$this->GetPOST($getvar);
            }
        }

        $table=$this->CurrentSqlTableName();
        if (!$this->Sql_Table_Exists($table))
        {
            $this->Sql_Table_Create($table);
        }
        $this->MySqlInsertItem($this->CurrentSqlTableName(),$log);
    }
}

?>