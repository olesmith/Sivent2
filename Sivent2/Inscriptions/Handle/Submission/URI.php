<?php


class Inscriptions_Handle_Submissions_URI extends Inscriptions_Handle_Event
{
    //*
    //* function Inscription_Handle_Submissions_URI, Parameter list: $friend
    //*
    //* Creates Inscription submissions form URI.
    //*

    function Inscription_Handle_Submissions_URI($friend)
    {
        $args=
            array
            (
                "Unit"       => $this->Unit("ID"),
                "Event"      => $this->Event("ID"),
                "ModuleName" => "Submissions",
                "Action"     => "Add",
            );

        if (!empty($friend[ "ID" ]))
        {
            $args[ "Friend" ]=$friend[ "ID" ];
        }
        
        return $this->CGI_Hash2URI($args);
    }
    
}

?>