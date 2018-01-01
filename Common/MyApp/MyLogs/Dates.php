<?php


trait MyLogs_Dates
{
    //*
    //* function Logs_CGI_Date, Parameter list: 
    //*
    //* Detects selected Month.
    //*

    function Logs_CGI_Date()
    {
        if (empty($this->__CGI__[ "Date" ]))
        {
            $date=$this->CGI_POSTint("Logs_Date");
            $this->__CGI__[ "Date" ]=$this->Logs_Date_MDay($date);
        }

        return $this->__CGI__[ "Date" ];
    }
    
    //*
    //* function Logs_Dates_Get, Parameter list: 
    //*
    //* Creates general lob viewing table.
    //*

    function Logs_Dates_Get()
    {
        if (empty($this->Dates))
        {
            $this->Dates=$this->Sql_Select_Unique_Col_Values("Date");
        }
        
        return $this->Dates;
    }
    
    //*
    //* function Logs_Date_Cell, Parameter list: $edit=0,$item=array()
    //*
    //* Creeates Date cell (date only).
    //*

    function Logs_Date_Cell($edit=0,$item=array())
    {
        if (empty($item)) { return "Date"; }
        
        return $this->MyTime_Date($item[ "CTime" ]);
    }
    
    //*
    //* function Logs_Cells_Date_Select, Parameter list: 
    //*
    //* Creates select for current Profiles.
    //*

    function Logs_Cells_Date_Select($where,$date)
    {
        return $this->Logs_CGI_Var_Select($where,"Date",$date,"MyTime_Sort2Date");
    }

}

?>