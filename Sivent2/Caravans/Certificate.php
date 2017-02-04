<?php


class Caravans_Certificate extends Caravans_Caravaneers
{
    //*
    //* function Caravan_Certificate_Where, Parameter list: $caravan,$friendid=0
    //*
    //* Returns $where clause for submission certificate.
    //*

    function Caravan_Certificate_Where($caravan,$friendid=0)
    {
        if (empty($friendid)) { $friendid=$caravan[ "Friend" ]; }
        
        return
            array
            (
               "Unit"          => $caravan[ "Unit" ],
               "Event"         => $caravan[ "Event" ],
               "Friend"        => $friendid,
               "Type"          => $this->Certificate_Type,
            );
    }

    //*
    //* function Caravan_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Caravan_Handle_Certificate_Generate()
    {
        $where=$this->Caravan_Certificate_Where($this->ItemHash);

        $cert=$this->CertificatesObj()->Sql_Select_Hash($where);

        $latex=$this->CertificatesObj()->Certificate_Generate($cert);
        $this->CertificatesObj()->Certificate_Set_Generated($cert);


        $where=
            $this->UnitEventWhere
            (
                array
                (
                    "Friend" => $this->ItemHash[ "Friend" ],
                    "Type" => $this->CaravaneersObj()->Certificate_Type,
                )
            );

        foreach ($this->CertificatesObj()->Sql_Select_Hashes($where) as $cert)
        {
            $latex.=$this->CertificatesObj()->Certificate_Generate($cert);
            $this->CertificatesObj()->Certificate_Set_Generated($cert);
        }
        
        $latex=$this->CertificatesObj()->Certificates_Latex_Ambles_Put($latex);
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
    //* function Caravan_Handle_Certificate_Generate, Parameter list: 
    //*
    //* Generates submission certificate in Latex, generates and sends the PDF.
    //*

    function Caravan_Handle_Certificate_Mail_Send()
    {
        $this->CertificatesObj()->Certificates_Generate_Mail_Send
        (
           $this->FriendsObj()->Sql_Select_Hash(array("ID" => $this->ItemHash[ "Friend" ])),
           $this->Caravan_Certificate_Where($this->ItemHash)
        );
    }
    
    //*
    //* function Caravan_Certificates_Where, Parameter list: 
    //*
    //* Returns $where clause for all submission certificates.
    //*

    function Caravans_Certificates_Where()
    {
        return
            array
            (
               "Unit"        => $this->Unit("ID"),
               "Event"       => $this->Event("ID"),
               "Type"        => array($this->Certificate_Type,$this->CaravaneersObj()->Certificate_Type,)
            );
    }

    //*
    //*
    //* function Caravan_Handle_Certificates_Generate, Parameter list: 
    //*
    //* Generates certificate in Latex, generates and sends the PDF.
    //*

    function Caravans_Handle_Certificates_Generate()
    {
        return
            $this->CertificatesObj()->Certificates_Generate_Handle
            (
               $this->Caravans_Certificates_Where(),
               "Certs.Caravans.".
               $this->Event("Name")
            );
    }
    
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
              $this->EventsObj()->Event_Caravans_Has($event)
            )
        {
            $this->MakeSureWeHaveRead("",$item,array("Certificate","TimeLoad"));
            if (!empty($item[ "Certificate" ]) && $item[ "Certificate" ]==2)
            {
                if (empty($item[ "Certificate_CH" ]))
                {
                    $item[ "Certificate_CH" ]=$event[ "Caravans_Coord_Timeload" ];
                    array_push($updatedatas,"Certificate_CH");
                }
            }
        }
    }

    
    //*
    //* function PostProcess_Certificate, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription certificate.
    //*

    function PostProcess_Certificate(&$item,&$updatedatas)
    {
        $this->CertificatesObj()->Sql_Table_Structure_Update();
        
        $nparts=
            $this->CaravaneersObj()->Sql_Select_NHashes
            (
                array
                (
                    "Unit" =>  $item[ "Unit" ],
                    "Event" => $item[ "Event" ],
                    "Friend" => $item[ "Friend" ],
                    "Certificate" => 2,
                )
            );
        
        $cert=1;
        if ($nparts>0)
        {
            $cert=2;
        }

        if (empty($item[ "Certificate" ]) || $cert!=$item[ "Certificate" ])
        {
            $item[ "Certificate" ]=$cert;
            array_push($updatedatas,"Certificate");
        }
        
        if (!empty($item[ "Certificate" ]))
        {
            foreach (array("Friend") as $fdata)
            {
                if (empty($item[ $fdata ])) { continue; }
                
                $where=$this->Caravan_Certificate_Where($item,$item[ $fdata ]);
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
                               "Caravan"     => $item[ "ID" ],
                               "Unit"        => $this->Unit("ID"),
                               "Event"        => $item[ "Event" ],
                               "Friend"       => $item[ $fdata ],
                               "Type"         => $this->Certificate_Type,
                               "Name"         => $item[ "Name" ],
                               "Code"         => $item[ "Code" ],
                            );

                        $this->CertificatesObj()->Sql_Insert_Item($cert);
                    }

                    if (count($certs)>1)
                    {
                        array_shift($certs);
                        foreach ($certs as $cert)
                        {
                            $this->CertificatesObj()->Sql_Delete_Item($cert[ "ID" ]);
                        }
                    }
                }
            }
        }
    }
}
?>