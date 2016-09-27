<?php


class HtmlTable extends HtmlList
{
    var $BoldColSpans=TRUE;

    //*
    //* function RowNCells, Parameter list: $row
    //*
    //* Counts number of cols in row, MultiCell's taken into account.
    //*

    function RowNCells($row)
    {
        $n=1;
        foreach ($row as $id => $cell)
        {
            $width=1;
            if (is_array($cell) && !empty($cell[ "Options" ][ "COLSPAN" ]))
            {
                $width=$cell[ "Options" ][ "COLSPAN" ];
            }
            
            $n+=$width;
        }

        return $n;
    }

    
    //*
    //* function FrameIt, Parameter list: $content,$options=array(),$troptions=array(),$tdoptions=array()
    //*
    //* Frames content.
    //*

    function FrameIt($content,$options=array(),$troptions=array(),$tdoptions=array())
    {
        if (!$this->LatexMode())
        {
            $options[ "ALIGN" ]='center';
            $options[ "FRAME" ]='border';
            if (is_array($content))
            {
                return $this->Html_Table("",$content,$options,$troptions,$tdoptions);
            }
            
            $content=$this->HtmlTags
            (
               "TABLE",
               $this->HtmlTags
               (
                  "TR",
                  $this->HtmlTags
                  (
                     "TD",
                     $content,
                     $tdoptions
                  ),
                  $troptions
               ),
               $options
            );
        }

        return $content;
    }
    //*
    //* function MultiCell, Parameter list: $text,$colspan,$align="c",$options=array()
    //*
    //* Generates a multi cell.
    //*

