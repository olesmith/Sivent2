<?php


trait MyLogs_Rows
{
    //*
    //* function Logs_Date_Row, Parameter list: $date,$n,&$totals
    //*
    //* Generated undetailed ro info for $date no $n.
    //*

    function Logs_Date_Row($date,$n,&$totals)
    {
        $datemtime=$this->MyTime_Date_MTime_First($date);

        $where=$this->Logs_Date_Sql_Where($date);
        $where=$this->Logs_Sql_Where($date);

        $row=
            array
            (
                $this->B($n),
                $this->Logs_Date_Link($date),
            );
        
        $total=0;
        for ($hour=1;$hour<=24;$hour++)
        {
            $hourmtime1=$datemtime+($hour-1)*60*60;
            $hourmtime2=$datemtime+$hour*60*60-1;
            $where[ "__Date" ]=$this->Sql_Times_Condition($hourmtime1,$hourmtime2);
            
            $htotal=$this->Sql_Select_NHashes($where);
            
            if (empty($totals[ $hour ])) { $totals[ $hour ]=0; }
            $totals[ $hour ]+=$htotal;
            $total+=$htotal;

            if ($htotal==0) { $htotal="-"; }
            
            array_push
            (
                $row,
                $this->Div
                (
                    $htotal,
                    array("ALIGN" => 'right')
                )
            );
        }

        if (empty($total)) { return array(); };

        
        array_push
        (
            $row,
            $this->B("*"),
            $this->Div($total,array("ALIGN" => 'right',"CLASS" => 'Bold'))
        );
        
            
        return $row;
        
    }

    //*
    //* function Logs_Dates_Table_Total_Row, Parameter list: $totals
    //*
    //* Generates no of log entries totals row.
    //*

    function Logs_Dates_Table_Total_Row($totals)
    {
        $row=array
        (
            "",
            $this->B($this->ApplicationObj->Sigma.":"),
        );
        
        for ($hour=1;$hour<=24;$hour++)
        {
            $total="-";
            if (!empty($totals[ $hour ]))
            {
                $total=$totals[ $hour ];
            }
            
            array_push
            (
                $row,
                $this->Div
                (
                    $total,
                    array
                    (
                        "ALIGN" => 'right',
                        "CLASS" => 'Bold'
                    )
                )
            );
        }
        
        $total=0;
        foreach ($totals as $hour => $value)
        {
            $total+=$value;
        }
        
        array_push
        (
            $row,
            "*",
            $this->Div
            (
                $total,
                array
                (
                    "ALIGN" => 'right',
                    "CLASS" => 'Bold',
                )
            )
        );

        return $row;
    }

    
    //*
    //* function Handle_Logs, Parameter list: 
    //*
    //* Search Logs handler.
    //*

    function Logs_Dates_Table_Titles()
    {
        $row=array("Nº","Date");
        for ($hour=0;$hour<24;$hour++)
        {
            array_push($row,sprintf("%02d",$hour));
        }

        array_push
        (
            $row,
            $this->B("*"),
            $this->Div
            (
                $this->ApplicationObj()->Sigma,
                array
                (
                    "ALIGN" => 'right',
                    "CLASS" => 'Bold',
                )
            )
        );
        
        return
            array
            (
                array
                (
                    $this->MultiCell("",2),
                    $this->MultiCell("Hours",24),        
                    $this->MultiCell("",2),
                ),
                $row,
            );
    }
}

?>