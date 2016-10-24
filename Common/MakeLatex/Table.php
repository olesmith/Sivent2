<?php


trait MakeLatex_Table
{
   //*
    //* function Latex_Table_NItemsPerPage, Parameter list: $options
    //*
    //* Detects number of items per page.
    //*

    function Latex_Table_NItemsPerPage($options)
    {
        $nitemspp=50;
        if (isset($this->LatexData[ "NItemsPerPage" ])) { $nitemspp=$this->LatexData[ "NItemsPerPage" ]; }

        if (!empty($options[ "NItemsPerPage" ]))
        {
            $nitemspp=$options[ "NItemsPerPage" ];
        }

        return $nitemspp;
    }
    
    //*
    //* function Latex_Table_Specs, Parameter list: $options,&$count
    //*
    //* Returns tabular specs.
    //*

    function Latex_Table_Specs($options,&$count)
    {
        $spec="l";
        if (!empty($options[ "Spec" ])) { $spec=$options[ "Spec" ]; }
        
        if (!empty($options[ "Specs" ]) && is_array($options[ "Specs" ]))
        {
            $specs=$options[ "Specs" ];
            $count=count();
        }
        else
        {
            $specs=array();
            for ($n=0;$n<$count;$n++)
            {
                $specs[$n]=$spec;
            }
        }

        return $specs;
    }
    
    //*
    //* function Latex_Table_HLine, Parameter list: $options
    //*
    //* Returns tabular specs.
    //*

    function Latex_Table_HLine($options)
    {
        $hline="   \\hline\n";
        if (isset($options[ "HLine" ]))
        {
            if ($options[ "HLine" ]==TRUE)
            {
                $hline="   \\hline\n";
            }
            elseif ($options[ "HLine" ]==FALSE)
            {
                $hline="";
            }
            else
            {
                $hline=$options[ "HLine" ];
            }
        }

        return $hline;
    }
    
    //*
    //* function Latex_Table_NCol_Detect, Parameter list: $row
    //*
    //* Detects number of cols in $row.
    //*

    function Latex_Table_NCol_Detect($row)
    {
        if (!empty($row[ "Row" ]))
        {
            $count=count($row[ "Row" ]);
        }
        else
        {
            $count=count($row);
        }

        return $count;
    }
    
    //*
    //* function Latex_Table_NCols_Detect, Parameter list: 
    //*
    //* Detects number of cols in $table.
    //*

    function Latex_Table_NCols_Detect($titlerows,$table)
    {
        if (empty($titlerows)) { $titlerows=array(); }
        
        $count=0;
        foreach ($titlerows as $row)
        {
            $count=$this->Max($count,$this->Latex_Table_NCol_Detect($row));
        }
        
        foreach ($table as $row)
        {
            $count=$this->Max($count,$this->Latex_Table_NCol_Detect($row));
        }

        return $count;
    }
    
    //*
    //* function Latex_Table_Titles, Parameter list: $titles,$hline
    //*
    //* Generates Latex table title row(s).
    //*

    function Latex_Table_Titles($titlerows,$hline)
    {
        if (empty($titlerows)) { $titlerows=array(); }
        
        $latex=$hline;
        foreach ($titlerows as $titles)
        {
            if (isset($titles[ "Row" ]) && is_array($titles[ "Row" ]))
            {
                $titles=$titles[ "Row" ];
            }
            foreach ($titles as $id => $title)
            {
                if (!is_array($title))
                {
                    $titles[ $id ]=$this->B($title);
                }
            }
            
            $latex.=
                $this->Latex_Table_Row
                (
                   $titles,
                   $hline
                ).
                "";
        }

        return $latex;
    }

    
    //*
    //* function Latex_Table_Options_Get, Parameter list: $options,$key
    //*
    //* Returns latex $option[ $key ] if set.
    //*

    function Latex_Table_Options_Get($options,$key,$value="")
    {
        if (isset($options[ $key ])) { $value=$options[ $key ]; }
        
        return $value;
    }
     //*
    //* function Latex_Table_Row, Parameter list: $row,$hline,$count=0
    //*
    //* Generates Latex table row.
    //*

