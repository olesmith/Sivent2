<?php

class MyCertificates_Latex extends MyCertificates_Verify
{
    //*
    //* function Certificate_Latex_Filter_Datas, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificate_Latex_Filter_Datas()
    {
        return array_merge($this->UnitDatas,$this->EventDatas);
    }
    
    //*
    //* function Certificate_Latex_Head, Parameter list: 
    //*
    //* Generates latex certificate head.
    //*

    function Certificate_Latex_Head()
    {
        $latex=$this->GetLatexSkel("Head.Cert.tex");

        $watermark=$this->Event("Certificates_Watermark");
        if (!empty($watermark) && file_exists($watermark))
        {
            $latex=preg_replace
            (
               '/\\\\begin{document}/',
               "%%%!\n".
               "%%%! Watermark contribution to preamble\n".
               "\\usepackage{draftwatermark}\n".
               "\\SetWatermarkText{\\includegraphics[width=29.8cm]{".$watermark."}}\n". 
               "\\SetWatermarkAngle{0}\n".
               "\\SetWatermarkScale{1}\n".
               "\\SetWatermarkColor[rgb]{0,0,0}\n".
               "%%%!\n".
               "%%%!\n".
               "\\begin{document}".
               "",
               $latex
            );
        }

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
    //* function Certificate_Latex_Filter_Data, Parameter list: $data,$cert
    //*
    //* Generates latex certificate tail.
    //*

    function Certificate_Latex_Filter_Data($data,$cert,&$latex)
    {
        if (!empty($cert[ $data."_Hash" ]))
        {
            $latex=$this->FilterHash($latex,$cert[ $data."_Hash" ],$data."_");
        }
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
            $this->Certificate_Text($cert).
            "\n\n".
            $this->Certificate_Signatures(18).
            "\n\n".
            "\\clearpage\n\n".
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
}

?>