<?php

global $ClassList;
array_push($ClassList,"OptionsTable");


class OptionsTable extends Base
{
    //*
    //* Variables of OptionsTable class:
    //*

    var $SetupOptions=array();
    var $Options=array
    (
       "Title" => "Options title",
       "CGIStub" => 'Options_',
    );

    //*
    //* function Options2Table, Parameter list: $setups,$title="",$ncellsperline=5,$hashkey="",$hash=array()
    //*
    //* Creates options table according to $setups.
    //* 

    function Options2Table($setups,$title="",$ncellsperline=5,$hashkey="",$hash=array())
    {
        $table=array();
        foreach ($setups as $key => $setup)
        {
            $table=array_merge
            (
               $table,
               $this->SetupGroup2Rows($setup,$ncellsperline,$hashkey,$hash)
            );
        }


        //Calculate resultant $width
        $width=0;
        foreach (array_keys($table) as $tid)
        {
            if (count($table[ $tid ])>$width)
            {
                $width=count($table[ $tid ]);
            }
        }


        //Pad rows according to $width.
        foreach (array_keys($table) as $tid)
        {
            for ($n=count($table[ $tid ]);$n<=$width;$n++)
            {
                array_push($table[ $tid ],"");
            }
        }

        array_unshift($table,array($title.$this->MakeHidden("ReadOptions",1)));
        return $this->Html_Table("",$table);
    }

    //*
    //* function Options2Tables, Parameter list: $setups,$title=""
    //*
    //* Creates options tables according to $setups.
    //* 

    function Options2Tables($setups,$title="",$ncellsperline=5,$hashkey="",$hash=array())
    {
        $tables=array();
        foreach ($setups as $key => $setup)
        {
            $table=$this->SetupGroup2Rows($setup,$ncellsperline,$hashkey,$hash);

            //Calculate resultant $width
            $width=0;
            foreach (array_keys($table) as $tid)
            {
                if (count($table[ $tid ])>$width)
                {
                    $width=count($table[ $tid ]);
                }
            }


            //Pad rows according to $width.
            foreach (array_keys($table) as $tid)
            {
                for ($n=count($table[ $tid ]);$n<=$width;$n++)
                {
                    array_push($table[ $tid ],"");
                }
            }
            array_push
            (
               $tables,
               $this->SetupGroup2Rows($setup,$ncellsperline,$hashkey,$hash)
            );
        }

        return $tables;
    }


    //*
    //* function SetupGroup2Rows, Parameter list: $setup,$ncellsperline,$hashkey="",$hash=array()
    //*
    //* Creates options table rows according to $setup.
    //* 

    function SetupGroup2Rows($setup,$ncellsperline,$hashkey="",$hash=array())
    {
        $table=array();

        if (!empty($setup[ "Title" ]))
        {
            array_push
            (
               $table,
               array
               (
                  $this->Cell2Input("Title",$setup).
                  $this->B($this->Cell2Title($setup)),
                  ""
               )
            );
        }

        $disabled=0;
        if (!empty($setup[ "Type" ]))
        {
            $value=$this->CellCGI2Value("Type",$setup,$hashkey,$hash);
            if (empty($value))
            {
                $disabled=1;
            }
        }

        foreach ($setup[ "Rows" ] as $key => $line)
        {
            if (!empty($setup[ "MonoLine" ]))
            {
                $table=array_merge
                (
                   $table,
                   $this->SetupLine2Row($line,$disabled,$ncellsperline,$hashkey,$hash)
                );
            }
            else
            {
                $table=array_merge
                (
                   $table,
                   $this->SetupLine2Rows($line,$disabled,$ncellsperline,$hashkey,$hash)
                );
            }
        }

        return $table;
    }

    //*
    //* function SetupLine2Row, Parameter list: $setup,$disabled,$ncellsperline,$hashkey="",$hash=array()
    //*
    //* Creates options rows (1 row) according to $setup.
    //* 

    function SetupLine2Row($line,$disabled,$ncellsperline,$hashkey="",$hash=array())
    {
        $row=array("");
        foreach ($line as $key => $celldef)
        {
            if (!empty($celldef[ "Title" ]))
            {
                array_push
                (
                   $row,
                   $this->Cell2Title($celldef)
                );
            }
          
            if (!empty($celldef[ "Type" ]))
            {
                array_push
                (
                   $row,
                   $this->Cell2Input($celldef[ "CGI" ],$celldef,$disabled,$hashkey,$hash)
                );  
            }          
        }

        $row=$this->PageArray($row,$ncellsperline);
        return $row;
    }
    //*
    //* function SetupLine2Rows, Parameter list: $setup,$disabled,$ncellsperline,$hashkey="",$hash=array()
    //*
    //* Creates options rows (2 rows) according to $setup.
    //* 

    function SetupLine2Rows($line,$disabled,$ncellsperline,$hashkey="",$hash=array())
    {
        $rows=array(array(),array(),);
        foreach ($line as $key => $celldef)
        {
            array_push
            (
               $rows[0],
               $this->Cell2Title($celldef)
            );            
            array_push
            (
               $rows[1],
               $this->Cell2Input($celldef[ "CGI" ],$celldef,$disabled,$hashkey,$hash)
            );            
        }

        $rows[0]=$this->PageArray($rows[0],$ncellsperline);
        $rows[1]=$this->PageArray($rows[1],$ncellsperline);

        $rrows=array();
        for ($n=0;$n<count($rows[0]);$n++)
        {
            array_unshift($rows[0][$n],""); array_unshift($rows[1][$n],"");

            array_push($rrows,$rows[0][$n]);
            array_push($rrows,$rows[1][$n]);
        }

        return $rrows;
    }

