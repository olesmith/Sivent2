<?php

include_once("Latex/Files.php");


trait MyMod_Latex
{
    use MyMod_Latex_Files;
    
    //*
    //* Creates row with item cells.
    //*

    function MyMod_Latex_Read()
    {
        foreach ($this->MyMod_Latex_Files_Get() as $file)
        {
            if (file_exists($file))
            {
                $this->MyMod_Latex_Add_File($file);
            }
        }
    }
    
    //*
    //* function MyMod_Latex_Skel, Parameter list: $type,$skel,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Skel($type,$skel,$latexdocno=0)
    {
        return $this->GetLatexSkel
        (
           $this->LatexData[ $type."LatexDocs" ][ "Docs" ][ $latexdocno ][ $skel ]
        );
    }
    
    //*
    //* functionMyMod_Latex_Head , Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Head($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Head",$latexdocno);
    }

    //*
    //* function MyMod_Latex_Glue, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Glue($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Glue",$latexdocno);
    }

    //*
    //* function GetLatexTail, Parameter list: $type,$latexdocno=0
    //*
    //* Return latex header (until and including \begin{document}. 
    //*

    function MyMod_Latex_Tail($type,$latexdocno=0)
    {
        return $this->MyMod_Latex_Skel($type,"Tail",$latexdocno);
    }


}

?>