<?php

include_once("../MySql2/Table.php");
include_once("LeftMenu.php");
include_once("SendMail.php");
include_once("Login.php");
include_once("Session.php");
include_once("SubModules.php");
include_once("ModPerms.php");
include_once("Backup.php");
include_once("Modules.php");
include_once("Setup.php");
include_once("Messages.php");
include_once("Help.php");
include_once("Perms.php");
include_once("Profiles.php");
include_once("../Application/Users.php");
include_once("../Application/Logs.php");
include_once("Handlers.php");
include_once("Language.php");
include_once("CGIVars.php");


include_once("../Common/MyApp.php");


class Application extends ApplicationCGIVars
{
    use MyApp;

    var $ItemName="";
    var $ItemsName="";

    var $CommonData=array();
    var $SplitVars=array();
    //var $SearchVars=array();
    var $HtmlError=FALSE;
    var $LoginType="";
    var $Handle=TRUE;
    var $BaseDB="";
    //var $DBs=array();
    var $PostMessages=array();

    /* var $SetupPath="System"; */
    var $ConfigPaths=array("../Application",".");
    var $Layout=array
    (
       "Font"      => "",
       "White"     => "#FFFFFF",
       "Black"     => "#000000",
       "Light"     => "#dcf7fa",
       "LightDark" => "#90a1a3",
       "DarkLight" => "#90a1a3",
       "Dark"      => "#464e4f",

       "Light"     => "#33ccff",
       "Dark"      => "#3333ff",
       "DarkLight" => "#3333ff",
       "LightDark" => "#3399ff",

       "Blue"       => "#33ccff",
       "DarkBlue"   => "#3366ff",
       "LightBlue"  => "#CEECF5",

       "LightGrey" => "#F2F2F2",
       "Grey"      => "#CCCCCC",
       "DarkGrey"  => "#333333",//848484",

       "Yellow"     => "#F5BCA9",
       "Orange"     => "#FAEBD7",
       "Red"     => "#FF3333",
    );

    var $LatexClearPage="\n\\clearpage\n\n";
    var $LatexClearDoublePage="\n\\cleardoublepage\n\n";
    //var $LatexGreyRows="\\rowcolors{2}{gray!35}{}\n";
    //var $LatexWhiteRows="\\rowcolors{2}{gray!0}{}\n";
    var $LatexGreyRows="";
    var $LatexWhiteRows="";

    var $LatexFilters=array
    (
       "Unit" => array
       (
          "PreKey" => "",
          "Object" => "UnitsObject",
       ),
    );

    var $Application_No_Tail=False;
    

    function Application($args=array())
    {
        $this->MyApp_Load($args);
    }

    //*
    //* function __destruct, Parameter list: 
    //*
    //* Application destructor.
    //*

    function __destruct()
    {
        if ($this->Application_No_Tail) { return; }
        
        if (!empty($this->Module) && method_exists($this->Module,"SendMails"))
        {
            $this->Module->SendMails();
        }

        if ($this->DocHeadSend==1)
        {
            $this->MyApp_Interface_Tail();
        }
    }

    //*
    //* function AddPostMessage, Parameter list: $msgs
    //*
    //* Adds messages to Post Message stack.
    //*

    function AddPostMessage($msgs)
    {
        if (!is_array($msgs)) { $msgs=array($msgs); }
        
        $this->PostMessages=array_merge($this->PostMessages,$msgs);
    }

    
    //*
    //* function SetLatexMode, Parameter list: 
    //*
    //* Changes some character constants to use with LatexMode=1.
    //*

    function SetLatexMode()
    {
        $this->Sigma   = '$'."\\Sigma".  '$';
        $this->Mu      = '$'."\\mu".     '$';
        $this->Percent = "\\%";
        $this->Dagger = '$'."\\dagger".  '$';

        $this->LatexMode=TRUE;
    }

    //*
    //* function UnSetLatexMode, Parameter list: 
    //*
    //* Changes some character constants to use with LatexMode=1.
    //*

    function UnSetLatexMode()
    {
        $this->Sigma   = '&Sigma;';
        $this->Mu      = '&mu;';
        $this->Percent = "%";
        $this->Dagger = "&dagger;";

        $this->LatexMode=FALSE;
    }

    //*
    //* function GetListOfProfiles, Parameter list:
    //*
    //* 
    //*

