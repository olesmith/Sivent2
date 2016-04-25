<?php


class ItemLatex extends ItemPostProcess
{

    //*
    //* Trims all fields of $item, as latex code.
    //* Except fields with keys starting with _, for ex. _Name.
    //*

    function TrimLatexItem($item=array())
    {
        if  (count($item)==0) { $item=$this->ItemHash; }

        foreach ($item as $key => $value)
        {
            $value=preg_replace('/(&\s*#039;)/',"'",$value);
            if (isset($this->ItemData[ $key ]))
            {
                if (!empty($this->ItemData[ $key ][ "LatexCode" ]))
                {
                    $value=preg_replace('/&/',"\\&",$value);
                    $value=preg_replace('/\^/',"\\^",$value);
                }

                if (
                      !empty($this->ItemData[ $key ][ "Sql" ])
                      &&
                      $this->ItemData[ $key ][ "Sql" ]=="FILE"
                      &&
                      !is_array($value)
                   )
                {
                    $value=basename($value);
                    $value=preg_replace('/^\./',"",$value);
                }

                if (
                      !empty($this->ItemData[ $key ][ "TimeType" ])
                      &&
                      $this->ItemData[ $key ][ "TimeType" ]==1
                   )
                {
                    $value=$this->TimeStamp2Text($value);
                }

                if (!empty($this->ItemData[ $key ][ "IsHour" ]))
                {
                    $value=$this->CreateHourShowField($key,$item,$value);
                }

                if (!empty($this->ItemData[ $key ][ "LatexFormat" ]))
                {
                    $value=sprintf($this->ItemData[ $key ][ "LatexFormat" ],$value);
                }
            }

            $value=preg_replace('/_/',"\\_",$value);
            $item[ $key ]=$value;
        }

        return $item;
    }

    //*
    //* Generates Latex code item from DB. Based on skeleton in
    //* value returned by $this->GetSingularLatexDoc().
    //*

    function LatexItem($item=array())
    {
        $this->LatexData();

        if  (count($item)==0) { $item=$this->ItemHash; }

        $latexdocno=$this->CGI2LatexDocNo();
        $latexinfo=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];
        if (!empty($latexinfo[ "PreMethod" ]))
        {
            $preprocessmethod=$latexinfo[ "PreMethod" ];
            $item=$this->$preprocessmethod($item);
        }


        $item=$this->ApplyAllEnums($item,TRUE);
        $item=$this->TrimLatexItem($item);
        $latex=$this->GetSingularLatexDoc();

        $latex=$this->Filter($latex,$item);
        $latex=$this->FilterObject($latex);

