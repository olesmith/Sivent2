<?php

trait MyApp_Handle_Admin
{
    //*
    //* function MyApp_Handle_Admin, Parameter list:
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_Admin()
    {
        if ($this->MyApp_Profile_MayBecomeAdmin())
        {
            $this->SetCookie("Admin",1,time()+$this->CookieTTL);
            $this->MyApp_Handle_Start();
        }
    }

    //*
    //* function MyApp_Handle_NoAdmin, Parameter list:
    //*
    //* The NoAdmin Handler.
    //*

    function MyApp_Handle_NoAdmin()
    {
        $this->MyApp_Handle_Start();
        $this->SetCookie("Admin",0,time()-$this->CookieTTL);
    }

}

?>