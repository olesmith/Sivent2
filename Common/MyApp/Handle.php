<?php

include_once("Handle/Start.php");
include_once("Handle/Help.php");
include_once("Handle/Logon.php");
include_once("Handle/Admin.php");
include_once("Handle/Backup.php");
include_once("Handle/Log.php");
include_once("Handle/Module.Setup.php");
include_once("Handle/Setup.php");
include_once("Handle/SU.php");
include_once("Handle/Export.php");
include_once("Handle/Import.php");
include_once("Handle/Process.php");

trait MyApp_Handle
{
    use
        MyApp_Handle_Start,
        MyApp_Handle_Logon,
        MyApp_Handle_Admin,
        MyApp_Handle_Backup,
        MyApp_Handle_Log,
        MyApp_Handle_ModuleSetup,
        MyApp_Handle_Help,
        MyApp_Handle_Setup,
        MyApp_Handle_SU,
        MyApp_Handle_Export,
        MyApp_Handle_Import,
        MyApp_Handle_Process;

    //*
    //* function MyApp_Handle_Action_Default, Parameter list:
    //*
    //* Detects action from CGI - or returns App default action.
    //*

    function MyApp_Handle_Action_Default()
    {
        $action=$this->CGI_GET("Action");
        if (empty($action)) { $action=$this->DefaultAction; }

        return $action;
    }
    
    //*
    //* function MyApp_Handle, Parameter list:$args=array()
    //*
    //* The main handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyApp_Handle($args=array())
    {
        $this->MyApp_Session_User_InitBySID();
        $action=$this->MyApp_Handle_Action_Default();

        $this->ModuleName=$this->CGI_GET("ModuleName");

        if (method_exists($this,"ApplicationCheckAccess"))
        {
            $this->ApplicationCheckAccess();
        }

        //Try to handle module $action if given
        $res=FALSE;
        if (!empty($this->ModuleName))
        {
            $res=$this->MyApp_Handle_TryModule($action);     
        }
        
        //If unhandled, try to access application $action
        if (!$res)
        {
            $this->MyApp_Handle_TryAction($action);
        }
    }


    //*
    //* function MyApp_TryAction, Parameter list:$args=array()
    //*
    //* The main handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyApp_Handle_TryAction($action)
    {
        //Test action access
        $res=$this->MyAction_Access_Has($action);
        if (!$res)
        {
            $action=$this->DefaultAction;
            $res=$this->MyAction_Access_Require($action);
        }
        
        $this->MyApp_Handle_Action($action);

        return $res;
    }


    //*
    //* function MyApp_Handle_TryModule, Parameter list: $action
    //*
    //* Tries to handle Application module, 
    //*

    function MyApp_Handle_TryModule($action)
    {
        //Load module
        $this->MyApp_Module_Load($this->ModuleName);
        
        //Test Module access
        $res=$this->MyApp_Module_Access_Has($this->ModuleName);

        if (!$res) { return FALSE; }
 
        //Handle module
        $this->ExecMTime=time();
        if ($this->Module)
        {
            $res=$this->Module->MyAction_Allowed($action);

            if (!$res) { return FALSE; }
        
            if (!$res)
            {
                if (!empty($this->Module->Actions[ $action ][ "AltAction" ]))
                {
                    $action=$this->Module->Actions[ $action ][ "AltAction" ];
                    $res=$this->Module->MyAction_Allowed($action);
                }
            }

            $this->Module->InitSearch();

            $this->Module->LoginType=$this->LoginType;

            $cookies=array();
            if (isset($this->Module->CGIArgs))
            {
                $cookies=array_keys($this->Module->CGIArgs);
            }

            $this->SetCookieVars($cookies);


            $this->Module->Handle=TRUE; //bug - SetCookieVars changes Handle??
            $this->Module->AddSearchVars2Cookies();
            $this->Module->SetCookieVars();
            $this->Module->MyMod_Handle();
        }

        $this->ExecMTime=time()-$this->ExecMTime;

        return TRUE;
    }

    //*
    //* function MyApp_Handle_Action, Parameter list:$action
    //*
    //* Handles Application specific action
    //*

    function MyApp_Handle_Action($action)
    {
        $handler=$this->Actions[ $action ][ "Handler" ];
        if (method_exists($this,$handler))
        {
            $this->$handler();
        }
        else { $this->DoDie("No handler $handler, action",$action); }
    }
}

?>