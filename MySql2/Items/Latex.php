<?php

class ItemsLatex extends Item
{

    //*
    //* function TrimLatexItems, Parameter list:
    //*
    //* Trims items, preparing to output latex.
    //*

    function TrimLatexItems()
    {
        foreach ($this->ItemHashes as $id => $item)
        {
            //$this->ItemHashes[ $id ]=$this->TrimLatexItem($item);
        }
    }

    //*
    //* function PrintLatexCode, Parameter list: $latex
    //*
    //* Replaces all \n with <BR> and prints contents of $latex.
    //* Used for debugging.
    //*

    function PrintLatexCode($latex)
    {
        $latex=preg_replace('/\n/',"<BR>",$latex);
        print $latex;
        exit();
    }

    //*
    //* function SplitLatexItems, Parameter list: $items=array()
    //*
    //* Divides items into sections, subsections and so on.
    //*

    function SplitLatexItems($items=array())
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $latexdocno=$this->CGI2LatexDocNo();
        $latexinfo=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];

        if (!empty($latexinfo[ "SectionVar" ]))
        {
            $sectionvar=$latexinfo[ "SectionVar" ];
            $sections=$this->SplitItemsOnData($sectionvar,$items);
            $ritems=array();
            foreach ($sections as $varvalue => $sectionitems)
            {
                $sitem=$sectionitems[ 0 ];
                $sitem=$this->ApplyAllEnums($sitem);
                $sectionitems[ 0 ][ "LatexPre" ]=$this->FilterHash($latexinfo[ "SectionTitle" ],$sitem,TRUE);//TRUE for Latex values
                foreach ($sectionitems as $id => $item)
                {
                    array_push($ritems,$item);
                }
            }

            return $ritems;
        }

        return $items;
    }

    //*
    //* function LatexItems, Parameter list: $items=array()
    //*
    //* Latexifies all items read ($items, or as usual: $this-<ItemHashes if empty).
    //* First reads latex doc no from CGI, then $latexinfo from $this->LatexData.
    //* Next, reads Head, Glue and Tail based on $latexinfo.
    //* Looping over items, we fabricate the text string:
    //*
    //*  Head.
    //*  Glue filtered over first item.
    //*  Glue filtered over second item.
    //* ...
    //*  Glue filtered over last item.
    //*  Tail
    //*
    //*  If defined $accessmethod ($this->Actions[ "Print" ][ "AccessMethod" ]), this method
    //*  is called on item, in order to check if inclusion of each item is allowed or not.
    //* Checks $latexinfo[ "ItemsPerPage" ] in order to change page, inserting:
    //* Head.
    //* \newpage
    //* Tail.
    //*

    function LatexItems($items=array())
    {
        return $this->MyMod_Items_Latex($items);
    }

    //*
    //* function GetLatexHead, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function GetLatexHead($type,$latexdocno=0)
    {
        return $this->GetLatexSkel
        (
           $this->LatexData[ $type."LatexDocs" ][ "Docs" ][ $latexdocno ][ "Head" ]
        );
    }

    //*
    //* function GetLatexGlue, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function GetLatexGlue($type,$latexdocno=0)
    {
        return $this->GetLatexSkel
        (
           $this->LatexData[ $type."LatexDocs" ][ "Docs" ][ $latexdocno ][ "Glue" ]
        );
    }

    //*
    //* function GetLatexTail, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function GetLatexTail($type,$latexdocno=0)
    {
        return $this->GetLatexSkel
        (
           $this->LatexData[ $type."LatexDocs" ][ "Docs" ][ $latexdocno ][ "Tail" ]
        );
    }


    //*
    //* function PrintItems, Parameter list: $items=array()
    //*
    //* Generates full latex doc for a list of items;
    //* Reads latex preamble calling LatexHead - or LatexHeadLand if $latexinfo[ "Landscape" ].
    //* 
    //* Includes a \listofcontentes, if $latexinfo[ "ListOfContents" ] is set;
    //* a \listoftables, if $latexinfo[ "ListOfTables" ] is set;
    //* and a \listoffigures, if $latexinfo[ "ListOfFigures" ] is set.
    //* Calls LatexItems to generate latex text, and TrimLatex to trim this.
    //* Finally calls RunLatexPrint to actually save the code in tmp file and run pdflatex.
    //*

    function PrintItems($items=array())
    {
        return $this->MyMod_Items_Print($items);
    }

    //*
    //* function ItemsLatexTable, Parameter list: $title,$items=array(),$datas=array(),$titles=array()
    //*
    //* Creates latex table with dats in the columns, one for each item in $item.
    //* If $datas is the empty list, retrieves $datas from actual data group.
    //* Join the data in the table, and call LatexTable to generate the actual table.
    //* Finally call RunLatexPrint in order to save in temp file and run pdflatex.
    //*

    function ItemsLatexTable($printlatex=FALSE,$items=array(),$datas=array(),$titles=array())
    {
        if (count($items)==0)     { $items=$this->ItemHashes; }

        $group="";
        if (count($datas)==0)
        {
            $group=$this->GetActualDataGroup();
            $datas=$this->GetGroupDatas($group);
            if (is_array($this->ItemDataGroups[ $group ][ "TitleData"]))
            {
                $titles=$this->ItemDataGroups[ $group ][ "TitleData"];
                $datas=$this->ItemDataGroups[ $group ][ "Data"];
            }
            else
            {
                $titles=$this->GetDataTitles($datas,1);
            }
        }

        if (
              is_array($this->ItemDataGroups[ $group ])
              &&
              isset($this->ItemDataGroups[ $group ][ "LatexData" ])
           )
        {
            foreach ($this->ItemDataGroups[ $group ][ "LatexData" ] as $key => $value)
            {
                $this->LatexData[ $key ]=$value;
            }
        }

        $rdatas=array();
        $rtitles=array();
        $nskip=0;
        $tablespecs=array();
        for ($n=0;$n<count($titles);$n++)
        {
            $data=$datas[$n];
            if (!isset($this->Actions[ $data ]) &&
                $datas[$n]!="No")
            {
                array_push($rdatas,$data);
                array_push($rtitles,$titles[$n]);
            }
            else
            {
                $nskip++;
            }

            if (isset($this->ItemData[ $data ]) && $this->ItemData[ $data ][ "LatexWidth" ]!="")
            {
                array_push($tablespecs,"p{".$this->ItemData[ $data ][ "LatexWidth" ]."}");
            }
            elseif (isset($this->ItemData[ $data ]))
            {
                array_push($tablespecs,"l");                
            }
        }
        array_unshift($tablespecs,"l");

        $firstnewlines=preg_grep('/newline\((\d+)\)(\((\S+)\))?/',$datas);
        $firstnewline=array_shift($firstnewlines);

        $nempties=0;
        $counterfield="";
        if (preg_match('/newline\((\d+)\)(\((\S+)\))?/',$firstnewline,$match))
        {
            $nempties=$match[1];
            $counterfield=$match[2];
            $counterfield=preg_replace('/[\(\)]/',"",$counterfield);
        }

        $nempties-=$nskip;

        $datamatrix=array($rdatas);
        $datarow=array();
        $rrdatas=array();
        for ($n=count($titles);$n<count($datas);$n++)
        {
            if (preg_match('/newline\((\d+)\)(\((\S+)\))?/',$datas[$n]))
            {
                if (count($rrdatas)>0)
                {
                    $rrrdatas=$rrdatas;
                    array_push($datamatrix,$rrrdatas);
                    $rrdatas=array();
                }
            }
            else
            {
                array_push($rrdatas,$datas[$n]);
            }
        }

        if (count($rrdatas)>0)
        {
            array_push($datamatrix,$rrdatas);
        }

        $tbl=array();
        $nn=1;
        foreach ($items as $item)
        {
            $item=$this->ApplyAllEnums($item,TRUE);
            $item=$this->TrimLatexItem($item);

            $counter=500;
            if ($counterfield!="" && isset($item[ $counterfield ])) { $counter=$item[ $counterfield ]; }

            $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]);
            $nn=sprintf("%03d",$nn);

            $rows=array();

            $count=1;
            $number=1;
            $row=array($nn);
            foreach ($datamatrix as $datarow)
            {
                if ($count<=$counter)
                {
                    foreach ($datarow as $data)
                    {
                        if (!isset($item[ $data ])) { continue; }

                        $value=$item[ $data ];
                        if (!preg_match('/\S/',$value)) { $value=""; }
                        array_push($row,$value);
                    }

                    $rrow=$row;
                    array_push($rows,$rrow);

                    $row=array();
                    for ($n=0;$n<$nempties;$n++) { array_push($row,""); }

                    $count++;
                }
            }

            foreach ($rows as $rrow) { array_push($tbl,$rrow); }

            if (preg_grep('/\S/',$row))
            {
                array_push($tbl,$row);
            }


            $nn++;
        }

        $this->LatexData[ "PageTitle" ]=
            "\\begin{Large}\\textbf{\nRelatório de ".
            $this->ItemsName."\n}\\end{Large}\n\n\\vspace{0.25cm}";


        $tablespecs="|".join("|",$tablespecs)."|";

        $headmethod="LatexHead";

        if ($this->LatexData[ "PluralLatexDocs" ][ "Landscape" ])
        {
            $headmethod="LatexHeadLand";
            $this->LatexData[ "PluralLatexDocs" ][ "NItemsPerPage" ]=
                $this->LatexData[ "PluralLatexDocs" ][ "NItemsPerPage_Land" ];
        }

        array_unshift($rtitles,'N$^o$');
        $latex=
            $this->$headmethod().
            "\\begin{center}\\begin{small}\n".
            $this->LatexTable($rtitles,$tbl,$tablespecs).
            "\\end{small}\\end{center}\n".
            $this->LatexTail();

        $latex=$this->TrimLatex($latex);
        $texfile=
            $this->ApplicationObj->HtmlSetupHash[ "WindowTitle" ].
            $this->ModuleName.".".
            $this->MTime2FName().
            ".tex";

        if ($printlatex)
        {
            $this->SendDocHeader("tex",$texfile);
            print $latex;
        }
        else
        {
            return $this->RunLatexPrint($texfile,$latex);
        }
    }

    //*
    //* function ItemLatexTablesPrint, Parameter list: $datas,$ids=array()
    //*
    //* Latex items in $items, if empty in $this->ItemHashes;.
    //*

    function ItemLatexTablesPrint($items=array())
    {
        $this->LatexData[ "PageTitle" ]="";
        $this->LatexData[ "NItemsPerPage" ]=50;

        if (count($items)==0) { $items=$this->ItemHashes; }
        $this->ApplicationObj->LogMessage("ItemLatexTablesPrint",count($items)." items");
        $latex="";
        foreach ($items as $id => $item)
        {
            $item=$this->ApplyAllEnums($item);

            $tbl=$this->ItemLatexTable($item);

            $latex.=
                "\\begin{center}\n".
                "\\begin{Large}\n".
                $this->ItemName." ".$item[ "ID" ].": ".$this->GetItemName($item).
                "\n\\end{Large}\n\\vspace{0.25cm}\n\n".
                $this->LatexTable("",$tbl).
                "\\end{center}\n\n".
                "\n\n\\newpage\n\n";
        }

        $latex=
            $this->LatexHead().
            $latex.
            $this->LatexTail();

        $texfile=
            $this->ApplicationObj->HtmlSetupHash[ "WindowTitle" ].
            $this->ModuleName.".".
            $this->MTime2FName().
            ".tex";
        $latex=$this->TrimLatex($latex);
        return $this->RunLatexPrint($texfile,$latex);
   }
}
?>