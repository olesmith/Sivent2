<?php

class Certificates_Latex extends Certificates_Validate
{
    //*
    //* function Certificate_Latex_Head, Parameter list: 
    //*
    //* Generates latex certificate head.
    //*

    function Certificate_Latex_Head()
    {
        $latex=$this->GetLatexSkel("Head.Cert.tex");

        $watermark=$this->Event("Certificates_Watermark");
        if (empty($watermark) || !file_exists($watermark))
        {
            echo "Fatal Error: No watermark file: '".$watermark."'";
            exit();
        }
        
        $latex=preg_replace
        (
           '/\\\\begin{document}/',
           "%%%!\n".
           "%%%! Watermark contribution to preamble\n".
           "\\usepackage{draftwatermark}\n".
           "\\SetWatermarkText{\\includegraphics[width=26cm]{".$watermark."}}\n". 
           "\\SetWatermarkAngle{0}\n".
           "\\SetWatermarkScale{1}\n".
           "%%%!\n".
           "%%%!\n".
           "\\begin{document}".
           "",
           $latex
        );

        return $latex;
    }
    
    //*
    //* function Certificate_Latex_Tail, Parameter list: 
    //*
    //* Generates latex certificate tail.
    //*

    function Certificate_Latex_Tail()
    {
        return $this->GetLatexSkel("Tail.Cert.tex");
    }

}

?>