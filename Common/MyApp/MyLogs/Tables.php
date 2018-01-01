<?php


trait MyLogs_Tables
{
    //*
    //* function Logs_Date_Table, Parameter list: 
    //*
    //* Detailed row for $date: Selected by CGI.
    //*

    function Logs_Date_Table($date)
    {
        $where=$this->Logs_Sql_Where($date);

        $items=$this->Sql_Select_Hashes($where);

        $html=
            $this->H
            (
                2,
                "Date ".$this->MyTime_Sort2Date($date).
                ": ".
                count($items)." Log Entries"
            ).
            
            $this->MyMod_Items_Group_Table_Html
            (
                0,
                $items
            );
             
        return array("",$html);
        
    }
    //*
    //* function Logs_Dates_Table, Parameter list: 
    //*
    //* Creates general lob viewing table.
    //*

    function Logs_Dates_Table()
    {
        $n=1;
        $table=array();

        $totals=array();

        $cdate=0;
        foreach ($this->Logs_Dates_Get() as $date)
        {
            if (empty($date)) { continue; }
            
            array_push
            (
                $table,
                $this->Logs_Date_Row($date,$n,$totals)
            );
            
            if ($this->Logs_Date_Current_Is($date))
            {
                $cdate=$date;
            }

            $n++;
        }

        array_push
        (
            $table,
            array($this->HR(array("WIDTH" => '100%'))),
            $this->Logs_Dates_Table_Total_Row($totals)
        );
 
        if (!empty($cdate))
        {
            array_push
            (
                $table,
                $this->Logs_Date_Table($cdate,$n)
            );
        }
      

        return $table;
        
    }
}

?>