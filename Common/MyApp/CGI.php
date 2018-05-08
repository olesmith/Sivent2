<?php


trait MyApp_CGI
{
    //*
    //* function MyApp_CGI_Reload_Try, Parameter list: $args
    //*
    //* Tries to send Location header - if not $this->HeadersSend,
    //* in which case it is too late.
    //*

    function MyApp_CGI_Reload_Try($args)
    {
        if (!$this->HeadersSend)
        {
            //Now added, reload as edit, preventing multiple adds
            header("Location: ?".$this->CGI_Hash2Query($args));

            exit();
        }
    }

}

?>