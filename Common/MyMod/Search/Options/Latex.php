<?php


trait MyMod_Search_Options_Latex
{
    //*
    //* function MyMod_Search_Options_Latex_Row, Parameter list: $type,$form=FALSE
    //*
    //* 
    //*

    function MyMod_Search_Options_Latex_Rows($omitvars,$type,$form=FALSE)
    {
        if (preg_grep('/^Printing/',$omitvars))
        {
            return array();
        }
        
        $latexdocs=$this->LatexData[ $type."LatexDocs" ][ "Docs" ];

        $table=$this->MyMod_Search_Options_Latex_Form($type,$form);

        $rows=array();
        if (is_array($latexdocs) && count($latexdocs)>0)
        {
            $row=array();
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

                foreach ($table as $cell)
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

                foreach ($table as $cell)
                {
                    array_push($row,$cell);
                }
                array_push($row,"");
            }

            $rows=array($row);
        }

        return $rows;
    }

    //*
    //* function MyMod_Search_Options_Latex_Form, Parameter list: $type,$form=FALSE
    //*
    //* Prints Latex miniformulario for selecting LatexDoc
    //* 
    //*

    function MyMod_Search_Options_Latex_Form($type,$form=FALSE)
    {
        $row=array();
        if (is_array($this->LatexData[ $type."LatexDocs" ][ "Docs" ]))
        {
            $docnos=array();
            $docnames=array(); //space to prevent selecting first

            if ($type=="Plural")
            {
                array_push($docnos,0);
                array_push($docnames," ");
            }
            
            foreach ($this->LatexData[ $type."LatexDocs" ][ "Docs" ] as $n => $def)
            {
                array_push($docnos,$n+1);
                array_push($docnames,$def[ "Name" ]);
            }


            $latexdocno=$this->CGI_POST("LatexDoc");
            $nempties=$this->CGI_POST("NEmptyLines");
            if ($nempties=="") { $nempties=0; }

            $print="Print";
            $href="?Action=PrintList";
            if ($type=="Singular")
            {
                $href="?Action=Print&ID=".$this->CGI_GETOrPOST("ID");
            }

            if (!$latexdocno) { $latexdocno=0; }
            if (count($docnames)>0)
            {
                if ($form)
                {
                    array_push
                        (
                            $row,
                            $this->StartForm($href)
                        );
                }

                array_push
                    (
                        $row,
                        $this->MakeSelectField("LatexDoc",$docnos,$docnames,$latexdocno)
                    );

                if ($type!="Singular")
                {
                    array_push
                        (
                            $row,
                            $this->MakeInput("NEmptyLines",$nempties,2)." extras"
                        );
                }

                if ($form)
                {
                    array_push
                        (
                            $row,
                            $this->Button("submit","Imprimir").
                            $this->EndForm()
                        );

                    $row=array(join("\n",$row));
                }
            }
        }

        return $row;
    }

}

?>