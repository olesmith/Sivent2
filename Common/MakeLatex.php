<?php

include_once("MakeLatex/Table.php");

trait MakeLatex
{
    use MakeLatex_Table;
    
    //*
    //* function Latex_Env, Parameter list: $env,$content,$args="",$optargs="",$postargs=""
    //*
    //* Generates Latex multirow entry.
    //*

    function Latex_Env($env,$content,$args="",$optargs="",$postargs="")
    {
        if (!empty($args)) { $args="{".$args."}"; }
        if (!empty($optargs)) { $optargs="[".$optargs."]"; }
        
        return
            "\\begin{".$env."}".
            $optargs.$args.$postargs."\n".
            $content.
            "\n\\end{".$env."}".
            "";

    }
    
    //*
    //* function Latex_MiniPage, Parameter list: $width,$text,$align
    //*
    //* Generates Latex multirow entry.
    //*

    function Latex_Minipage($width,$text,$align='t')
    {
        return
            "\\begin{minipage}[".$align."]{".$width."}\n".
            $text."\n".
            "\\end{minipage}\n".
            "";

    }
    //*
    //* function Latex_Table_Multi_Row, Parameter list: $nrows,$text
    //*
    //* Generates Latex multirow entry.
    //*

    function Latex_Table_Multi_Row($nrows,$text)
    {
        if ($nrows>1)
        {
            $text=
                "\\multirow".
                "{".
                $nrows.
                "}{*}".
                "{".
                $text.
                "}";
        }
        
        return $text;
    }
    
    //*
    //* function Latex_Table_Multi_Col, Parameter list: $ncols,$text,$first=1,$spec="c"
    //*
    //* Generates Latex multicol entry.
    //*

    function Latex_Table_Multi_Col($ncols,$text,$first=1,$spec="c")
    {
        if ($ncols>1)
        {
            if ($first==0) { $spec="|".$spec; }
            $spec.="|";
            
            $text=
                "\\multicolumn{".
                    $ncols.
                    "}{".$spec."}{".
                    $text.
                    "}";
        }
        
        return $text;
    }
    
   
    //*
    //* function Latex_Table_Multi, Parameter list: $titles,$table
    //*
    //* Generates $date and $place scedule.
    //*

    function Latex_Table_Multi($titles,$table,$spec="c")
    {
        $clines=array();
        $rtable=array();
        
        $rids=array_keys($table);

        $width=0;
        foreach ($rids as $rid)
        {
            $row=$table[ $rid ];
            if (!is_array($row)) {  $row=array($row); }
            if (!empty($row[ "Row" ])) { $row=$row[ "Row" ]; }
            if ($width<count($row)) { $width=count($row); }
        }
        
        foreach ($rids as $rid)
        {
            $row=$table[ $rid ];
            if (!is_array($row))
            {
                $row=array
                (
                    $this->MultiCell($row,$width)
                );
                
                $table[ $rid ]=$row;
            }
            
           
            if (!is_array($row)) {  $row=array($row); }
            if (!empty($row[ "Row" ])) { $row=$this->B($row[ "Row" ]); }
            
            $rtable[ $rid ]=array();
            $clines[ $rid ]=array();

            $cids=array_keys($row);
            for ($m=0;$m<count($cids);$m++)
            {
                $cid=$cids[ $m ];
                
                $cell=$row[ $cid ];
                
                $text=$cell;
                if (!empty($cell[ "Text" ]))
                {
                    $text=$cell[ "Text" ];
                }
                
                $rtable[ $rid ][ $cid ]=$text;

                $start=$cid+1;
                $end=$start;
                if (!empty($cell[ "Options" ][ "COLSPAN" ]))
                {
                    $end=$start+$cell[ "Options" ][ "COLSPAN" ]-1;
                }
                
                $clines[ $rid ][ $cid ]=
                    "\\cline{".$start."-".$end."}";
            }
        }

        
        for ($n=0;$n<count($rids);$n++)
        {
            $rid=$rids[ $n ];
            
            $row=$table[ $rid ];
            
            if (!is_array($row))
            {
                $row=array
                (
                 $this->MultiCell($row,$width)
                );
            }
            
            if (!empty($row[ "Row" ])) { $row=$row[ "Row" ]; }
            
            $cids=array_keys($row);
            foreach ($row as $cid => $cell)
            {
                if (!empty($cell[ "Options" ]))
                {
                    if (!empty($cell[ "Options" ][ "ROWSPAN" ]))
                    {
                        for ($m=0;$m<$cell[ "Options" ][ "ROWSPAN" ]-1;$m++)
                        {
                            if ($rids[ $n+$m ])
                            {
                                $rrid=$rids[ $n+$m ];
                                unset($clines[ $rrid ][ $cid ]);
                            }
                        }

                        $rtable[ $rid ][ $cid ]=
                            $this->Latex_Table_Multi_Row
                            (
                               $cell[ "Options" ][ "ROWSPAN" ],
                               $rtable[ $rid ][ $cid ]
                            ).
                            "";
                    }

                    if (!empty($cell[ "Options" ][ "COLSPAN" ]))
                    {
                        $rtable[ $rid ][ $cid ]=
                            $this->Latex_Table_Multi_Col
                            (
                               $cell[ "Options" ][ "COLSPAN" ],
                               $rtable[ $rid ][ $cid ],
                               $cid
                            );
                    }
                    
                            
                }
            }

        }
        
        $specs=array();
        for ($n=0;$n<$width;$n++)
        {
            array_push($specs,$spec);
        }
        
        $latex="\\begin{tabular}{|".join("|",$specs)."|}\n\\hline\n";
        for ($n=0;$n<count($rids);$n++)
        {
            $rid=$rids[ $n ];
            $latex.=
                join("    &\n",$rtable[ $rid ])."\\\\\n".
                join(" ",$clines[ $rid ])."\n".
                "";
        }

        $latex.="\\end{tabular}\n";

        //$this->ShowLatexCode($latex);exit();

        return $latex;
    }


}
?>