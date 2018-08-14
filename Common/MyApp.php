<?php


include_once("MyMod.php");
include_once("MyMessage.php");
include_once("ShowDir.php");


include_once("MyApp/CGI.php");
include_once("MyApp/Messages.php");
include_once("MyApp/Logging.php");
include_once("MyApp/Interface.php");
include_once("MyApp/Language.php");

include_once("MyApp/Mail.php");
include_once("MyApp/Login.php");
include_once("MyApp/Session.php");
include_once("MyApp/Actions.php");
include_once("MyApp/Profiles.php");
include_once("MyApp/Handle.php");
include_once("MyApp/Setup.php");
include_once("MyApp/Access.php");
include_once("MyApp/Module.php");
include_once("MyApp/CGIVars.php");
include_once("MyApp/Globals.php");
include_once("MyApp/Cookies.php");


trait MyApp
{
    use MyMod,
        MyMessage,
        ShowDir,
        MyApp_CGI,MyApp_Messages,MyApp_Logging,MyApp_Interface,MyApp_Language,
        MyApp_Mail,MyApp_Cookies,
        MyApp_Login,MyApp_Session,
        MyApp_Actions,MyApp_Access,MyApp_Module,
        MyApp_Profiles,MyApp_Handle,MyApp_Setup,
        MyApp_Globals,MyApp_CGIVars;

    var $Tables=array();
    var $TablesColumns=array();
    var $ItemHash=array();
    
    var $MyApp_URL="";
    var $MyApp_Latex_Filters=array();

    var $MyApp_Module="";
    var $MyApp_Handler="";
    
    var $MyApp_Defaults=array
    (
        "IsMain" => TRUE,
        "NoLeftMenu" => FALSE,

        "IsMain" => TRUE,
        "MayCreateSessionTable" => FALSE,
        "SavePath" => "?Action=Start",

        "Logging" => FALSE,

        "SessionTable" => "Sessions",
        "MayCreateSessionTable" => FALSE,
        "MaxLoginAttempts" => 10,

        "SetupPath" => "System",
        "SetupFile" => "Setup.php",

        "MessageFiles" => array(),
        "MessageDirs" => array("../Common","../Application","../MySql2/Messages/"),

        "SubModules" => array(),

        "ProfilesFile" => "Profiles.php",
        "LoginType" => "Public",
        "Profile" => "Public",

        "LeftMenuFile" => "LeftMenu.php",

        "DefaultAction" => "Start",
        "AppModules" => array(),


        "ActionPaths" => array("../Application/Actions"),
        "ActionFiles" => array("Actions.php"),
        "Actions" => array(),

        "DB" => FALSE,
        "DBHash" => array(),
        "DBType" => "MySql",


        "Authentication" => FALSE,
        "AuthHashFile" => "Auth.Data.php",
        "AuthHash" => array(),

        "Mail" => FALSE,
        "MailSetup" => ".Mail.php",
        "MailInfo" => array(),

        //CGI Vars that points to global hashes
        "CGIVars" => array(),
    );

