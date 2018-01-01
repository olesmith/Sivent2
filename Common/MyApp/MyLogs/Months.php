<?php


trait MyLogs_Months
{
    //*
    //* function Logs_Months, Parameter list: 
    //*
    //* Detects avaliable .
    //*

    function Logs_Months()
    {
        if (empty($this->Months))
        {
            $year=$this->Logs_CGI_Year();
            
            $tables=$this->Sql_Tables();

            $tables=array_keys($tables[ "Logs" ]);
            $tables=preg_grep('/^'.$year.'__\d\d__Logs$/',$tables);

            $months=array();
            foreach ($tables as $table)
                {
                    $month=preg_replace('/^'.$year.'__/',"",$table);
                    $month=preg_replace('/__Logs$/',"",$month);

                    $months[ $month ]=TRUE;
                }

            $this->Months=array_keys($months);
            sort($this->Months);

            if (empty($this->Months))
            {
                echo "No avalaiable Logs";
            }
        }

        
        return $this->Months;
    }

    //*
    //* function Logs_Month_Names, Parameter list: 
    //*
    //* Returns names of $this->Months.
    //*

    function Logs_Month_Names()
    {
        $names=
            array
            (
                "01" => "Jan",
                "02" => "Feb",
                "03" => "Mar",
                "04" => "Apr",
                "05" => "May",
                "06" => "Jun",
                "07" => "Jul",
                "08" => "Aug",
                "09" => "Sep",
                "10" => "Oct",
                "11" => "Nov",
                "12" => "Dez",
            );
        $year=$this->Logs_CGI_Year();
        $this->Logs_Months();
        
        $monthnames=array();
        foreach ($this->Months as $month)
        {
            array_push($monthnames,$names[ $month ]." ".$year);
        }

        return $monthnames;
    }
    
    //*
    //* function Logs_Month_Last, Parameter list: 
    //*
    //* Detects avaliable Years.
    //*

    function Logs_Month_Last()
    {
        $this->Logs_Months();

        return sprintf("%02d",$this->Months[ count($this->Months)-1 ]);
    }

    
    //*
    //* function Logs_CGI_Month, Parameter list: 
    //*
    //* Detects selected Year.
    //*

    function Logs_CGI_Month()
    {
        if (empty($this->__CGI__[ "Month" ]))
        {
            $month=$this->CGI_POSTint("Logs_Month");
            if (empty($month))
            {
                $month=$this->Logs_Month_Last();
            }
            else
            {
                $rmonth=preg_grep('/^'.(sprintf("%02d",$month)).'$/',$this->Logs_Months());
                if (empty($rmonth))
                {
                    $month=$this->Logs_Month_Last();
                }
            }

            $this->__CGI__[ "Month" ]=sprintf("%02d",$month);
        }

        return $this->__CGI__[ "Month" ];
    }
    
    //*
    //* function Logs_Cells_Month_Select, Parameter list: 
    //*
    //* Creates select for current Year.
    //*

    function Logs_Cells_Month_Select($where,$date)
    {
        $months=$this->Logs_Months();
        $monthnames=$this->Logs_Month_Names();
        array_unshift($months,"");
        array_unshift($monthnames,"");
        
        return
            $this->MakeSelectField
            (
                "Logs_Month",
                $months,
                $monthnames,
                $this->Logs_CGI_Month(),
                array(),$titles=array()
            );
    }
}

?>