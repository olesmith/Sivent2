<?php

class Certificates_Statistics extends Certificates_Table
{
    //*
    //* function Certificates_Statistics_Row, Parameter list: $event=array()
    //*
    //* Creates Statistics info table row.
    //*

    function Certificates_Statistics_Row($type,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        return
            array
            (
                $this->Sql_Select_NHashes
                (
                    array
                    (
                        "Unit" => $this->Unit("ID"),
                        "Event" => $event[ "ID" ],
                        "Type" => $type,
                    )
                ),
                $this->Sql_Select_Calc
                (
                    array
                    (
                        "Unit" => $this->Unit("ID"),
                        "Event" => $event[ "ID" ],
                        "Type" => $type,
                    ),
                    "TimeLoad"
                ),
            );
    }
}

?>