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

    //*
    //* function Certificate_Latex_Filter, Parameter list: $cert,$inscription=array(),$friend=array(),$eventkey=""
    //*
    //* Generates cert.
    //*

    function Certificate_Latex_Filter($cert,$latex)
    {
        $latex=$this->FilterHash($latex,$cert[ "Event_Hash" ],"Event_");
        $latex=$this->FilterHash($latex,$cert[ "Friend_Hash" ],"Friend_");
        $latex=$this->FilterHash($latex,$cert[ "Inscription_Hash" ],"Inscription_");
        $latex=$this->FilterHash($latex,$cert[ "Collaboration_Hash" ],"Collaboration_");
        $latex=$this->FilterHash($latex,$cert[ "Collaborator_Hash" ],"Collaborator_");
        $latex=$this->FilterHash($latex,$cert[ "Caravaneer_Hash" ],"Caravaneer_");
        $latex=$this->FilterHash($latex,$cert[ "Submission_Hash" ],"Submission_");
        $latex=$this->FilterHash($latex,$cert,"Certificate_");
        $latex=$this->FilterHash($latex,$cert[ "Inscription_Hash" ]);

        return $latex;
    }

    
    //*
    //* function Certificate_Latex, Parameter list: $cert,$inscription=array(),$friend=array(),$eventkey=""
    //*
    //* Generates cert.
    //*

    function Certificate_Latex(&$cert)
    {
        $cert=$this->Certificate_Read($cert);

        $latex=
            //"\\begin{center}\n".
            $this->Certificate_Text($cert).
            "\n\n".
            $this->Certificate_Signatures(18).
            "\n\n".
            //"\\end{center}\n".
            $this->Certificate_Verification_Info($cert).
            "\n\n".
            "\n\n\\clearpage\n\n".
            "";

        $latex=$this->Certificate_Latex_Filter($cert,$latex);

        $this->Certificate_Set_Generated($cert);

        return $latex;
    }
    
    //*
    //* function Certificates_Latex, Parameter list: $certs,&$name
    //*
    //* Generates cert.
    //*

    function Certificates_Latex($certs=array(),&$name)
    {
        if (empty($certs)) { $certs=$this->Certificates_Validate_Read(); }
        
        $latex="";
        foreach ($this->Certificates_Validate_Read() as $cert)
        {
            $latex.=$this->Certificate_Generate($cert);
            $name=$cert[ "Name" ];
        }

        return $latex;
    }
    
    //*
    //* function Certificate_Generate, Parameter list: &$cert
    //*
    //* Generates $cert.
    //*

    function Certificate_Generate(&$cert)
    {
        $this->Certificate_Set_Generated($cert);

        return $this->FilterHash
        (
           $this->FilterHash
           (
              $this->Certificate_Latex($cert),
              $this->Event(),"Event_"
           ),
           $this->Unit(),"Unit_"
        );
    }
}

?>