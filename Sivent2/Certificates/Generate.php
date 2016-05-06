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
        
        return
            "\\let\\thefootnote\\relax\\footnote{Este certificado possui código de verificação: ".
            preg_replace('/0+/',"",$cert[ "Code" ]).
            ". Para Verificar, acesse: ".
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
        $eventkey=$this-> Type2LatexKey($cert);

        $text="Invalid Certificate Type";
        if (!empty($eventkey))
        {
            $event=$this->Event();

            $text=$this->GetRealNameKey($event,$eventkey);
            $text=html_entity_decode($text);
       }

        return
            $this->Latex_Minipage(18,$text,"c","l").
            "";
    }
    
    

    
    //*
    //* function Certificate_Set_Generated, Parameter list: $cert
    //*
    //* Sets Generated to current time().
    //*

    function Certificate_Set_Generated($cert)
    {
        $this->Sql_Update_Item
        (
           array("Generated" => time()),
           array("ID" => $cert[ "ID" ]),
           array("Generated")
        );
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
        foreach (array("Event","Friend","Inscription","Submission","Collaborator","Collaboration","Caravan") as $data)
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
            "%%%!  Certificate_Generate: ".$cert[ "Friend_Hash" ][ "Name" ]."\n".
            "\\begin{center}\n".
            $this->Certificate_Text($cert).
            "\n\n".
            $this->Certificate_Signatures(18).
            "\n\n".
            "\\end{center}\n".
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
    //* function Certificates_Generate_Handle, Parameter list: 
    //*
    //* Generates cert.
    //*

    function Certificates_Generate_Handle()
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
        
        return $this->RunLatexPrint($this->CertificatesObj()->Certificate_TexName($name),$latex);
    }
    
}

?>