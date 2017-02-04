<?php


trait MyMod_Items_Print
{
    //*
    //* Prints file name.
    //*

    function MyMod_Items_Print_FileName()
    {
        return
            $this->ApplicationObj->HtmlSetupHash[ "WindowTitle" ].
            $this->ModuleName.".".
            $this->MTime2FName().
            ".tex";
    }
    
    //*
    //* Add contents latex entries.
    //*

    function MyMod_Items_Add_Latex_Entries()
    {
        $latexdocno=$this->CGI2LatexDocNo();

        $latex="";
        $newpage=FALSE;
        if (isset($this->LatexData[ "PluralLatexDocs" ][ $latexdocno ][ "TableOfContents" ]))
        {
            $latex.="\n\\tableofcontents\n\n";
            $newpage=TRUE;
        }
        if (isset($this->LatexData[ "PluralLatexDocs" ][ $latexdocno ][ "ListOfTables" ]))
        {
            $latex.="\n\\listoftables\n\n";
            $newpage=TRUE;
        }
        if (isset($this->LatexData[ "PluralLatexDocs" ][ $latexdocno ][ "ListOfFigures" ]))
        {
            $latex.="\n\\listoffigures\n\n";
            $newpage=TRUE;
        }

        if ($newpage) { $latex.="\\newpage\n\n"; }

        return $latex;
    }
    
    //*
    //* Prints items.
    //*

    function MyMod_Items_Print($items=array())
    {
        if  (count($items)==0) { $items=$this->ItemHashes; }
        
        return $this->Latex_PDF
        (
           $this->MyMod_Items_Print_FileName(),
           $this->GetLatexHead
           (
               "Plural",
               $this->CGI2LatexDocNo()
           ).
           $this->MyMod_Items_Add_Latex_Entries().
           $this->MyMod_Items_Latex($items).
           $this->LatexTail()
        );
    }
}

?>