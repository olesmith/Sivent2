<?php

class InscriptionsStatistics extends InscriptionsUpdate
{
    //*
    //* function Inscriptions_Statistics_Rows, Parameter list: $event=array()
    //*
    //* Creates Statistics info table rows.
    //*

    function Inscriptions_Statistics_Rows($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        return
            array
            (
                array
                (
                    $this->H(4,$this->MyMod_ItemsName())
                ),
                $this->B
                (
                    $this->MyLanguage_GetMessage("Inscriptions_Statistics_TitleRow")
                ),
                array_merge
                (
                    array
                    (
                        $this->FriendsObj()->Sql_Select_NHashes
                        (
                            array
                            (
                                "Unit" => $this->Unit("ID"),
                            )
                        ),
                        $this->Sql_Select_NHashes
                        (
                            array
                            (
                                "Unit" => $this->Unit("ID"),
                                "Event" => $event[ "ID" ],
                            )
                        ),
                        $this->Sql_Select_NHashes
                        (
                            array
                            (
                                "Unit" => $this->Unit("ID"),
                                "Event" => $event[ "ID" ],
                                "Homologated" => 2,
                            )
                        ),
                        $this->Sql_Select_NHashes
                        (
                            array
                            (
                                "Unit" => $this->Unit("ID"),
                                "Event" => $event[ "ID" ],
                                "Selected" => 2,
                            )
                        ),
                    ),
                    $this->CertificatesObj()->Certificates_Statistics_Row($this->Certificate_Type,$event),
                    array("")
                ),
            );

    }
}

?>