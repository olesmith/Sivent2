<?php

trait Htmls_Table_Row
{
    //*
    //* function Html_Table_Row, Parameter list: $row,$options=array(),$tdtag="TD"
    //*
    //* Creates a TR row section in HTML table. May also
    //* be called with $tdtag as TH (as in table header).
    //* 
    //*

    function Htmls_Table_Row($row,$options=array(),$tdoptions=array(),$tdtag="TD",$count=0)
    {
        if ($count==0) { $count=count($row); }

        $html=array();
        for ($n=0;$n<count($row);$n++)
        {
            if (isset($row[$n]))
            {
                if ($n==count($row)-1 && $n<$count-1 && isset($row[$n]))//!is_array($row[$n]))
                {
                    $tdoptions[ "COLSPAN" ]=$count-$n;
                    #$row[$n]=$this->Center($row[$n]);
                }

                array_push
                (
                    $html,
                    $this->Htmls_Table_Cell($row[$n],$tdoptions,$tdtag)
                );
            }
        }

        return $this->Htmls_Tag("TR",$html,$options);
    }
    
    //*
    //* function Htmls_Table_NRows, Parameter list: $titles,$rows
    //*
    //* Counts max number of columns.
    //* 
    //*

    function Htmls_Table_NRows($titles,$rows)
    {
        //Find noof columns in table
        $count=0;
        if (is_array($titles) && count($titles)>0)
        { 
            $count=count($titles);
        }

        for ($n=0;$n<count($rows);$n++)
        {
            if (!empty($rows[ $n ][ "Row" ]))
            {
                $rcount=count($rows[$n][ "Row" ]);
            }
            else
            {
                $rcount=count($rows[$n]);
            }
            if ($rcount>$count) { $count=$rcount; }
        }

        return $count;
    }
    
}

?>