<?php


trait MyLogs_Info
{
    //*
    //* function Logs_Info_CGI_Table, Parameter list: $where=array()
    //*
    //* Creates Info table, with searches. $where is base where.
    //*

    function Logs_Info_CGI_Table($where=array())
    {
        $year=$this->Logs_CGI_Year();
        $month=$this->Logs_CGI_Month();
        $mday=$this->Logs_CGI_Date();

        $months=$this->MyLanguage_GetMessage("Months" );

        $monthname=$this->MyLanguage_GetMessage("Months")[ $month -1 ];
        $date=sprintf("%d%02d%02d",$year,$month,$mday);

        $where=$this->Logs_Sql_Where($date);
        $table=
            array
            (
                array
                (
                    $this->H
                    (
                        3,
                        "SQL Table:"." ".$this->SqlTableName()
                    ),
                ),
                array
                (
                    $this->B("Year:"),
                    $this->Logs_Cells_Year_Select($where,$date),
                ),
                array
                (
                    $this->B("Month:"),
                    $this->Logs_Cells_Month_Select($where,$date)
                ),
                array
                (
                    $this->B("Date:"),
                    $this->Logs_Cells_Date_Select($where,$date),
                ),
            );

        foreach ($this->Logs_Search_Vars as $data)
        {
            $method="Logs_Cells_".$data."_Select";
            array_push
            (
                $table,
                array
                (
                    $this->B("".$data.":"),
                    $this->$method($where,$date),
                )
            );
        }

        array_push
        (
            $table,
            array($this->Buttons("Search"))
        );
        

        return $table;
    }

    
    //*
    //* function Logs_Info_CGI, Parameter list: 
    //*
    //* Prints search ifno for logs viewing.
    //*

    function Logs_Info_CGI()
    {
        return
            $this->H(2,"Search Filters:").
            $this->Html_Table
            (
                "",
                $this->Logs_Info_CGI_Table()
            ).
            $this->BR().
            "";
    }
}

?>