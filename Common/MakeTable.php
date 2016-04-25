<?php

trait MakeTable 
{
    //*
    //* function Table_Defaults, Parameter list: $rargs
    //*
    //* Returns hash with defaults for table generation.
    //* 
    //*

    function Table_Defaults($rargs)
    {
        $this->Args=array
        (
           "Title"       => "",
           "Edit"       => 0,

           "Options"    => array(),
           "RowOptions"    => array(),
           "CellOptions"    => array(),

           "ShowDatas" => array(),
           "Datas" => array(),
           "Group" => "",

           "Edit"   => 0,

           "Items" => array(),
           "TableMethod" => "Table_Generate",
           "RowMethod"   => "",
           "RowsMethod"   => "Table_Rows",
           "TitleRowMethod"   => "",
           "TitleRowsMethod"   => "Table_TitleRows",


           "Period"         => 0,
           "PeriodRows"   => array(),
           "PostRowsMethod"   => "",
        );

        foreach ($rargs as $key => $value)
        {
            $this->Args[ $key ]=$value;
        }

        $group=$this->CGI_GET("Group");
        if (empty($group)) { $group=$this->Args[ "Group" ]; }


        if (!empty($group))
        {
            if (!empty($this->ItemDataGroups[ $group ][ "Actions" ]))
            {
                $this->Args[ "ShowDatas" ]=array_merge
                (
                   $this->Args[ "ShowDatas" ],
                   $this->ItemDataGroups[ $group ][ "Actions" ]
                );
            }

            if (!empty($this->ItemDataGroups[ $group ][ "ShowData" ]))
            {
                $this->Args[ "ShowDatas" ]=array_merge
                (
                   $this->Args[ "ShowDatas" ],
                   $this->ItemDataGroups[ $group ][ "ShowData" ]
                );
            }

            if (!empty($this->ItemDataGroups[ $group ][ "Data" ]))
            {
                $this->Args[ "Datas" ]=array_merge
                (
                   $this->Args[ "Datas" ],
                   $this->ItemDataGroups[ $group ][ "Data" ]
                );
            }
        }
    }

    //*
    //* function Table_Html, Parameter list: $args
    //*
    //* Generate html table.
    //* 
    //*

    function Table_Html($args)
    {
        $this->Table_Defaults($args);

        $titlerowmethod=$this->Args[ "TitleRowMethod" ];
        $titlerowsmethod=$this->Args[ "TitleRowsMethod" ];

        $titlerow=array();
        if (empty($titlerowsmethod) && !empty($titlerowmethod)) { $titlerow=$this->$titlerowmethod(); }

        $titlematrixmethod=$this->Args[ "TableMethod" ];

        return
            $this->Html_Table
            (
               $titlerow,
               $this->$titlematrixmethod(),
               $this->Args[ "Options" ],
               $this->Args[ "RowOptions" ],
               $this->Args[ "CellOptions" ],
               TRUE,
               TRUE
            );
    }
   
    //*
    //* function Table_Latex, Parameter list: $args
    //*
    //* Generate table as matrix.
    //* 
    //*

    function Table_Latex($args)
    {
        $this->Table_Defaults($args);


        $titlerowmethod=$this->Args[ "TitleRowMethod" ];
        $titlematrixmethod=$this->Args[ "TableMethod" ];

        return
            $this->Html_Table
            (
               $this->$titlerowmethod(),
               $this->$titlematrixmethod(),
               $this->Args[ "Options" ],
               $this->Args[ "RowOptions" ],
               $this->Args[ "CellOptions" ],
               TRUE,
               TRUE
            );
    }
   
    //*
    //* function Table_Generate, Parameter list: 
    //*
    //* Generate table as matrix. Puts title in first row, if asked for.
    //* 
    //*

    function Table_Generate()
    {
        $table=array();
        if (!empty($this->Args[ "Title" ]))
        {
            array_push($table,array($this->Args[ "Title" ]));
        }

        $titlerowsmethod=$this->Args[ "TitleRowsMethod" ];
        if (!empty($titlerowsmethod))
        {
            $titlerows=$this->$titlerowsmethod();
            foreach ($titlerows as $titlerow)
            {
                $this->Table_AddTitleRow($table,$titlerow);
            }
        }

        return $this->Table_Matrix($this->Args[ "Items" ],$table);
    }