        return $latex;
    }

    //*
    //* function  GetLatexSelectFieldRow, Parameter list: $type
    //*
    //* Prints Latex miniformulario for selecting LatexDoc
    //* 
    //*

    function GetLatexSelectFieldRow($type,$form=FALSE)
    {
        $latexdocs=$this->LatexData[ $type."LatexDocs" ][ "Docs" ];
        if (is_array($latexdocs)&& count($latexdocs)>0)
        {
            if ($type=="Singular")
            {
                $row=array
                (
                   $this->H
                   (
                      3,
                      $this->GetMessage($this->LatexDataMessages,"PrintFormTitle").":"
                   )
                );

                foreach ($this->LatexSelectForm($type,$form) as $cell)
                {
                    array_push($row,$this->Center($cell));
                }
            }
            else
            {
                $row=array
                (
                   $this->SPAN
                   (
                      $this->GetMessage($this->LatexDataMessages,"PrintFormTitle").":",
                      array("CLASS" => 'printformtitle')
                   )
                );

                foreach ($this->LatexSelectForm($type,$form) as $cell)
                {
                    array_push($row,$cell);
                }
                array_push($row,"");
            }
    
            return $row;//join("\n",$row);
        }

        return array();
        
    }

    //*
    //* function GenerateLatexHorMenu , Parameter list:
    //*
    //* Generates Latex menu of pritables.
    //* 
    //*

    function GenerateLatexHorMenu()
    {
        $latexdocs=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ];

        $hash=$this->Query2Hash();
        $hash[ "Action" ]="Print";
        $hash[ "ID" ]=$this->ItemHash[ "ID" ];


        $hrefs=array();
        $n=1;
        if (is_array($latexdocs)&& count($latexdocs)>0)
        {
            foreach ($latexdocs as $latexdoc)
            {
                $hash[ "LatexDoc" ]=$n;
                array_push
                (
                   $hrefs,
                   $this->Href
                   (
                      "?".$this->Hash2Query($hash),
                      $latexdoc[ "Name" ],
                      "",
                      "",
                      "",
                      "",
                      array
                      (
                         "CLASS" => "printmenu",
                      )
                   )
                );

                $n++;
            }

            return $this->Center
            (
               $this->SPAN("Impressos: ",array("CLASS" => "printmenu")).
               "[ ".
                join(" | ",$hrefs).
                " ]".
                ""
            );
        }

        return "";
        
    }


    function ItemLatexTable($item=array(),$datalist=array())
    {
        if (count($item)==0) { $item=$this->ItemHash; }

        $item=$this->ApplyAllEnums($item,TRUE);
        $item=$this->TrimLatexItem($item);

        if (!is_array($datalist) || count($datalist)==0)
        {
            $datalist=array_keys($this->ItemData);
        }

        $tbl=array();
        foreach ($datalist as $data)
        {
            $name=$this->ItemData[ $data ][ "Name" ];

            if ($this->ItemData[ $data ][ "Hidden" ]!="") {}
            elseif (preg_match('/[AMC]Time/',$data)) {}
            elseif (
                  preg_match('/^(\S+)_(.+)/',$data,$matches)
                  &&
                  isset($this->ItemData[ $matches[1] ][ "SqlObject" ])
                  &&
                  $this->ItemData[ $matches[1] ][ "SqlObject" ]!=""
                  &&
                  isset($this->ItemData[ $matches[2] ][ "Name" ])
                )
            {
                $object=$this->ItemData[ $matches[1] ][ "SqlObject" ];

                $name=$this->$object->ItemData[ $matches[2] ][ "Name" ];
                $value=$item[ $data ];
                array_push($tbl,array("\\textbf{".$name.":}",$value));
            }
            else
            {   
                $access=$this->MyMod_Data_Access($data,$item);
                if ($access>=1)
                {
                    if (isset($this->ItemDerivedData[ $data ][ "LongName" ]))
                    { 
                        $name=$this->ItemDerivedData[ $data ][ "LongName" ];
                    }
                    elseif (isset($this->ItemDerivedData[ $data ][ "Name" ]))
                    {
                        $name=$this->ItemDerivedData[ $data ][ "Name" ];
                    }
                    elseif (isset($this->ItemData[ $data ][ "LongName" ]))
                    {
                        $name=$this->ItemData[ $data ][ "LongName" ];
                    }
                    else
                    {
                        $name=$this->ItemData[ $data ][ "Name" ];
                    }

                    $value=$item[ $data ];
                    array_push($tbl,array("\\textbf{".$name.":}",$value));
                }
            }
        }

        return $tbl;
    }


    function ItemLatexTablePrint($title,$item=array(),$noid=0,$rdatalist=array())
    {
        $this->ApplicationObj->LogMessage("ItemLatexTablePrint",$item[ "ID" ].": ".$this->GetItemName($item));
        $item=$this->ApplyAllEnums($item);
        $title=$this->ItemName.": ".$this->GetItemName($item);

        $this->LatexData[ "PageTitle" ]="\\begin{Large}\n".$title."\n\\end{Large}\n\n\\vspace{0.25cm}";
        $this->LatexData[ "NItemsPerPage" ]=50;

        $tbl=$this->ItemLatexTable($item,$noid,$rdatalist);
        $latex=
            $this->LatexHead().
            "\\begin{center}\n".
            $this->LatexTable("",$tbl).
            "\\end{center}\n".
            $this->LatexTail();

        $latex=$this->TrimLatex($latex);

        $texfile="Item.".$this->ModuleName.".".time().".tex";
        return $this->RunLatexPrint($texfile,$latex);
    }
}
?>