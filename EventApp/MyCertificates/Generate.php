<?php

class MyCertificates_Generate extends MyCertificates_Read
{
    //*
    //* function Certificate_Generate, Parameter list: &$cert
    //*
    //* Generates $cert.
    //*

    function Certificate_Generate(&$cert)
    {
        $this->Certificate_Read($cert);

        $latex="";
        if
            (
                $this->Certificate_Verify($cert)
                ||
                $this->Current_User_Event_Coordinator_Is()
            )
        {
            $this->Certificate_Set_Generated($cert);
            
            $latex=$this->Certificate_Latex($cert);
            $latex=$this->Certificate_Filter_Datas($latex,$cert);
            $latex=
                $this->MyHash_Filter
                (
                    $this->MyHash_Filter
                    (
                        $latex,
                        $this->Event(),
                        "Event_"
                    ),
                    $this->Unit(),
                    "Unit_"
                );
        }

        return $latex;
    }

    //*
    //* function Certificate_Filter_Datas, Parameter list: $latex,$cert
    //*
    //* Filter $cert over sub datas..
    //*

    function Certificate_Filter_Datas($latex,$cert)
    {
        foreach
            (
                array_merge($this->UnitDatas,$this->EventDatas)
                as $data
            )
        {
            if (!empty($cert[ $data."_Hash" ]))
            {
                $latex=$this->MyHash_Filter
                (
                    $latex,
                    $cert[ $data."_Hash" ],
                    $data."_"
                );
            }
        }

        return $this->MyHash_Filter($latex,$cert);
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
    //* function Certificate_Filter_EventUnit, Parameter list: $latex
    //*
    //* Filters $latex for event and unit data.
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
    //* Name of cert tex file name.
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
        $include=FALSE;
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
                $include=TRUE;
            }
        }

        if (!$include) { return ""; }

        return
            $this->Latex_Minipage
            (
               $this->LatexTable("",$table,"ccc",FALSE,FALSE),
               $width,
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
        $code="Certificate Code";
        if (!empty($cert[ "Code" ]))
        {
            $code=$cert[ "Code" ];
        }
        
        return
            "%%! Verification entry\n".
            "\\let\\thefootnote\\relax\n\\footnote{\n".
            $this->MyLanguage_GetMessage("Certificates_Validation_Message1").
            ": ".
            preg_replace('/\.0+/',".",preg_replace('/^0+/',"",$code)).
            ". ".
            $this->MyLanguage_GetMessage("Certificates_Validation_Message2").
            ": ".
            preg_replace('/[^https?]/',"",strtolower($_SERVER[ 'SERVER_PROTOCOL' ])).
            ":/".
            strtolower($_SERVER[ 'SERVER_NAME' ]).
            preg_replace('/index\.php/',"",$_SERVER[ 'SCRIPT_NAME' ]).
            "?Unit=".$this->Unit("ID")."\&Action=Validate".
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

        $texts=preg_split('/\s*\\\\(new|clear)page\s*/',$text);

        $latex="";
        foreach (array_keys($texts) as $id)
        {
            $texts[ $id ]=
                "\n\n\\hspace{1cm}\\vspace{".$vspace."cm}\n\n".
                $this->Latex_Minipage
                (
                    "\n%% Begin Unit key: ".$eventkey."\n".
                    $texts[ $id ].
                    "\n%% End Unit key: ".$eventkey."\n",
                    $width,
                    "c",
                    "l"
                ).
                "\n\n".
                $this->Certificate_Verification_Info($cert).
                "";
        }

        return join("\n\n\\clearpage\n\n",$texts);
    }
    
    
    //*
    //* function Certificate_Get_Empty, Parameter list: $cert=array()
    //*
    //* Sets Generated to current time().
    //*

    function Certificate_Get_Empty($cert=array())
    {
        $cert=$this->UnitEventWhere();
        foreach (array("Type","Inscription","Friend") as $key)
        {
            if (empty($cert[$key  ])) { $cert[ $key ]=1; }
        }
        
        foreach (array("Name") as $key)
        {
            if (empty($cert[$key  ])) { $cert[ $key ]=""; }
        }
        foreach (array("Code") as $key)
        {
            if (empty($cert[$key  ])) { $cert[ $key ]="1.1.1.1"; }
        }

        return $cert;
    }
    

    
    //*
    //* function Certificate_Set_Generated, Parameter list: $cert
    //*
    //* Sets Generated to current time().
    //*

    function Certificate_Set_Generated($cert)
    {
        if (!empty($cert[ "ID" ]))
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
}

?>