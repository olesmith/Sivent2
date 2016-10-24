<?php


class Caravaneers_Table_CGI extends Caravaneers_Table_Read
{
    //*
    //* function Caravaneer_Table_CGI2Name, Parameter list: $n
    //*
    //* Returns cgi value.
    //*

    function Caravaneer_Table_CGI2Name($n)
    {
        $value="No_".$n."_Name";
        $value=$this->CGI_POST($value);
        
        return
            preg_replace
            (
               '/\s+/',
               " ",
               preg_replace
               (
                  '/^\s+/',
                  "",
                  preg_replace('/s+$/',"",$value)
               )
            );
    }

    //*
    //* function Caravaneer_Table_CGI2Email, Parameter list: $n
    //*
    //* Returns cgi value.
    //*

    function Caravaneer_Table_CGI2Email($n)
    {
        $value="No_".$n."_Email";
        $value=$this->CGI_POST($value);
        
        return preg_replace('/\s+/',"",$value);
    }
}

?>