<?php


trait MyLogs_Menu
{
    //*
    //* function Handle_Tables_Menu, Parameter list: 
    //*
    //* Generates year/monthly links to logs.
    //*

    function Logs_Tables_Menu()
    {
        return ""; #disabled
        $tables=$this->Logs_Sql_Tables_Get();
        
        $args=$this->CGI_URI2Hash();
        
        $html="";
        foreach ($tables as $year => $months)
        {
            $hrefs=array();
            $args[ "Year" ]=$year;
            foreach ($months as $month)
            {
                $args[ "Month" ]=$month;

                array_push($hrefs,$this->Href("?".$this->CGI_Hash2URI($args),$month."/".$year));
            }

            $html.=
                "[ ".join(" | ",$hrefs)." ]".
                $this->BR().
                "";
        }

        return
            $this->Center($html).
            $this->BR();
    }

}

?>