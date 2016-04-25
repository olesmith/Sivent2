<?php


trait MyApp_Handle_Logon
{
    //*
    //* function MyApp_Handle_Logon, Parameter list:
    //*
    //* The Start Handler. Should display some basic info.
    //*

    function MyApp_Handle_Logon()
    {
        if ($this->LoginType=="Public")
        {
            if ($this->CGI_POSTint("Logon")==1)
            {
                $this->MyApp_Session_Init();


                if ($this->Authenticated)
                {
                    $args=$this->CGI_URI2Hash();
                    $args[ "Action" ]="Start";

                    $this->CGI_Redirect($args);
                    $this->DoExit();
                }
            }

            $this->MyApp_Login_Form();
            $this->DoExit();
        }
        else
        {
            $this->MyApp_Handle_Start();
        }
    }

    //*
    //* function MyApp_Handle_Logoff, Parameter list: 
    //*
    //* Carries out logoff, ie: Calls DoLogoff and exits.
    //*

    function MyApp_Handle_Logoff()
    {
        $this->DoLogoff();
        $this->DoExit();
    }
}

?>