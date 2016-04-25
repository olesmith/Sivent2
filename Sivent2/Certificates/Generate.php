<?php

class Certificates_Generate extends Certificates_Latex
{
    //*
    //* function Certificate_TexName, Parameter list: $name
    //*
    //* Generates signatures field.
    //*

    function Certificate_TexName($name)
    {
        $texfile=preg_replace('/\s+/',".",$name);
        
        return
             "Cert.".
            $this->Text2Sort($texfile).".".
            $this->MTime2FName().
            ".tex";
    }

    
     //*
    //* function Certificate_Signatures, Parameter list: 
    //*
    //* Generates signatures field.
    //*

    function Certificate_Signatures($width)
    {
        $table=array(array(),array(),array(),array());
        for ($n=1;$n<=3;$n++)
        {
            $key="Certificates_Signature_".$n;
            $file=$this->Event($key);
            
            $text1=$this->Event($key."_Text1");
            $text2=$this->Event($key."_Text2");
            
            if (!empty($file) && !empty($text1) && file_exists($file))
            {
                array_push($table[0],"\\includegraphics[height=1.5cm]{".$file."}\n");
                array_push($table[1],"\\scriptsize{".$text1."}\n");
                array_push($table[2],"\\scriptsize{".$text2."}\n");                
                array_push($table[3],"\\hspace{6cm}\n");                
            }
        }

        return
            $this->Latex_Minipage
            (
               $width,
               $this->LatexTable("",$table,"ccc",FALSE,FALSE),
               "c","c"
            ).
            "";
    }

    //*
    //* function Certificate_Verification_Info, Parameter list: $inscription,$type
    //*
    //* Generates cert verification info.
    //*

    function Certificate_Verification_Info($inscription,$type)
    {
        $url=
            preg_replace('/[^htps]/',"",strtolower($_SERVER[ 'SERVER_PROTOCOL' ])).
            ":/".
            preg_replace('/index\.php/',"",$_SERVER[ 'SCRIPT_NAME' ]).
            "?Unit=".$this->Unit("ID")."\&Action=Validate";
        
        return
            "\\let\\thefootnote\\relax\\footnote{Este certificado possui código de verificação: ".
            $inscription[ "Code" ].
            $type.
            ". Para Verificar, acesse: ".
            $url.
            "}";
    }

    //*
    //* function Certificate_Text, Parameter list: $inscription,$friend=array()
    //*
    //* Generates certificate text ("Certificates_Latex" field).
    //*

    function Certificate_Text()
    {
        return
            $this->Latex_Minipage(18,$this->Event("Certificates_Latex"),"c","l").
            "";
    }
    
    

    
    //*
    //* function Certificate_Set_Generated, Parameter list: $cert,$type
    //*
    //* Sets Generated to current time().
    //*

    function Certificate_Set_Generated($cert,$type)
    {
        $this->Sql_Update_Item
        (
           array("Generated" => time()),
           $this->Certificate_Where($cert,$type),
           array("Generated")
        );
    }
    
    //*
    //* function Certificate_Set_Mailed, Parameter list: $cert,$type
    //*
    //* Sets Mailed to current time().
    //*

    function Certificate_Set_Mailed($cert,$type)
    {
        $this->Sql_Update_Item
        (
           array("Mailed" => time()),
           $this->Certificate_Where($cert,$type),
           array("Mailed")
        );
    }

    //*
    //* function Certificate_Generate, Parameter list: $cert
    //*
    //* Generates cert.
    //*

    function Certificate_Generate($cert,$inscription=array(),$friend=array())
    {
        if (empty($friend))
        {
            $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $cert[ "Friend" ]));
        }
        if (empty($inscription))
        {
            $inscription=$this->InscriptionsObj()->Sql_Select_Hash(array("ID" => $cert[ "Inscription" ]));
        }
        
        $latex=
            "%%%!  Certificate_Generate".$friend[ "Name" ]."\n".
            "\\begin{center}\n".
            $this->Certificate_Text().
            "\n\n".
            $this->Certificate_Signatures(18).
            "\n\n".
            "\\end{center}\n".
            $this->Certificate_Verification_Info($cert,1).
            "\n\n".
            "\n\n\\clearpage\n\n".
            "";

        $latex=$this->FilterHash($latex,$friend,"Friend_");
        $latex=$this->FilterHash($latex,$inscription,"Inscription_");
        $latex=$this->FilterHash($latex,$cert,"Certificate_");
        $latex=$this->FilterHash($latex,$inscription);

        $this->Certificate_Set_Generated($cert,1);

        return $latex;
    }
    
    //*
    //* function Certificates_Generate, Parameter list: $certs,&$name
    //*
    //* Generates cert.
    //*

    function Certificates_Generate($certs=array(),&$name)
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
    //* function Certificate_Generate_Handle, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificate_Generate_Handle()
    {
        $name="";
        $latex=
            $this->Certificate_Latex_Head().
            "\n\n".
            $this->Certificates_Generate(array(),$name).
            "\n\n".
            $this->Certificate_Latex_Tail().
            "";
        
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }
        
        return $this->RunLatexPrint($this->CertificatesObj()->Certificate_TexName($name),$latex);
        
    }
}

?>