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
        "MaxLoginAttempts" => 5,

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
            $this->ServerName().
            $this->ScriptPath().
            "/".
            $this->ScriptName();
        
        $this->MyApp_URL=preg_replace('/\/?index.php/',"",$this->URL);

        return $this->MyApp_URL;
    }

}

?>