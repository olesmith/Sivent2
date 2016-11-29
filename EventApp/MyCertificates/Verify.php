<?php

class MyCertificates_Verify extends MyCertificates_Code
{
    //*
    //* function Certificate_Verify, Parameter list: $cert
    //*
    //* Generates $certs.
    //*

    function Certificate_Verify(&$cert)
    {
        $certdata=$this->Certificate_Data[ $cert[ "Type" ] ];
        $this->Certificate_Read_Data($cert,$certdata);
        
        $event=
            $this->EventsObj()->Sql_Select_Hash
            (
                array("ID" => $cert[ "Event" ]),
                array("ID","Certificates","Certificates_Published")
            );

        $res=TRUE;

        if (!$this->EventsObj()->Event_Certificates_Published($event))
        {
            $res=FALSE;
        }
        
        if (!empty($cert[ $certdata."_Hash" ]))
        {
            $certdata=$cert[ $certdata."_Hash" ];

            if (isset($certdata[ "Certificate" ]))
            {                
                if ($certdata[ "Certificate" ]!=2)
                {
                    $this->Sql_Delete_Item_Query($cert[ "ID" ]);
                    $res=FALSE;
                }

            }
        }

        
        $this->Certificate_TimeLoad_Update($cert);
        
        return $res;
    }


    
    //*
    //* function Certificate_TimeLoad_Update, Parameter list: &$cert
    //*
    //* Reads certificate sub data.
    //*

    function Certificate_TimeLoad_Update(&$cert)
    {
        $timeloadkey=$this->Type2TimeloadKey($cert);

        $key=$this->Type2Key($cert);

        if (empty($cert[ $key."_Hash" ]))
        {
           $this->Certificate_Read_Data($cert,$key);
        }

        $timeload=$cert[ $key."_Hash" ][ $timeloadkey ];

        if
            (
                !empty($cert[ "ID" ])
                &&
                (
                    empty($cert[ "TimeLoad" ]) || $cert[ "TimeLoad" ]!=$timeload
                )
            )
        {
            $cert[ "TimeLoad" ]=$timeload;
            $this->Sql_Update_Item_Value_Set
            (
                $cert[ "ID" ],
                "TimeLoad",
                $timeload
            );
        }
        
    }


}

?>