<?php


trait MyLogs_Years
{
    //*
    //* function Logs_Years, Parameter list: 
    //*
    //* Detects avaliable Years.
    //*

    function Logs_Years()
    {
        if (empty($this->Years))
        {
            $tables=$this->Sql_Tables();

            $tables=array_keys($tables[ "Logs" ]);
            $tables=preg_grep('/^\d\d\d\d__\d\d__Logs$/',$tables);

            $years=array();
            foreach ($tables as $table)
                {
                    $year=preg_replace('/__\d\d__Logs$/',"",$table);
                    $years[ $year ]=TRUE;
                }

            $this->Years=array_keys($years);
            sort($this->Years);

            if (empty($this->Years))
            {
                echo "No avalaiable Logs";
            }
        }

        
        return $this->Years;
    }

    //*
    //* function Logs_Year_Last, Parameter list: 
    //*
    //* Detects avaliable Years.
    //*

    function Logs_Year_Last()
    {
        $this->Logs_Years();

        return $this->Years[ count($this->Years)-1 ];
    }

    
    //*
    //* function Logs_CGI_Year, Parameter list: 
    //*
    //* Detects selected Year.
    //*

    function Logs_CGI_Year()
    {
        if (empty($this->__CGI__[ "Year" ]))
        {
            $year=$this->CGI_POSTint("Logs_Year");
            if (empty($year))
            {
                $year=$this->Logs_Year_Last();
            }

            $this->__CGI__[ "Year" ]=$year;
        }

        return $this->__CGI__[ "Year" ];
    }
    
    //*
    //* function Logs_Cells_Year_Select, Parameter list: 
    //*
    //* Creates select for current Year.
    //*

    function Logs_Cells_Year_Select($where,$date)
    {

        $cgikey="Logs_Year";
        $year=$this->Logs_CGI_Year();

        $years=$this->Logs_Years();
        
        return $this->MakeSelectField($cgikey,$years,$years,$year,array(),$titles=array());
    }
}

?>