    function MultiCell($text,$colspan,$align="c",$options=array())
    {
        if (!$this->LatexMode())
        {
            $options[ "COLSPAN" ]=$colspan;

            return array
            (
               "Text" => $this->ALIGN($this->B($text),$align),
               "Options" => $options,
            );
        }
        else
        {
            //Latexmode
            $roptions=array
            (
               "COLSPAN" => $colspan,
               "ALIGN" => $align,
            );

            if (!empty($options[ "ROWSPAN" ]))
            {
                $roptions[ "ROWSPAN" ]=$options[ "ROWSPAN" ];
            }

            return array
            (
               "Text"    => $this->B($text),
               "Options" => $roptions,
            );
        }
    }


//*
//* function HTMLMakeRow , Parameter list: $row,$tdtag="TD",$number,$count=0,$tdclass=""
//*
//* Creates a TR row section in HTML table. May also
//* be called with $tdtag as TH (as in table header).
//* 
//*

function HTMLMakeRow($row,$tdtag="TD",$number=0,$count=0,$tdclass="",$troptions=array())
{
    $tdoptions=array();
    $rtdoptions=array();
    $ncount=count($row);
    if ($ncount<$count)
    {
        $tdoptions[ "COLSPAN" ]=$count-$ncount+1;
    }

    $troptions[ "CLASS" ]="";
    if ($ncount>1)
    {
        if (($number%2)==0)
        {
            $troptions[ "CLASS" ]="even";
        }
        else
        {
            $troptions[ "CLASS" ]="odd";
        }
    }

    if ($tdclass!="")
    {
         $troptions[ "CLASS" ]=$tdclass;
    }

    $html="   <TR".$this->Hash2Options($troptions).">\n";

    $tddtag=$tdtag;

    $nospan=FALSE;
    for ($n=0;$n<count($row);$n++)
    {
        $roptions=$rtdoptions;
        if (is_array($row[$n]) && isset($row[$n][ "Text" ]))
        {
            $nospan=TRUE;
            if (!empty($row[$n][ "Options" ]))
            {
                foreach ($row[$n][ "Options" ] as $key => $value)
                {
                    $roptions[ $key ]=$value;
                }
            }

            $row[$n]=$row[$n][ "Text" ];
        }

        if (!$nospan && ($n+1)==$ncount && $ncount<$count)
        {
            $tdtag.=$this->Hash2Options($tdoptions);
            $row[$n]=$this->Center($row[$n]);
        }


        if (is_array($row[$n]))
        {
            //Cell is an array - make table
            $row[$n]=$this->HtmlTable("",$row[$n]);
        }

        $html.=
            "      <".
            $tdtag.
            " ".
            $this->Hash2Options($roptions).">\n".
            $row[$n].
            "</".$tddtag.">\n";
    }

    $html.="   </TR>\n";

    return $html;
}

//*
//* function HTMLHeadRow, Parameter list: $row,$count=0
//*
//* Creates Table Header row - calls HTMLMakeRow above.
//* 
//*

function HTMLHeadRow($row,$count=0,$tdclass="")
{
    if ($count==0) { $count=count($row); }
    $html=$this->HTMLMakeRow($row,"TH",0,$count,$tdclass);

    return $html;
}

//*
//* function HTMLTableRow, Parameter list: $row,$count=0
//*
//* Creates a Table row - calls HTMLMakeRow above.
//* 
//*

function HTMLTableRow($row,$number,$count=0,$tdclass="")
{
    if ($count==0) { $count=count($row); }

    if (count($row)==1) { $tdclass="some"; }

    $html=$this->HTMLMakeRow($row,"TD",$number,$count,$tdclass);

    return $html;
}

//*
//* function NColumns, Parameter list: $titles,$rows
//*
//* Counts number of columns necessary.
//* 
//*

function NColumns($titles,$rows)
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

//*
//* function HTMLTable, Parameter list: $titles,$rows,$tableoptions,$background=TRUE,$tdclass=""
//*
//* Creates a HTML Table row.
//* 
//*

function HTMLTable($titles,$rows,$tableoptions=array(),$background=TRUE,$tdclass="")
{
    if (count($tableoptions)==0)
    {
        $tableoptions=array
        (
         //"BORDER" => 1,
           "ALIGN" => "center",
        );
    }

    $options=$this->Hash2Options($tableoptions);

    //Find noof columns in table
    $count=$this->NColumns($titles,$rows);

    //Now generate table
    $html="<TABLE".$options.">\n";

    $dm=1;
    if (is_array($titles) && count($titles)>0)
    { 
        $html.=$this->HTMLHeadRow($titles,$count,$tdclass);
        $dm=0;
    }
    elseif (!empty($titles))
    {        
        $html.=$this->HTMLHeadRow(array($titles),$count,$tdclass);
    }

    for ($n=0;$n<count($rows);$n++)
    {
        if (!is_array($rows[$n])) { $rows[$n]=array($rows[$n]); }

        $m=$n;
        if ($background) { $m=$n+$dm; }

        $html.=$this->HTMLTableRow($rows[$n],$m,$count,$tdclass);
    }

    $html.="</TABLE>\n";

    return $html;
}


    //*
    //* function Html_Table_Head_Row, Parameter list: $row
    //*
    //* Returns a table head row, hashing row; 
    //*

    function Html_Table_Head_Row($row)
    {
        return
            array
            (
               "Row" => $row,
               "Class" => 'head',
               "TitleRow" => TRUE,
            );
    }
    
    //*
    //* function Html_Table, Parameter list: $titles,$rows,$options=array()
    //*
    //* Generates a HTML table.
    //*

