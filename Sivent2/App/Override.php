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
    //* function MyApp_Login_PostMessage , Parameter list: 
    //*
    //* Returns post message to Login form.
    //*

    function MyApp_Login_PostMessage()
    {
        return
            preg_replace
            (
               '/#Unit/',
               $this->Unit("ID"),
               $this->FrameIt
               (
                 $this->Div
                 (
                    $this->MyLanguage_GetMessage("Sivent_Old_Message"),
                    array
                    (
                       "CLASS" => 'postloginmsg',
                    )
                 ),
                 array
                 (
                    "BORDER" => 1,
                    "WIDTH" => '80%',
                    "ALIGN" => 'center',
                 )
                )
            ).
            "<BR>".
            parent::MyApp_Login_PostMessage();
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

    //*
    //* function MyApp_Interface_Phrase, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Phrase()
    {
        return
            $this->BR().
            $this->DIV
            (
               "This system is Free Software, download: ".
               $this->A("https://github.com/olesmith/SiVent2").
               "",
               array("ALIGN" => 'center')
            ).
            $this->BR().
            $this->Html_HR('75%').
            parent::MyApp_Interface_Tail_Phrase().
            "";
     }
}
