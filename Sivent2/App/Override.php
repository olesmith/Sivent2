<?php

class App_Override extends App_Handle
{
    //*
    //* function MyApp_Handle_Logon, Parameter list: 
    //*
    //* Handle Login Form, add events listing.
    //*

    function MyApp_Handle_Logon()
    {
        parent::MyApp_Handle_Logon();
        $this->EventsObj()->ShowEvents();
    }

    //*
    //* function MyApp_Interface_LeftMenu, Parameter list:
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_LeftMenu()
    {
        $this->SponsorsObj()->Sql_Table_Structure_Update();
        
        return
            parent::MyApp_Interface_LeftMenu().
            $this->SponsorsObj()->ShowSponsors(1).
            "";
    }

    //*
    //* function MyApp_Interface_Tail_Center(), Parameter list:
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_Tail_Center()
    {
       return
            $this->SponsorsObj()->ShowSponsors(2).
            parent::MyApp_Interface_Tail_Center().
            "";
    }
    
    //*
    //* sub MyApp_Interface_Status, Parameter list: 
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_Messages_Status()
    {
        return
            parent::MyApp_Interface_Messages_Status().
            $this->SponsorsObj()->ShowSponsors(3).
            "";
    }
    
    //*
    //* function MyApp_Init, Parameter list: 
    //*
    //* Overrided function. Calls parent, then checks for event access.
    //*

    function MyApp_Login_SetData($logindata)
    {
        parent::MyApp_Login_SetData($logindata);
        $this->CheckEventAccess();
    }

    //*
    //* function MyApp_Interface_Head, Parameter list: 
    //*
    //* Overrides Application::MyApp_Interface_Head.
    //*

    function MyApp_Interface_Head()
    {
        parent::MyApp_Interface_Head();
        
        echo
            $this->AppInfo();        
    }

}
