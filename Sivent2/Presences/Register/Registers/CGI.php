<?php


class Presences_Register_Registers_CGI extends Presences_Register_Search
{
    //*
    //* function Presences_Schedule_Register_CGI_Key, Parameter list: $schedule,$friend
    //*
    //* Name of $friend/$schedule CGI key.
    //*

    function Presences_Schedule_Register_CGI_Key($schedule,$friend)
    {
        return
            $friend[ "ID" ]."_".$schedule[ "ID" ]."_Present";
    }
    
    //* function Presences_Schedule_Register_CGI_Value, Parameter list: $schedule,$friend
    //*
    //* Value of $friend/$schedule CGI key.
    //*

    function Presences_Schedule_Register_CGI_Value($schedule,$friend)
    {
        return
            $this->CGI_POSTint($this->Presences_Schedule_Register_CGI_Key($schedule,$friend));
    }
}

?>