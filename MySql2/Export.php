<?php

class Export extends Import
{

    //*
    //* Variables of Export class:
    //*

    
    //*
    //* Initializer for  Export class, run by Base class
    //*

    function InitExport($hash=array())
    {
    }

    //*
    //* Reads all Export CGI vars from CGI to hash (returned)
    //*

    function ReadExportCGI()
    {
        $nfields=$this->GetCGIVarValue("NFields");
        if ($nfields=="") { $nfields=5; }

        $reverse=$this->GetCGIVarValue("Sort_Reverse");
        $go=$this->GetCGIVarValue("Go");

        $type=$this->GetCGIVarValue("Export_Type");
        if ($type=="") { $type="HTML"; }

        $applyenums=$this->GetCGIVarValue("Apply_Enums");
        $alldata=$this->GetCGIVarValue("All_Data");

        $fields=array
        (
            "NFields"    => $nfields,
            "Reverse"    => $reverse,
            "Type"       => $type,
            "ApplyEnums" => $applyenums,
            "AllData"    => $applyenums,
            "Go"         => $go,
            "Fields"     => array(),
        );

        for ($n=1;$n<=$nfields;$n++)
        {
            array_push
            (
                $fields[ "Fields" ],
                array
                (
                    "Data" => $this->GetCGIVarValue("Data_".$n),
                    "Search" => $this->GetCGIVarValue("Search_".$n),
                    "Sort" => $this->GetCGIVarValue("Sort_".$n),
                )
            );
        }

        return $fields;
    }

    //*
    //* Returns title of data
    //*

    function ExportDerivedDataTitle($data,$rdata)
    {
        if (isset($this->ItemData[ $data ][ "SqlObject" ]))
        {
            $subobj=$this->ItemData[ $data ][ "SqlObject" ];
            $subobj=$this->$subobj;

            return 
                $this->GetDataTitle($data).", ".
                $subobj->GetDataTitle($rdata);
        }
    }

     //*
    //* Returns two lists, all data and their titles.
    //*

    function ExportDataAndTitles()
    {
        $rdatas=array_keys($this->ItemData);

        $names=array();
        $datas=array();
        foreach ($rdatas as $data)
        {
            $name=$this->ItemData[ $data ][ "Name" ];
            if ($name=="") { $name=$data; }
            array_push($names,$this->ItemData[ $data ][ "Name" ]);
            array_push($datas,$data);

            $nameshash[ $data ]=$name;

            $deriveddata=$this->ItemData[ $data ][ "SqlDerivedData" ];
            $derivednames=$deriveddata;
            if (isset($this->ItemData[ $data ][ "SqlDerivedDataNames" ]))
            {
                $derivednames=$this->ItemData[ $data ][ "SqlDerivedDataNames" ];
            }
            elseif (isset($this->ItemData[ $data ][ "SqlObject" ]))
            {
                foreach ($deriveddata as $id => $rdata)
                {
                    $derivednames[ $id ]=$this->ExportDerivedDataTitle($data,$rdata);
                }
            }
            if (!is_array($derivednames)) { $derivednames=array(); }
            if (!is_array($deriveddata)) { $deriveddata=array(); }

            for ($n=0;$n<count($deriveddata);$n++)
            {
                if ($deriveddata[ $n ]!="")
                {
                    $rdata=$data."_".$deriveddata[ $n ];
                    $name=$derivednames[ $n ];
                    if ($name=="") { $name=$rdata; }
                    
                    array_push($names,$name);
                    array_push($datas,$rdata);
                }
            }
        }

        return array($datas,$names);
    }



    //*
    //* Fabricates the Export Form, possibly calling DoExport.
    //* $fields are the Export vars, if undef calls ReadExportCGI
    //* to get it.
    //*

