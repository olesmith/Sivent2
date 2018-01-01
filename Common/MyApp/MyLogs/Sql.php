<?php


trait MyLogs_Sql
{    
    //*
    //* function Logs_Month_Sql_Where, Parameter list: $month,$where=array()
    //*
    //* SQL where clase for $month.
    //*

    function Logs_Month_Sql_Where($month,$where=array())
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$month,$matches) && count($matches)>=2)
        {
            $year=$matches[1];
            $rmonth=$matches[2];

            $where[ "__Date" ]=
                $this->Sql_Times_Condition
                (
                    $this->MyTime_Month_MTime_First($month),
                    $this->MyTime_Month_MTime_Last($month)
                );
        }

        return $where;
    }

    
    //*
    //* function Logs_Date_Sql_Where, Parameter list: 
    //*
    //* SQL where clase for $date.
    //*

    function Logs_Date_Sql_Where($date,$where=array())
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)/',$date,$matches) && count($matches)>=3)
        {
            $year=$matches[1];
            $month=$matches[2];
            $mday=$matches[3];

            $where[ "__Date" ]=
                $this->Sql_Times_Condition
                (
                    $this->MyTime_Date_MTime_First($date),
                    $this->MyTime_Date_MTime_Last($date)
                );
        }
        else
        {
            $where[ "Date" ]=$date;
        }

        return $where;
    }

    //*
    //* function Logs_Sql_Tables_Get, Parameter list: 
    //*
    //* Returns list of log tables.
    //*

    function Logs_Sql_Tables_Get()
    {
        $tables=$this->Sql_Tables_Get();

        $regex='^(\d+)__(\d+)__Logs$';
        $tables=preg_grep('/'.$regex.'/',$tables);
        sort($tables);

        $rtables=array();
        foreach ($tables as $table)
        {
            if (preg_match('/'.$regex.'/',$table,$matches))
            {
                $year=$matches[1];
                $month=$matches[2];

                if (!isset($rtables[ $year ]))
                {
                    $rtables[ $year ]=array();
                }

                array_push($rtables[ $year ],$month);
            }
        }

        $this->Tables=$rtables;
        return $rtables;
    }
   
    //*
    //* function Logs_Sql_Where, Parameter list: 
    //*
    //* SQL where clase for $date.
    //*

    function Logs_Sql_Where($date,$where=array())
    {
        $datemtime1=$this->MyTime_Date_MTime_First($date);
        $datemtime2=$datemtime1+60*60*24-1;

        $where[ "__Date"]=$this->Sql_Times_Condition($datemtime1,$datemtime2);
        foreach ($this->Logs_Search_Vars as $var)
        {
            $cgimethod="Logs_CGI_".$var;
            $cgivalue=$this->$cgimethod();

            if (!empty($cgivalue))
            {
                $where[ $var ]=$cgivalue;
            }
        }

        return $where;
    }
    
}

?>