<?php

class App_Override extends App_Handle
{
    //*
    //* function MyApp_Interface_SCRIPTs, Parameter list:$args=array()
    //*
    //* Overrides the main handler.
    //*

    function MyApp_Interface_SCRIPTs($args=array())
    {
        $scripts=parent::MyApp_Interface_SCRIPTs($args);
        $event=$this->Event();
        if (!empty($event) && $event[ "Payments_Type" ]==2)
        {
            array_push
            (
                $scripts,
                $this->HtmlTags
                (
                    "SCRIPT",
                    "",
                    array
                    (
                        "TYPE" => 'text/javascript',
                        "SRC"  => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',
                    )
                )
            );
        }

        return $scripts;
    }
    
    //*
    //* function MyApp_, Parameter list:$args=array()
    //*
    //* Overrides the main handler.
    //*

    function MyApp_Interface_Head($args=array())
    {
        parent::MyApp_Interface_Head($args);

        $banner=$this->Event("HtmlIcon1");
        if (!empty($banner))
        {
            $args=
                array
                (
                    "ModuleName" => "Events",
                    "Action" => "Download",
                    "Unit" => $this->Unit("ID"),
                    "Event" => $this->Event("ID"),
                    "Data" => "HtmlIcon1",
                );
            
            echo
                $this->Htmls_Text
                (
                    $this->Htmls_DIV
                    (
                        $this->Html_IMG
                        (
                            "?".$this->CGI_Hash2URI($args),
                            $this->Event("Name")." banner",
                            array
                            (
                                "BORDER" => 0,
                                "HEIGHT" => $this->Event("HtmlIcon1_Height"),
                                "WIDTH" => $this->Event("HtmlIcon1_Width"),
                                "TITLE" => $this->Event("Name")." banner",
                                "ALT" => 'Logo',
                            )
                        ),
                        #DIV options
                        array
                        (
                            "CLASS" => 'center',
                        )
                    )
                );
        }
    }
    
    //*
    //* function MyApp_Handle, Parameter list:$args=array()
    //*
    //* Overrides the main handler.
    //*

    function MyApp_Handle($args=array())
    {
        $this->UnitsObj()->Sql_Table_Structure_Update();
        
        $online=$this->Unit("Online");
        if
            (
                $online==2
                &&
                $this->Profile()!="Admin"
                &&
                $this->CGI_GET("Action")!="Download"
            )
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
    //* sub MyApp_Interface_Status, Parameter list: 
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_Messages_Status()
    {
        $html=parent::MyApp_Interface_Messages_Status();

        return $html;
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

    function MyApp_Login_Form_Post_Messages()
    {
        $message=
            preg_replace
            (
               '/#Unit/',
               $this->Unit("ID"),
               $this->MyLanguage_GetMessage("Sivent_Inscribe_Message").
               $this->MyLanguage_GetMessage("Sivent_Old_Message")
            );
        
        return array
        (
            parent::MyApp_Login_Form_Post_Messages(),
            $this->BR(),
            $this->Htmls_Tag
            (
                "DIV",
                $this->Htmls_DIV
                (
                    $message,
                    array
                    (
                        "CLASS" => 'postloginmsg message-body',
                    )
                ),
                array
                (
                    "CLASS" => 'message is-primary',
                )
            )
        );
    }
    

    //*
    //* function MyApp_Interface_Phrase, Parameter list: 
    //*
    //* Prints Tail phrase.
    //*

    function MyApp_Interface_Phrase()
    {
        return
            array
            (
                $this->DIV
                (
                    "This system is Free Software, download: ".
                    $this->A("https://github.com/olesmith/SiVent2").
                    "",
                    array("ALIGN" => 'center')
                ),
                $this->BR(),
                $this->Html_HR('75%'),
                parent::MyApp_Interface_Phrase(),
            );
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