    function ExportForm($fields=array(),$title="")
    {
        if (count($fields)==0)
        {
            $fields=$this->ReadExportCGI();
        }

        $res=$this->ExportDataAndTitles();

        $datas=$res[0];
        $names=$res[1];
        //$nameshash=$this->Lists2Hash($datas,$names);


        $go=$this->GetCGIVarValue("Go");

        array_unshift($datas,"");
        array_unshift($names,"");


        $table=array();
        for ($n=1;$n<=$fields[ "NFields" ];$n++)
        {
            $data=$fields[ "Fields" ][ $n-1 ][ "Data" ];
            $sort=$fields[ "Fields" ][ $n-1 ][ "Sort" ];
            $search=$fields[ "Fields" ][ $n-1 ][ "Search" ];

            $select=$this->MakeSelectField("Data_".$n,$datas,$names,$data);
            $searchfield=$this->MakeInput("Search_".$n,$search);
            $checksort=$this->MakeCheckBox("Sort_".$n,1,$sort);

            $row=array("<B>Coluna #".$n."</B>",$select,$searchfield,$checksort);
            array_push($table,$row);
        }

        $alldata=$fields[ "AllData" ];
        $alldata=$this->MakeCheckBox("All_Data",1,$alldata);
        array_push($table,array("","","<B>Todos os Dados:</B>",$alldata));
        

        $exports=array("HTML","CSV","LaTeX","PDF","SQL");

        $sortreverse=$fields[ "Reverse" ];
        array_push
        (
            $table,
            array
            (
                "<B>N&ordm; de Colunas:</B>",
                $this->MakeInput("NFields",$fields[ "NFields" ],2),
                "<B>Reverter:</B>",
                $this->MakeCheckBox("Sort_Reverse",1,$sortreverse)
            )
        );

        $applies=array("Sim","Não");
        array_push
        (
            $table,
            array
            (
                "<B>Formato:</B>",
                $this->MakeSelectField("Export_Type",$exports,$exports,$fields[ "Type" ]),
                "<B>Aplicar Enums:</B>",
                $this->MakeSelectField("Apply_Enums",$applies,$applies,$fields[ "ApplyEnums" ])
            )
        );

        $titles=array("","Dado à incluir","Pesquisar","Sortear");

        if ($fields[ "Type" ]=="HTML")
        {
            $this->ApplicationObj->MyApp_Interface_Head();
            $this->MyMod_HorMenu();

            if ($title=="") { $title="Exportar Dados de ".$this->ItemsName; }
            print
                "<DIV ALIGN='center' CLASS='exportable'>\n".
                $this->H(2,$title).
                $this->StartForm().
                $this->HTMLTable($titles,$table).
                $this->MakeHidden("Export",1).
                $this->MakeHidden("Go",1).
                $this->Button("submit","Enviar").
                $this->Button("reset","Resetar").
                $this->EndForm().
                "</DIV>\n";
        }

        if ($go==1)
        {
            $this->DoExport($fields);
        }

    }

    //*
    //* Gathers apropriate titles for datas in array $datas.
    //*

    function GetTableDataTitles($datas,&$titles=array())
    {
        foreach ($datas as $data)
        {
            $title="";
            if (isset($this->ItemData[ $data ][ "Name" ])) { $title=$this->ItemData[ $data ][ "Name" ]; }
            if ($title=="")
            {
                $comps=preg_split('/_/',$data);
                $rdata=array_shift($comps);
                $rrdata=join(" ",$comps);

                $pos=-1;
                foreach ($this->ItemData[ $rdata ][ "SqlDerivedData" ]
                         as $id => $ddata)
                {
                    if ($ddata==$rrdata)
                    {
                        $pos=$id;
                    }
                }

                if ($pos>=0)
                {
                    $title=$this->ExportDerivedDataTitle($rdata,$ddata);
                }
                else
                {
                    $title=$rrdata;
                }
            }

            if ($title=="")
            {
                $title=$data;
            }

            array_push($titles,$title);
        }

        return $titles;
    }


    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function ExportTable($fields=array(),$applyenums=FALSE,$links=TRUE)
    {
        if (count($fields)==0)
        {
            $fields=$this->ReadExportCGI();
        }

        $this->IncludeAll=1;

        $nfields=$fields[ "NFields" ];
        $datas=array();
        for ($n=1;$n<=$nfields;$n++)
        {
            $data=$fields[ "Fields"][ $n-1 ][ "Data" ];
            if (preg_match('/\S/',$data))
            {
                array_push($datas,$data);
            }
        }

        $titles=array("No");
        $titles=$this->GetTableDataTitles($datas,$titles);

        $nosearches=FALSE;
        $nopaging=FALSE;
        $includeall=1;
        $rrdatas=array_keys($this->ItemData);
        $rdatas=array();
        foreach ($rrdatas as $id => $data)
        {
            if (
                !$this->ItemData[ $data ][ "Derived" ] &&
                $this->ItemData[ $data ][ "DerivedFilter" ]!=""
               )
            {
                array_push($rdatas,$data);
            }
        }

        $rdatas=array_keys($this->ItemData);
        $this->ReadItems("",$rdatas,$nosearches,$nopaging,$includeall);

        $search=array();
        $dosearch=0;
        $sort=$datas[0];

        $sorts=array();
        $n=1;
        foreach ($datas as $data)
        {
            $searchvalue=$fields[ "Fields"][ $n-1 ][ "Search" ];
            if ($searchvalue!="")
            {
                $search[ $data ]=$searchvalue;
                $dosearch++;
            }


            $sortvalue=$fields[ "Fields"][ $n-1 ][ "Sort" ];
            if ($sortvalue!="")
            {
                array_push($sorts,$data);
            }

            $n++;
        }

        if ($dosearch>0) { $this->SearchItems($search,0,FALSE); }

        if (count($sorts)>0)
        {
            $sort=$sorts;
        }

        $sortreverse=$fields[ "Reverse"];
        $this->SortItems($sort,$sortreverse);


        $format="%d";
        $nc=count(array_keys($this->ItemHashes));

            if ($nc>10000)  { $format="%05d"; }
        elseif ($nc>100000) { $format="%06d"; }
        elseif ($nc>1000)   { $format="%04d"; }
        elseif ($nc>100)    { $format="%03d"; }
        elseif ($nc>10)     { $format="%02d"; }
 

        $values=array();
        $m=1;
        foreach ($this->ItemHashes as $id => $item)
        {
            if ($applyenums)
            {
                $item=$this->ApplyAllEnums($item,FALSE);
            }

            $nn=sprintf($format,$m);
            $row=array($nn);
            foreach ($datas as $data)
            {
                //if ($applyenums)
                //{
                //    array_push($row,"123".$this->MakeShowField($data,$item,TRUE,$links));
                //}
                //else
                //{
                    array_push($row,$item[ $data ]);
                    //}
            }

            array_push($values,$row);
            $m++;
        }

        return array($values,$titles);

    }