    var $Unit2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","CCEmail","BCCEmail",
    );
    
    var $Event2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","CCEmail","BCCEmail",
    );

    ##From Mysql2_TInterface
    var $CSSFile="../MySql2/wooid.css";
    var $HtmlSetupHash,$CompanyHash; 
    var $Modules=array();
    var $PreTextMethod="";
    var $InterfacePeriods=array();
    var $NoTail=1;
    var $HeadersSend=0;
    var $DocHeadSend=0;
    var $HeadSend=0;
    var $HTML=FALSE;
    var $TInterfaceDataMessages="TInterface.php";


    var $MyApp_Interface_Head_DocType=
        '<!DOCTYPE html>';

    var $MyApp_Interface_Head_Scripts_OnLine=
        array
        (
            #'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
            'CSS/jquery.min.js',
            'CSS/App.js',
        );

    var $MyApp_Interface_Head_Scripts_InLine=
        array
        (
        );
    
    var $MyApp_Interface_Head_Links=
        array(
            array
            (
                "REL" => 'stylesheet',
                "HREF" => 'https://use.fontawesome.com/releases/v5.0.13/css/all.css',
                "INTEGRITY" => 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
                "CROSSORIGIN" => 'anonymous',
            ),
            array
            (
                "REL" => 'stylesheet',
                "HREF" => 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css',
            ),
        );
    
    var $MyApp_Interface_Head_CSS_OnLine=
        array
        (
           "CSS/HTMLs.css","CSS/Envs.css",
           "CSS/App.css",
           "CSS/Application.css",
           "CSS/Left.Menu.css","CSS/Hor.Menu.css",
           "CSS/Odd.Even.css","CSS/Modules.css",
        );

    var $MyApp_Interface_Head_CSS_InLine=
        array
        (
        );
    

    //*
    //* function MyApp_Load, Parameter list: $args=array()
    //*
    //* Load Application.
    //*

    function MyApp_Load($args)
    {
        $this->MyApp_Init($args);
    }

    //*
    //* function MyApp_Init, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyApp_Init($args)
    {
        //We are our own Application object
        $this->ApplicationObj=$this;
        $this->IsMain=TRUE;

        $this->ModuleName="App";

        $this->Hash2Object($args);

        $this->MyApp_AppSetup($args);
        $this->DB_Init();

        $this->MyApp_Language_Init($args);
        $this->MyApp_Messages_Init($args);
 
        //???? $this->GlobalSetupDefs();

        $this->MyApp_Profiles_Read();

        $this->MyApp_CGIVars_Init();
        
        //Must do after MyApp_CGIVars_Ini, may change DB.
        $this->MyApp_Session_Table_Init();
        $this->MyApp_Login_Init();

        $this->MyApp_Interface_Init();
        $this->MyApp_Mail_Init();

        $this->MyActions_Init();

        $this->MyApp_SetURL();

        $this->MyApp_Logging_Init();
        $this->MyApp_LoadAppModules();
   }


    //*
    //* function MyApp_FilterPath, Parameter list: 
    //*
    //* Filters out #System and #ModuleName from path.
    //*

    function MyApp_FilterPath($path)
    {
        return
            preg_replace
            (
               '/#System/',
               $this->SetupPath,
               preg_replace
               (
                  '/#Module(Name)?/',
                  $this->ModuleName,
                  $path
               )
            );
     }

    //*
    //* function MyApp_SetupFile, Parameter list: 
    //*
    //* Returns full name of SetupFile.
    //*

    function MyApp_SetupFile()
    {
        return
            $this->MyApp_Setup_Path().
              "/".
            $this->SetupFile;
    }

    //*
    //* function MyApp_AppSetup, Parameter list: $args=array()
    //*
    //* Runs Application setup.
    //*

    function MyApp_AppSetup($args)
    {
        $this->MyHash_Args2Object($this->MyApp_Defaults);
        $this->MyHash_Args2Object($args);

        $this->MyHash_Args2Object
        (
           $this->ReadPHPArray
           (
              $this->MyApp_SetupFile(),
              $args
           )
        );

        $this->MyApp_Setup_Read();
    }



    //*
    //* function MyApp_LoadAppModules, Parameter list:
    //*
    //* Loads app modules.
    //*

    function MyApp_LoadAppModules()
    {
        foreach ($this->AppLoadModules as $submodule)
        {
            $this->MyMod_SubModule_Load($submodule,FALSE,TRUE,FALSE);
        }
    }

    //*
    //* function MyApp_Run, Parameter list: $args
    //*
    //* Runs application, that is calls Handle. Load must have been done before.
    //*

    function MyApp_Run($args)
    {
        $this->MyApp_Handle($args);
    }

    //*
    //* function MyApp_Application_Name, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Name()
    {
        return $this->HtmlSetupHash[ "ApplicationName"  ];
    }

    //*
    //* function MyApp_Application_Version, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Version()
    {
        return $this->HtmlSetupHash[ "ApplicationVersion"  ];
    }

    //*
    //* function MyApp_Application_Title, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Title()
    {
        return
            $this->MyApp_Application_Name().
            " ".
            $this->MyApp_Application_Version().
            "";
    }

    //*
    //* function MyApp_Run, Parameter list: $args
    //*
    //* Sets application URL.
    //*

    function MyApp_SetURL()
    {
        $this->MyApp_URL="http";
        if (isset($_SERVER[ "HTTPS" ]))
        {
            $this->MyApp_URL.="s";
        }

        $this->MyApp_URL.=
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "/".
            $this->CGI_Script_Name();
        
        $this->MyApp_URL=preg_replace('/\/?index.php/',"",$this->URL);

        return $this->MyApp_URL;
    }

    //*
    //* function MyApp_GoHome, Parameter list: $args
    //*
    //* Resets current working directory to app path.
    //*

    function MyApp_GoHome()
    {
        chdir(dirname($_SERVER[ "SCRIPT_FILENAME" ]));
    }
    
    //*
    //* function MyApp_Common_URIs, Parameter list: $args
    //*
    //* The URI's to add for all links.
    //*

    function MyApp_Common_URIs()
    {
        return array();
    }
}

?>