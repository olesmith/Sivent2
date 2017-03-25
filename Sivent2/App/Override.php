<?php

class App_Override extends App_Handle
{
    //*
    //* function MyApp_Handle, Parameter list:$args=array()
    //*
    //* Overrides the main handler.
    //*

    function MyApp_Handle($args=array())
    {
        $this->UnitsObj()->Sql_Table_Structure_Update();
        
        $online=$this->Unit("Online");
        if ($online==2 && $this->Profile()!="Admin")
        {
            $this->MyApp_Interface_Head();

            echo
                $this->H(1,$this->Language_Message("System_Closed")).
                $this->H(2,$this->Unit("Online_Message")).
                "";
            exit();
        }
        
        parent::MyApp_Handle($args);
    }

    
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
                     $this->Center
                     (
                         $this->MyLanguage_GetMessage("Sivent_Inscribe_Message").
                         $this->MyLanguage_GetMessage("Sivent_Old_Message")
                     ),
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
    
     //*
    //* function  HtmlEventsWhere, Parameter list: 
    //*
    //* Overrides EventApp::HtmlEventsWhere. Leaves out non-visible events.
    //*

    function HtmlEventsWhere()
    {
        return
            array
            (
               "Unit" => $this->Unit("ID"),
               "Visible" => 1,
            );
    }
    
    //*
    //* sub PostHandle, Parameter list: 
    //*
    //* Runs after modules has finished: prints event post ifno.
    //*
    //*

    function MyApp_Interface_Post_Row()
    {
        $event=$this->CGI_GETint("Event");
        if (empty($event)) { return ""; }
        $event=$this->Event();

        
        chdir(dirname($_SERVER[ "SCRIPT_FILENAME" ]));

        return
            
            //$html.
            $this->HtmlTags
            (
               "TR",
               $this->HtmlTags("TD").
               $this->HtmlTags
               (
                  "TD",
                  $this->Html_Table("",$this->ApplicationObj()->AppEventInfoPostTable(),array("WIDTH" => '100%'))
               ).
               $this->HtmlTags("TD")
             ).
            "";
    }

    //*
    //* function MyApp_Interface_LeftMenu_Read, Parameter list: 
    //*
    //* Reads the menus pertaining to profile $this->Profile.
    //* If $this->Profile is empty, return Public menus.
    //*

    function MyApp_Interface_LeftMenu_Read()
    {
        $menues=$this->MyApp_Setup_Files2Hash("System","LeftMenu.php");
        $unit=$this->Unit("ID");
        if (empty($unit))
        {
            $keys=array_keys($menues);
            $keys=preg_grep('/(Language|Units)$/',$keys,PREG_GREP_INVERT);

            foreach ($keys as $key) { unset($menues[ $key ]); }
        }

        return $menues;
    }
    
    //*
    //* function AppUnitInfoTable, Parameter list: 
    //*
    //* Creates application info table: Unit and Event, if defined.
    //*

    function AppUnitInfoTable()
    {
        $unit=$this->Unit();
        $table=array();

        return $table;
    }
}