    //*
    //* function Table_Matrix, Parameter list: $items=array(),$top=array()
    //*
    //* Generate table as matrix.
    //* 
    //*

    function Table_Matrix($items=array(),$top=array())
    {
        if (empty($items)) { $items=$this->Args[ "Items" ]; }

        $rowsmethod=$this->Args[ "RowsMethod" ];
        $rowmethod=$this->Args[ "RowMethod" ];

        $n=1;
        $table=array();
        foreach ($items as $iid => $item)
        {
            if (!empty($rowsmethod))
            {
                $table=array_merge
                (
                   $table,
                   $this->$rowsmethod($this->Args[ "Edit" ],$item,$n++)
                );
            }
            elseif (!empty($rowmethod))
            {
                array_push
                (
                   $table,
                   $this->$rowmethod($this->Args[ "Edit" ],$item,$n++)
                );
            }
        }

        if ($this->Args[ "Period" ]>0 && !empty($this->Args[ "PeriodRows" ]))
        {
            $table=$this->Html_AddPeriodicRows
            (
               $table,
               $this->Args[ "Period" ],
               $this->Args[ "PeriodRows" ]
            );
        }

        if (!empty($this->Args[ "PostRowsMethod" ]))
        {
            $method=$this->Args[ "PostRowsMethod" ];
            $table=array_merge
            (
               $table,
               $this->$method()
            );
        }

        return array_merge($top,$table);
    }

    //*
    //* function Table_AddTitleRow, Parameter list: &$table,$titles
    //*
    //* Adds title row to table.
    //* 
    //*

    function Table_AddTitleRow(&$table,$titles)
    {
        $row=array();
        if ($this->LatexMode())
        {
            $row=$this->B($titles);
        }
        else
        {
            $row=array
            (
               "Row" => $titles,
               "TitleRow" => TRUE,
               "Class" => 'head',
            );
        }

        array_push($table,$row);
   }

    //*
    //* function Table_TitleRowCell, Parameter list: 
    //*
    //* Creates item title row cell.
    //* 
    //*

    function Table_TitleRowCell($data)
    {
        $cell="";
        if (!empty($this->ItemData[ $data ]))
        {
            $cell=$this->MakeSortTitle($data,TRUE);
        }
        elseif (!empty($this->Actions[ $data ]))
        {
            $cell="";
        }
        elseif (method_exists($this,$data))
        {
            $cell=$this->$data();
        }

        return $cell;
    }

    //*
    //* function Table_RowDatas, Parameter list: 
    //*
    //* Returns data cols in table.
    //* 
    //*

    function Table_RowDatas()
    {        
        $datas=array();
        foreach (array("Actions","ShowDatas","Datas") as $type)
        {
            if (!empty($this->Args[ $type ]) && is_array($this->Args[ $type ]))
            {
                $datas=array_merge($datas,$this->Args[ $type ]);
            }
        }

        return $datas;
    }

    //*
    //* function Table_TitleRow, Parameter list: $leadingcount=TRUE
    //*
    //* Creates one item row.
    //* 
    //*

    function Table_TitleRow($leadingcount=TRUE)
    {
        $row=array();
        if ($leadingcount)
        {
            array_push($row,"No");
        }

        foreach ($this->Table_RowDatas() as $data)
        {
            array_push
            (
               $row,
               $this->Table_TitleRowCell($data)
            );
        }

        return $row;
    }

    //*
    //* function Table_TitleRows, Parameter list: $leadingcount=TRUE
    //*
    //* Creates one item row as matrix.
    //* 
    //*

    function Table_TitleRows($leadingcount=TRUE)
    {
        //Both!
        $rows=array();
        $row=array();

        if ($leadingcount)
        {
            array_push($row,"No");
        }

        foreach ($this->Table_RowDatas() as $data)
        {
            $rdata=$data;
            if (is_array($data)) { $rdata=array_shift($data); }
            
                if (preg_match('/^newline\((\d+)\)/i',$rdata,$matches))
                {
                    return array($row);
                }
                else
                {
                    array_push
                    (
                       $row,
                       $this->Table_TitleRowCell($rdata)
                    );
                }
        }


        array_push($rows,$row);
        return $rows;
    }

