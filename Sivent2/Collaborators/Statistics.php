<?php

class Collaborators_Statistics extends Collaborators_Certificate
{
    //*
    //* function Collaborators_Statistics_Rows, Parameter list: $event=array()
    //*
    //* Creates Statistics info table rows.
    //*

    function Collaborators_Statistics_Rows($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        if (!$this->EventsObj()->Event_Collaborations_Has($event)) { return array(); }
        
        return
            array
            (
                array
                (
                    $this->H(4,$this->MyMod_ItemsName())
                ),
                $this->B
                (
                    $this->MyLanguage_GetMessage("Collaborators_Statistics_TitleRow")
                ),
                array_merge
                (
                    array
                    (
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
                    ),
                    $this->CertificatesObj()->Certificates_Statistics_Row($this->Certificate_Type,$event),
                    array("")
                )
            );
    }
}

?>