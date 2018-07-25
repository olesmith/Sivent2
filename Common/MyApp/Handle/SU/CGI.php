<?php

trait MyApp_Handle_SU_CGI
{    
    //*
    //* function MyApp_Handle_SU_CGI_Value, Parameter list:
    //*
    //* Find profiles, that we are NOT allowd to shift to.
    //*

    function MyApp_Handle_SU_CGI_Value()
    {
        foreach ($this->MyApp_Handle_SU_Profiles_Allowed() as $profile)
        {
            $cgi=$this->CGI_POSTOrGET($profile);
            if (!empty($cgi))
            {
                return $cgi;
            }
        }

        return "";
    }
}

?>