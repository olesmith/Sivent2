<?php


class Inscriptions_Handle_Collaborations_Info extends Inscriptions_Handle_Collaborations_Read
{    
    //*
    //* function Inscription_Handle_Collaborations_Info, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Inscription Collaborations info.
    //*

    function Inscription_Handle_Collaborations_Info($edit,$friend,$inscription)
    {
        $event=$this->Event();
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->MyLanguage_GetMessage("Collaborations_Inscriptions_Message"),
                    array
                    (
                        "CLASS" => $this->CSS[ "Leading" ],
                    )
                ),
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyLanguage_GetMessage("Collaborations_Inscriptions_Period_Message").
                        ": ",
                            
                        $this->Date_Span_Interval
                        (
                            $event,
                            "Collaborations_StartDate",
                            "Collaborations_EndDate"
                        ).
                        ". ",
                            
                    ),
                    array
                    (
                        "CLASS" => $this->CSS[ "Text" ],
                    )
                ),
            );
    }
    
    
    //*
    //* function Inscription_Handle_Collaborations_Read, Parameter list: $edit,$friend,$inscription
    //*
    //* Determines whether we should show Collaborations.
    //*

    function Inscription_Handle_Collaborations_Read($item)
    {
        if (empty($this->Collaborators) && !empty($item[ "ID" ]))
        {
            $friendid=$item[ "ID" ];
            if (!empty($item[ "Friend" ])) {$friendid=$item[ "Friend" ]; }

            $this->Collaborators=
                $this->CollaboratorsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Friend" => $friendid,
                    )
                );
        }
    }
}

?>