    function Html_Table($titles,$rows,$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=TRUE,$hover=TRUE)
    {
        if (empty($options)) { $options[ "ALIGN" ]='center'; }
        if (empty($rows)) { return ""; }
        if (!is_array($rows)) { return ""; }

        //Find noof columns in table
        $count=$this->NColumns($titles,$rows);

        $evenclass="even";
        $oddclass="odd";
        if (!$evenodd)
        {
            $evenclass="ceven";
            $oddclass="codd";
        }

        $html="";
        if (!empty($titles))
        {
            if (!is_array($titles[0]))
            {
                $titles=array($titles);
            }

            foreach ($titles as $trow)
            {
                $html.=$this->Html_Row($trow,array(),array("Class" => 'head'),"TH");
            }
        }

        $even=FALSE;
        foreach ($rows as $row)
        {
            if (!is_array($row)) { $row=array($row); }

            $tag="TD";
            if (!empty($row[ "TitleRow" ])) { $tag="TH"; }

            $this->ResetCSSClass($troptions); 
            if (!empty($row[ "Class" ]))
            {
                $this->SetCSSClass($row[ "Class" ],$troptions); 
            }
            elseif ($evenodd && count($row)>1)
            {
                if ($even)
                {
                    $this->AddCSSClass($evenclass,$troptions); 
                    $even=FALSE;
                }
                else
                {
                    $this->AddCSSClass($oddclass,$troptions);
                    $even=TRUE;
                }
            }

            if (!empty($row[ "Row" ]))
            {
                $row=$row[ "Row" ];
            }

            $html.=$this->Html_Row($row,$troptions,$tdoptions,$tag,$count);
        }

        return $this->HtmlTags
        (
            "TABLE",
            $html,
            $options
         ).
         "\n";
    }


    //*
    //* function Html_Row, Parameter list: $row,$options=array(),$tdtag="TD"
    //*
    //* Creates a TR row section in HTML table. May also
    //* be called with $tdtag as TH (as in table header).
    //* 
    //*

    function Html_Row($row,$options=array(),$tdoptions=array(),$tdtag="TD",$count=0)
    {
        if ($count==0) { $count=count($row); }

        $html="   ";
        for ($n=0;$n<count($row);$n++)
        {
            if (isset($row[$n]))
            {
                if ($n==count($row)-1 && $n<$count-1 && isset($row[$n]) && !is_array($row[$n]))
                {
                    $tdoptions[ "COLSPAN" ]=$count-$n;
                    $row[$n]=$this->Center($row[$n]);
                }

                $html.=$this->Html_Cell($row[$n],$tdoptions,$tdtag);
            }
        }

        return $this->HtmlTags
        (
            "TR",
            $html,
            $options
         ).
         "\n";
    }

    //*
    //* function Html_Cell, Parameter list: $cell,$options=array(),$tdtag="TD"
    //*
    //* Creates TD cell.
    //* 
    //*

    function Html_Cell($cell,$options=array(),$tdtag="TD")
    {
        if (is_array($cell) && isset($cell[ "Text" ]))
        {
            if (!empty($cell[ "Options" ]))
            {
                foreach ($cell[ "Options" ] as $key => $value)
                {
                    $options[ $key ]=$value;
                }
            }

            if (!empty($cell[ "Class" ]))
            {
                 $this->AddCSSClass($cell[ "Class" ],$options);
            }

            $cell=$cell[ "Text" ];
        }

        if ($this->BoldColSpans && !empty($options[ "COLSPAN" ]))
        {
            $this->AddCSSClass("Bold",$options);
        }

        return
            "      ".
            $this->HtmlTag($tdtag,$cell,$options)."\n".
            $this->HtmlCloseTag($tdtag)."\n";
    }


    //*
    //* function PadTable, Parameter list: $table
    //*
    //* Pads on additional row elements in table, making all rows of equal length.
    //* Works only with 'simple' tables: no row spanning!
    //*

    function PadTable($table)
    {
        $nrows=0;
        foreach ($table as $rid => $row)
        {
            $nrows=$this->Max($nrows,count($row));
        }

        foreach (array_keys($table) as $rid)
        {
            for ($n=count($table[ $rid ]);$n<=$nrows;$n++)
            {
                array_push($table[ $rid ],"");
            }
        }

        return $table;
    }

    //*
    //* function PrependCells, Parameter list: $table,$ncells,$empty=""
    //*
    //* Prepends $ncells cells to each row of $table.
    //*

    function PrependCells($table,$ncells,$empty="")
    {
        $empties=array();
        for ($n=1;$n<=$ncells;$n++) { array_push($empties,$empty); }

        foreach (array_keys($table) as $rid)
        {
            $table[ $rid ]=array_merge($empties,$table[ $rid ]);
        }

        return $table;
    }
}


?>