    //*
    //* Calls ExportTable to gather the export table, and
    //* prints this in relevant format.
    //*

    function DoExport($fields=array())
    {
        $outdoc=$this->ModuleName.".Export";

        if (count($fields)==0)
        {
            $fields=$this->ReadExportCGI();
        }

        $exporttype=$fields[ "Type" ];
        if ($exporttype!="HTML")
        {
            $this->NoTail=1;
        }

        $applyenums=TRUE;
        if (preg_match('/^N/',$fields[ "ApplyEnums" ]))
        {
            $res=$this->ExportTable($fields,FALSE);
        }
        else
        {
            $res=$this->ExportTable($fields,TRUE);
        }

        $values=$res[0];
        $titles=$res[1];



        $this->LatexData[ "NItemsPerPage" ]=50;
        $this->LatexData[ "PageTitle" ]=
            "\n\n\\Large{\\textbf{Relatório de ".
            $this->ItemsName."}}\n\n\\vspace{0.5cm}\n\n";


        if ($exporttype=="HTML")
        {
            print $this->HTMLTable($titles,$values);
        }
        elseif ($exporttype=="CSV")
        {
            for ($n=0;$n<count($titles);$n++)
            {
                $titles[$n]=preg_replace('/;/'," ",$titles[$n]);
            }

            $this->SendDocHeader("csv",$outdoc.".csv");

            print join(";",$titles)."\n";
            foreach ($values as $row)
            {
                print join(";",$row)."\n";
            }
        }
        elseif ($exporttype=="LaTeX")
        {
            $this->SendDocHeader("tex",$outdoc.".tex");
            print $this->LatexTable($titles,$values);
        }
        elseif ($exporttype=="SQL")
        {
            $rfields=$fields[ "Fields" ];
            $keys=array();
            foreach ($rfields as $id => $field)
            {
                if ($field[ "Data" ]!="")
                {
                    array_push($keys,$field[ "Data" ]);
                }
            }

            $sql=array
            (
             "INSERT INTO `".$this->SqlTableName()."`",
                "(`".join("`,`",$keys)."`) VALUES",
            );


            foreach ($values as $id => $vals)
            {
                $rvalues=array();
                foreach ($vals as $field => $value)
                {
                    //$value=utf8_encode($val);
                    $value=addslashes($value);
                    $value=preg_replace('/\n/',"\\r\\n",$value);
                    $value=preg_replace('/\t/',"\\t",$value);
                    array_push($rvalues,$value);
                }

                array_push($sql,"('".join("', '",$rvalues)."'),");
            }

            $sql[ count($sql)-1 ]=preg_replace('/,$/',";",$sql[ count($sql)-1 ]);

            $this->SendDocHeader("sql",$outdoc.".sql");

            print join("\n",$sql);
        }
        elseif ($exporttype=="PDF")
        {
            if (count($datas)>5)
            {
                $this->LatexData[ "Head" ]=
                    preg_replace
                    (
                     '/\.tex$/',
                     ".Land.tex",
                     $this->LatexData[ "Head" ]);
                $this->LatexData[ "NItemsPerPage" ]=30;
            }
            else
            {
                $this->LatexData[ "Head" ]=
                    preg_replace
                    (
                     '/\.Land\.tex$/',
                     ".tex",
                     $this->LatexData[ "Head" ]);
                $this->LatexData[ "NItemsPerPage" ]=50;
            }

            for ($n=0;$n<count($titles);$n++)
            {
                $titles[$n]=preg_replace('/_/',"\_",$titles[$n]);
            }

            $latex=$this->LatexHead().
                   "\\begin{center}\n".
                   $this->LatexTable($titles,$values).
                   "\\end{center}\n".
                   $this->LatexTail();

            $latex=$this->TrimLatex($latex);

            $texfilename=$outdoc.".tex";
            return $this->RunLatexPrint($texfilename,$latex);
        }
        else
        {
            print "Unsupported export type: $exporttype";
        }

    }

}


?>