    //*
    //* function Cell2Default, Parameter list: $key,$celldef,$hashkey="",$hash=array()
    //*
    //* Returns $celldef default value, $celldef[ "Default" ] 
    //*

    function Cell2Default($key,$celldef,$hashkey="",$hash=array())
    {
        $value=$celldef[ "Default" ];
        if (!empty($hashkey))
        {
            $hashkey=$hashkey."_".$key;
            if (isset($hash[ $hashkey ]))
            {
                $value=$hash[ $hashkey ];
            }
        }

        return $value;        
    }

    //*
    //* function CellCGI2Accessor, Parameter list: $celldef
    //*
    //* Returns $celldef acessor name, $celldef[ "Accessor" ] 
    //*

    function Cell2Accessor($celldef)
    {
        return $celldef[ "Accessor" ];
    }


    //*
    //* function Cell2CGI, Parameter list: $cell
    //*
    //* Returns $cell CGI name.
    //* 

    function Cell2CGI($celldef)
    {
        return
            $this->Options[ "CGIStub" ].
            $celldef[ "CGI" ];
    }

    //*
    //* function CGI2Value, Parameter list: $cell
    //*
    //* Returns value from CGI, considering:
    //*
    //* POST ReadOptions==1: Read CGI
    //* Otherwise use default.
    //* 

    function CellCGI2Value($key,$celldef,$hashkey="",$hash=array())
    {
        $value=$this->Cell2Default($key,$celldef,$hashkey,$hash);

        $cgikey=$this->Cell2CGI($celldef);
        if (isset($_POST[ $cgikey ]))
        {
            $value=$this->GetPOST($cgikey);
        }
        elseif (isset($_POST[ "ReadOptions" ]) && empty($value))
        {
            $value=FALSE;
        }

        return $value;        
    }

    //*
    //* function Cell2Value, Parameter list: $celldef
    //*
    //* Returns $celldef title, $celldef[ "Title" ] 
    //*

    function Cell2Value($celldef)
    {
        $value="";
        if (!empty($celldef[ "Value" ]))
        {
            $value=$celldef[ "Value" ];
        }

        return $value;
    }

    //*
    //* function Cell2Title, Parameter list: $celldef
    //*
    //* Returns $celldef title, $celldef[ "Title" ] 
    //*

    function Cell2Title($celldef)
    {
        return $celldef[ "Title" ];
    }

    //*
    //* function Cell2Type, Parameter list: $celldef
    //*
    //* Returns $celldef type, $celldef[ "Type" ] 
    //*

    function Cell2Type($celldef)
    {
        $type="";
        if (!empty($celldef[ "Type" ]))
        {
            $type=$celldef[ "Type" ];
        }

        return $type;
    }


    //*
    //* function Cell2Input, Parameter list: $key,$celldef,$active=0,$hashkey="",$hash=array()
    //*
    //* Creates input cell according to $cell.
    //* 

    function Cell2Input($key,$celldef,$active=0,$hashkey="",$hash=array())
    {
        $type=$this->Cell2Type($celldef);

        $cell="";
        if ($type=="CheckBox")
        {
            $cell=$this->MakeCheckBox
            (
               $this->Cell2CGI($celldef),
               1,
               $this->CellCGI2Value($key,$celldef,$hashkey,$hash),
               $active
            );
        }
        elseif ($type=="Input")
        {
            $cell=$this->MakeInput
            (
               $this->Cell2CGI($celldef),
               $this->CellCGI2Value($key,$celldef,$hashkey,$hash),
               $celldef[ "Size" ]
             );
        }
        elseif ($type=="Radio")
        {
            $value=$this->CellCGI2Value($key,$celldef,$hashkey,$hash);
            $checked=FALSE;
            if ($value==$this->Cell2Value($celldef))
            {
                $checked=TRUE;
            }
            $cell=$this->MakeRadio
            (
               $this->Cell2CGI($celldef),
               $this->Cell2Value($celldef),
               $checked,
               0,
               array("TITLE" => $this->Cell2Title($celldef))
            );
        }
        elseif ($type=="TextArea")
        {
              $cell=$this->MakeTextArea
              (
                 $this->Cell2CGI($celldef),
                 $celldef[ "Height" ],
                 $celldef[ "Width" ],
                 $this->Cell2Value($celldef,$hashkey,$hash)
               );
        }

        return $cell;
    }


    //*
    //* function Options2Accessor, Parameter list: $celldef,$hashkey="",$hash=array()
    //*
    //* Registers accessor, setting: .
    //*

    function Options2Accessor($key,$celldef,$hashkey="",$hash=array())
    {
        if (!empty($celldef[ "Accessor" ]))
        {
            $accessor=$this->Cell2Accessor($celldef);
            $this->$accessor=$this->CellCGI2Value($key,$celldef,$hashkey,$hash);

            $cgi=$this->Cell2CGI($celldef);
       }
    }
    //*
    //* function Options2Accessors, Parameter list: $setups,$hashkey="",$hash=array()
    //*
    //* Reads CGI to class acessors (attributes).;
    //*

    function Options2Accessors($setups,$hashkey="",$hash=array())
    {
        foreach ($setups as $key => $setup)
        {
            //$this->Options2Accessor($key,$setup,$hashkey,$hash);
            foreach ($setup[ "Rows" ] as $rkey => $line)
            {
                foreach ($line as $rrkey => $celldef)
                {
                    $rrrkey=$celldef[ "CGI" ];
                    $this->Options2Accessor($rrrkey,$celldef,$hashkey,$hash);
                }
            }
        }
    }


}
?>