    function Latex_Table_Row($row,$hline,$count=0)
    {
        if ($count==0) { $count=count($row); }

        if (!empty($row[ "Row" ])) { $row=$row[ "Row" ]; }

        $nospan=FALSE;
        foreach ($row as $n => $val)
        {
            if (is_array($row[$n]) && isset($row[$n][ "Text" ]))
            {
                //We need left | in spec, when we are first column
                $align="c";
                if (!empty($row[$n][ "Options" ][ "ALIGN" ]))
                {
                    $align=$row[$n][ "Options" ][ "ALIGN" ];
                }

                $spec=$align."|";
                if ($n==0) {$spec="|".$align."|"; }

                if (!empty($row[$n][ "Options" ][ "ROWSPAN" ]))
                {
                    $row[ $n ][ "Text" ]=
                        "\\multirow".
                        "{".
                        $row[$n][ "Options" ][ "ROWSPAN" ].
                        "}{*}".
                        "{".
                        $row[ $n ][ "Text" ].
                        "}";
                }

                if (!empty($row[$n][ "Options" ][ "COLSPAN" ]))
                {
                    $row[ $n ]=
                        "\\multicolumn{".
                        $row[$n][ "Options" ][ "COLSPAN" ].
                        "}{".$spec."}{".
                        $row[ $n ][ "Text" ].
                        "}";
                }
                else
                {
                    $row[ $n ]=$row[ $n ][ "Text" ];
                }

                $nospan=TRUE;
            }

            //if (is_array($row[ $n ])) { var_dump($row[ $n ]); }

            if (preg_match('/\\\\multicolumn/',$row[ $n ])) { $nospan=TRUE; }
        }

        //Span columns with less cells than max of table
        $ncount=count($row);
        if (!$nospan && $ncount>0 && $ncount<$count)
        {
            $row[ $ncount-1 ]="\\multicolumn{".($count-$ncount+1)."}{|c|}{".$row[ $ncount-1 ]."}";
        }

        return
            "   ".
            join(" & ",$row).
            "\\\\\n".
            $hline;
    }

    
    //*
    //* function Latex_Table, Parameter list: $titles,$table
    //*
    //* Generates Latex table.
    //*

    function Latex_Table($titlerows,$table,$options=array())
    {
        $nitemspp=$this->Latex_Table_NItemsPerPage($options);
        $count=$this->Latex_Table_NCols_Detect($titlerows,$table);

        $specs=$this->Latex_Table_Specs($options,$count);
        $hline=$this->Latex_Table_HLine($options);

        $page=0;
        $ltables=array($page => "");
        for ($n=0;$n<count($table);$n++)
        {
            if (!is_array($table[$n])) { $table[$n]=array($table[$n]); }

            if ($n>0 && ($n % $nitemspp)==0)
            {
                $page++;
                $ltables[ $page ]="";
            }
            
            if (is_array($table[$n]))
            {
                $ltables[ $page ].=
                    $this->Latex_Table_Row($table[$n],$hline,$count).
                    "";
            }

        }

        $size=$this->Latex_Table_Options_Get($options,"Size","small");

        $pagehead=
            $this->Latex_Table_Options_Get($options,"PageHead").
            "\n\n".
            "\\begin{".$size."}\n".
            "\\begin{tabular}{|".join("|",$specs)."|}\n".
            $this->Latex_Table_Titles($titlerows,$hline).
            "";
    
        $pageclear="\n\n\\clearpage\n\n";
        
        $pagetail=
            "\\end{tabular}\n\n".
            "\\end{".$size."}\n".
            $this->Latex_Table_Options_Get($options,"PageTail").
            "";

        $pages=array();
        foreach (array_keys($ltables) as $page)
        {
            array_push
            (
                $pages,
                $pagehead.
                $ltables[ $page ].
                $pagetail
            );
        }
        
        return join($pageclear,$pages);
    }
 }
?>