    //*
    //* function Table_RowCell, Parameter list: $edit,$item,$n,$data
    //*
    //* Creates one item cell in row.
    //* 
    //*

    function Table_RowCell($edit,$item,$n,$data,$precgi="")
    {
        if (preg_match('/^text\s+(.*)/',$data,$matches))
        {
            return $this->B($matches[1]);
        }

        $tabindex=1;

        $cell="";
        if (!empty($this->ItemData[ $data ]))
        {
            $rdata="";
            if (!empty($precgi)) { $rdata=$precgi.$data; }
            
            $cell=$this->MyMod_Data_Fields($edit,$item,$data,TRUE,$n,$rdata);
            
        }
        elseif (!empty($this->Actions[ $data ]))
        {
            $cell=$this->MyActions_Entry($data,$item);
        }
        elseif (method_exists($this,$data))
        {
            $cell=$this->$data($item,$edit);
        }

        return $cell;
    }

    //*
    //* function Table_RowsNLeadingEmpties, Parameter list:
    //*
    //* Tries to detect no of leading empties, when adding second (third..)
    //* additional lines to item rows. Returns count of first text encontered.
    //* 
    //*

    function Table_RowsNLeadingEmpties()
    {
        $nleadingcols=0;
        $n=0;
        foreach ($this->Table_RowDatas() as $data)
        {
            if (preg_match('/(text|newline)\s/i',$data))
            {
                $nleadingcols=$n;
                break;
            }

            $n++;
        }
    }

    //*
    //* function Table_Row, Parameter list: $edit,$item,$n
    //*
    //* Creates one item row.
    //* 
    //*

    function Table_Row($edit,$item,$n,$precgi="")
    {
        $row=array($this->B(sprintf("%02d",$n)));
        foreach ($this->Args[ "ShowDatas" ] as $data)
        {
            array_push
            (
               $row,
               $this->Table_RowCell(0,$item,$n,$data,$precgi)
            );
        }

        /* foreach ($this->Table_RowDatas()  as $data) */
        /* { */
        /*     array_push */
        /*     ( */
        /*        $row, */
        /*        $this->Table_RowCell($edit,$item,$n,$data,$precgi) */
        /*     ); */
        /* } */


        return $row;
    }

    //*
    //* function Table_Rows, Parameter list: $edit,$item,$n,$forcencols=0,$precgi=""
    //*
    //* Creates one item row.
    //* 
    //*

    function Table_Rows($edit,$item,$n,$forcencols=0,$precgi="")
    {
        //Both!
        $rows=array();
        $row=array();

        $first="";
        if (!empty($n))
        {
            $first=$this->B(sprintf("%02d",$n));
            array_push($row,$first);
        }

        foreach ($this->Table_RowDatas() as $data)
        {
            $rdata=$data;
            if (!is_array($data)) { $data=array($data); }

            $cells=array();
            foreach ($data as $rdata)
            {
                if (preg_match('/^newline\((\d+)\)/i',$rdata,$matches))
                {
                    $ncols=$matches[1];
                    array_push($rows,$row);
                    if (!empty($forcencols)) { $ncols=$forcencols; }

                    $row=array($this->MultiCell("",$ncols));
                }
                else
                {
                    array_push
                    (
                       $cells,
                       $this->Table_RowCell($edit,$item,$n,$rdata,$precgi)
                    );
                }
            }

            array_push($row,join($this->BR(),$cells));
        }

        array_push($rows,$row);

        return $rows;
    }

    //*
    //* sub Html_Hidden, Parameter list: $table,$period,$rows
    //*
    //* Add $rows periodically to $table.
    //*

    function Html_AddPeriodicRows($table,$period,$rows)
    {
        $n=0;

        $rtables=$this->PageArray($table,$period);

        $rrtable=array();

        $n=1;
        foreach ($rtables as $rtable)
        {
            $rrtable=array_merge
            (
               $rrtable,
               $rows,
               $rtable
            );

            $n++;
        }

        return $rrtable;
    }
}
?>