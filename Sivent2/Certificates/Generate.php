<?php

class Certificates_Generate extends Certificates_Latex
{
    //*
    //* function Certificate_Filter_EventUnit, Parameter list: $latex
    //*
    //* Generates signatures field.
    //*

    function Certificate_Filter_EventUnit($latex)
    {
        $latex=$this->FilterHash($latex,$this->Event(),"Event_");
        $latex=$this->FilterHash($latex,$this->Unit(),"Unit_");

        return $latex;
    }

    
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

    function Certificate_Verification_Info($cert)
    {
        $url=
            preg_replace('/[^htps]/',"",strtolower($_SERVER[ 'SERVER_PROTOCOL' ])).
            ":/".
            preg_replace('/index\.php/',"",$_SERVER[ 'SCRIPT_NAME' ]).
            "?Unit=".$this->Unit("ID")."\&Action=Validate";

        $code="Certificate Code";
        if (!empty($cert[ "Code" ]))
        {
            $code=$cert[ "Code" ];
        }
        
        return
            "%%! Omit footnote texting\n".
            "\\let\\thefootnote\\relax\n\\footnote{\n".
            $this->MyLanguage_GetMessage("Certificates_Validation_Message1").
            ": ".
            preg_replace('/0+/',"",$code).
            ".".
            $this->MyLanguage_GetMessage("Certificates_Validation_Message2").
            ": ".
            $url.
            "}";
    }

    //*
    //* function Certificate_Text, Parameter list: $type=1,$eventkey=""
    //*
    //* Generates certificate text ("Certificates_Latex" field).
    //*

    function Certificate_Text($cert)
    {
        $eventkey=$this->Type2LatexKey($cert);

        $text="Invalid Certificate Type";
        if (!empty($eventkey))
        {
            $event=$this->Event();

            $text=$this->GetRealNameKey($event,$eventkey);
            $text=html_entity_decode($text);
        }

        $key="Certificates_Latex_Sep_Vertical";
        $vspace=$this->Event($key);

        
        $key="Certificates_Latex_Sep_Horisontal";
        $hspace=$this->Event($key);

        $width=28-2*$hspace;
        return
            "\n\n\\hspace{1cm}\\vspace{".$vspace."cm}\n\n".
            $this->Latex_Minipage($width,$text,"c","l").
            "";
    }
    
    

    
    //*
    //* function Certificate_Set_Generated, Parameter list: $cert
    //*
    //* Sets Generated to current time().
    //*

    function Certificate_Set_Generated($cert)
    {
        if (!empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item
            (
               array("Generated" => time()),
               array("ID" => $cert[ "ID" ]),
               array("Generated")
            );
        }
    }
    
    //*
    //* function Certificate_Set_Mailed, Parameter list: $cert
    //*
    //* Sets Mailed to current time().
    //*

    function Certificate_Set_Mailed($cert)
    {
        $this->Sql_Update_Item
        (
           array("Mailed" => time()),
           array("ID" => $cert[ "ID" ]),
           array("Mailed")
        );
    }

    //*
    //* function Certificate_Read, Parameter list: $cert,$type
    //*
    //* Sets Mailed to current time().
    //*

    function Certificate_Read($cert)
    {
        foreach (array("Event","Friend","Inscription","Submission","Collaborator","Collaboration","Caravaneer") as $data)
        {
            $cert[ $data."_Hash" ]=array();
            if (!empty($cert[ $data ]))
            {
                $objmethod=$data."sObj";
                $cert[ $data."_Hash" ]=
                    $this->$objmethod()->Sql_Select_Hash
                    (
                       array("ID" => $cert[ $data ],)
                    );

                
            }
        }

        if (!empty($cert[ "Submission_Hash" ]))
        {
            $cert[ "Submission_Hash" ][ "Authors" ]=
                join("\\\\\\\\\n",$this->SubmissionsObj()->Submission_Authors_Get($cert[ "Submission_Hash" ]));
        }
        
        $cert[ "Event_Hash" ][ "DateSpan" ]=$this->EventsObj()->Event_Date_Span($cert[ "Event_Hash" ]);
                
        return $cert;
    }


    //*
    //* function Certificates_Generate, Parameter list: $certs
    //*
    //* Generates $certs.
    //*

    function Certificates_Generate($certs)
    {
        $latex="";
        foreach ($certs as $cert)
        {
            $latex.=$this->Certificate_Generate($cert);
        }
        
        return $this->Certificate_Filter_EventUnit($latex);
    }

    //*
    //* function Certificates_Latex_Ambles_Put, Parameter list: $latex
    //*
    //* Generates $certs.
    //*

    function Certificates_Latex_Ambles_Put($latex)
    {
        return
            $this->Certificate_Latex_Head().
            "\n\n".
            $latex.
            "\n\n".
            $this->Certificate_Latex_Tail().
            "";
    }

    
    //*
    //* function Certificates_Generate_Handle_ByCode, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Handle_ByCode()
    {
        $code=$this->CGI_GET("Code");
        $certs=$this->Certificate_Code2Cert($code);

        $name="";
        $latex=
            $this->Certificates_Latex_Ambles_Put
            (
               $this->Certificates_Generate($certs)
            );
        
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }
        
        return $this->Latex_PDF($this->CertificatesObj()->Certificate_TexName($name),$latex);
    }
    
    //*
    //* function Certificates_Generate_Handle, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Handle($where,$latexname)
    {
        $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);            

        $latex=$this->CertificatesObj()->Certificates_Generate($certs);

        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }

        return
            $this->Latex_PDF
            (
               $this->CertificatesObj()->Certificate_TexName($latexname),
               $latex
             );
    }
    
}

?>