    function GetListOfProfiles()
    {
        $profiles=array
        (
           "Public" =>1,
           "Person" =>1,
        );
        
        foreach ($this->ValidProfiles as $profile)
        {
            $profiles[ $profile ]=1;
        }
        
        $profiles[ "Admin" ]=1;

        return array_keys($profiles);
    }

    //*
    //* function Profile2Application, Parameter list:
    //*
    //* Transfer current profile to $this (does allowing of actions).
    //*

    function Profile2Application()
    {
        $this->GlobalActions();

        if ($this->LoginType=="") { $this->LoginType="Public"; }
        if ($this->Profile=="") { $this->Profile="Public"; }

        $profiles=$this->Profiles[ $this->Profile ][ "Application" ];
        foreach ($profiles[ "Actions" ] as $name => $val)
        {
            if (is_array($val))
            {
                $this->Actions[ $name ][ $this->LoginType ]=$val[ "Access" ];
                foreach ($val[ "Attributes" ] as $key => $value)
                {
                    $this->Actions[ $name ][ $key ]=$value;
                }
            }
            else
            {
                $this->Actions[ $name ][ $this->LoginType ]=$val;
            }
        }
    }

    //*
    //* function PostInitSubModule, Parameter list: $obj
    //*
    //* Initializes profiles, actions and ItemData for $obj.
    //*

    function PostInitSubModule($obj)
    {
        $obj->MyMod_Profiles_Init($obj->ModuleName);
        $obj->InitActions();
        $obj->PostInit();
    }


    //*
    //* function SetSubClassSqlTable, Parameter list: $item
    //*
    //* 
    //*

    function SubClassSqlTableName($item,$class,$name)
    {
        $obj=$class."Object";

        return preg_replace
        (
           '/_'.$name.'/',
           "_".$class,
           $this->SqlTableName()
        );
     }


    //*
    //* function LatexGreyRows, Parameter list: 
    //*
    //* Acessor for $this->LatexGreyRows.
    //*

    function LatexGreyRows()
    {
        $greyrow="";
        if ($this->GetPOST("NoGreys")!=1)
        {
            $greyrow=$this->LatexGreyRows;
        }

        return $greyrow;
    }

    //*
    //* function LatexWhiteRows, Parameter list: 
    //*
    //* Acessor for $this->LatexWhiteRows.
    //*

    function LatexWhiteRows()
    {
        $greyrow="";
        if ($this->GetPOST("NoGreys")!=1)
        {
            $greyrow=$this->LatexWhiteRows;
        }

        return $greyrow;
    }

    //*
    //* Transfers data read into $this->Unit, into $this->ApplicationObj->CompanyHash.
    //*

    function Unit2CompanyHash()
    {
        if (!empty($this->Unit))
        { 
            foreach (array_keys($this->Unit) as $key)
            {
                $this->CompanyHash[ $key ]=$this->Unit[ $key ];
            }

            $this->CompanyHash[ "Institution" ]="";
            if (!empty($this->Unit[ "Institution" ]))
            {
                $this->CompanyHash[ "Institution" ]=$this->Unit[ "Institution" ];
            }

            if (!empty($this->Unit[ "Title" ]))
            {
                $this->CompanyHash[ "Department" ]=$this->Unit[ "Title" ];
            }

            $this->CompanyHash[ "Url" ]="";
            if (!empty($this->Unit[ "WWW" ]))
            {
                $this->CompanyHash[ "Url" ]=$this->Unit[ "WWW" ];
            }
            elseif (!empty($this->Unit[ "Url" ]))
            {
                $this->CompanyHash[ "Url" ]=$this->Unit[ "Url" ];
            }

            $this->CompanyHash[ "City" ]="";
             if (!empty($this->Unit[ "City" ]))
            {
                $this->CompanyHash[ "City" ]=$this->Unit[ "City" ];
            }

            $this->CompanyHash[ "State" ]="";
            if (!empty($this->Unit[ "State" ]))
            {
                $this->CompanyHash[ "State" ]=$this->Unit[ "State" ];
            }

            $this->CompanyHash[ "ZIP" ]="";
            if (!empty($this->Unit[ "" ]))
            {
                $this->CompanyHash[ "ZIP" ]="CEP: ".$$this->Unit[ "ZIP" ];
            }
        }
    }
}

?>