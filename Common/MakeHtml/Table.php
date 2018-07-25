<?php

// Table generation.


trait MakeHtml_Table
{
    //*
    //* function Html_Table, Parameter list: $titles,$rows,$options=array()
    //*
    //* Generates a HTML table.
    //*

    function Html_Table($titles,$rows,$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=False,$hover=False)
    {
        return
            $this->Htmls_Text
            (
                $this->Htmls_Table($titles,$rows,$options,$troptions,$tdoptions,$evenodd,$hover)
            );
    }

    //*
    //* function Html_Table_NRows, Parameter list: $titles,$rows
    //*
    //* Counts number of columns necessary.
    //* 
    //*

    function Html_Table_NRows($titles,$rows)
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
    //* function Html_Table_Row, Parameter list: $row,$options=array(),$tdtag="TD"
    //*
    //* Creates a TR row section in HTML table. May also
    //* be called with $tdtag as TH (as in table header).
    //* 
    //*

    function Html_Table_Row($row,$options=array(),$tdoptions=array(),$tdtag="TD",$count=0)
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

                $html.=$this->Html_Table_Row_Cell($row[$n],$tdoptions,$tdtag);
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
    //* function Html_Table_Row_Cell, Parameter list: $cell,$options=array(),$tdtag="TD"
    //*
    //* Creates TD cell.
    //* 
    //*

    function Html_Table_Row_Cell($cell,$options=array(),$tdtag="TD")
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
                 $this->Html_CSS_Add($cell[ "Class" ],$options);
            }

            $cell=$cell[ "Text" ];
        }

        /* if ($this->BoldColSpans && !empty($options[ "COLSPAN" ])) */
        /* { */
        /*     $this->AddCSSClass("Bold",$options); */
        /* } */

        return
            "      ".
            $this->HtmlTag($tdtag,$cell,$options)."\n".
            $this->HtmlCloseTag($tdtag)."\n";
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
    //* function Html_Table_Head_Rows, Parameter list: $rows
    //*
    //* Returns a table head row, hashing rows; 
    //*

    function Html_Table_Head_Rows($rows)
    {
        foreach (array_keys($rows) as $id)
        {
            $rows[ $id ]=$this->Html_Table_Head_Row($rows[ $id ]);
        }
        
        return $rows;
    }
    
    //*
    //* function Html_Table_Pad, Parameter list: 
    //*
    //* Prepads $pre and post pads $post to all rows of $table.
    //*

    function Html_Table_Pad($table,$pre,$post=array())
    {
        if (!is_array($pre))  { $pre=array($pre); }
        if (!is_array($post)) { $post=array($post); }
        
        foreach (array_keys($table) as $id)
        {
            if (!is_array($table[ $id ])) { $table[ $id ]=array($table[ $id ]); }
            
            $table[ $id ]=array_merge($pre,$table[ $id ],$post);
        }

        return $table;
    }
}

?>