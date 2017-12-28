<?php


class Submissions_Certificate extends Submissions_Latex
{
    //*
    //* function Certificate_Code, Parameter list: $item
    //*
    //* Generates certificate code.
    //*

    function Certificate_Code($item)
    {
        return $this->CertificatesObj()->Certificate_Code($item,$this->Certificate_Type);
    }
    
    //*
    //* function PostProcess_Code, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription code.
    //*

    function PostProcess_Code(&$item,&$updatedatas)
    {
        if (
              !empty($item[ "ID" ])
              &&
              !empty($item[ "Friend" ])
              &&
              !empty($item[ "Event" ])
           )
        {
            $code=$this->Certificate_Code($item,$this->Certificate_Type);
            if (!empty($code) && empty($item[ "Code" ]) || $item[ "Code" ]!=$code)
            {
                $item[ "Code" ]=$code;
                array_push($updatedatas,"Code");
            }
        }
    }

    

    //*
    //* function PostProcess_Certificate_TimeLoad, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess_Certificate_TimeLoad(&$item,&$updatedatas)
    {
        $event=$this->Event();
        if (
              $this->EventsObj()->EventCertificates($event)
              &&
              $this->EventsObj()->Event_Submissions_Has($event)
            )
        {
            $this->MakeSureWeHaveRead("",$item,array("Certificate","Certificate_TimeLoad"));
            if (!empty($item[ "Certificate" ]) && $item[ "Certificate" ]==2)
            {
                if (empty($item[ "Certificate_TimeLoad" ]))
                {
                    $item[ "Certificate_TimeLoad" ]=$event[ "Certificates_Submissions_TimeLoad" ];
                    array_push($updatedatas,"Certificate_TimeLoad");
                }
            }
        }
    }

    
    //*
    //* function PostProcess_Certificate, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription certificate.
    //*

    function PostProcess_Certificate(&$item)
    {
        if (!empty($item[ "Certificate" ]))
        {
            foreach ($this->Authors_Datas("Friend") as $fdata)
            {
                if (empty($item[ $fdata ])) { continue; }
                
                $where=$this->Submission_Certificate_Where($item,$item[ $fdata ]);
                $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);
                
                if ($item[ "Certificate" ]==1)
                {
                    if (count($certs)>0)
                    {
                        $this->CertificatesObj()->Sql_Delete_Items($where);
                    }
                }
                elseif ($item[ "Certificate" ]==2)
                {
                    if (empty($certs))
                    {
                        $cert=
                            array
                            (
                               "Submission" => $item[ "ID" ],
                               "Unit"        => $this->Unit("ID"),
                               "Event"        => $item[ "Event" ],
                               "Friend"       => $item[ $fdata ],
                               "Type"         => $this->Certificate_Type,
                               "Name"         => $item[ "Title" ],
                               "Code"         => $item[ "Code" ],
                            );

                        $this->CertificatesObj()->Sql_Insert_Item($cert);
                    }
                }
            }
        }
    }

    //*
    //* function Submission_Certificate_Where, Parameter list: $inscription,$friendid=0
    //*
    //* Returns $where clause for submission certificate.
    //*

    function Submission_Certificate_Where($submission,$friendid=0)
    {
        if (empty($friendid)) { $friendid=$submission[ "Friend" ]; }
        
        return
            array
            (
               "Unit"        => $submission[ "Unit" ],
               "Event"       => $submission[ "Event" ],
               "Friend"      => $friendid,
               "Submission" => $submission[ "ID" ],
               "Type"        => $this->Certificate_Type,
            );
    }

    //*
    //* function Submission_Authors_Get, Parameter list: $submission
    //*
    //* Returns submission authors as a list.
    //*

    function Submission_Authors_Get($submission)
    {
        $authors=array();
        foreach ($this->Authors_Datas("Author") as $data)
        {
            if (!empty($submission[ $data ]))
            {
                array_push($authors,$submission[ $data ]);
            }
        }

        return $authors;
    }
    
    //*
    //* function Submission_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Submission_Handle_Certificate_Generate()
    {
        $where=$this->Submission_Certificate_Where($this->ItemHash);
        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);            

        $latex=
            $this->CertificatesObj()->Certificates_Latex_Ambles_Put
            (
               $this->CertificatesObj()->Certificate_Generate($cert)
            );

        $this->CertificatesObj()->Certificate_Set_Generated($cert);
        
        if ($this->CGI_GET("Latex")!=1)
        {
            $this->ShowLatexCode($latex);
        }

        return
            $this->Latex_PDF
            (
               $this->CertificatesObj()->Certificate_TexName
               (
                  $cert[ "Friend_Hash" ][ "Name" ]
               ),
               $latex
             );
    }
    
    //*
    //* function Submission_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates submission certificate in Latex, generates and sends the PDF.
    //*

    function Submission_Handle_Certificate_Mail_Send()
    {
        $this->CertificatesObj()->Certificates_Generate_Mail_Send
        (
           $this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ])),
           $this->Submission_Certificate_Where($this->ItemHash)
        );
    }
    
    //*
    //* function Submission_Certificates_Where, Parameter list: 
    //*
    //* Returns $where clause for all submission certificates.
    //*

    function Submission_Certificates_Where()
    {
        return
            array
            (
               "Unit"        => $this->Unit("ID"),
               "Event"       => $this->Event("ID"),
               "Type"        => $this->Certificate_Type,
            );
    }

    //*
    //* function Submission_Handle_Certificates_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Submission_Handle_Certificates_Generate()
    {
        return
            $this->CertificatesObj()->Certificates_Generate_Handle
            (
               $this->Submission_Certificates_Where(),
               "Certs.Submissions.".
               $this->Event("Name")
            );
    }
    
}
?>