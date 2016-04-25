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

trait MyApp_Handle
{
    use
        MyApp_Handle_Start,MyApp_Handle_Logon,
        MyApp_Handle_Admin,MyApp_Handle_Backup,
        MyApp_Handle_Log,MyApp_Handle_ModuleSetup,
        MyApp_Handle_Help,
        MyApp_Handle_Setup,MyApp_Handle_SU;

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
        $action=$this->GetCGIVarValue("Action");
        if ($action=="") { $action=$this->DefaultAction; }

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
        $res=$this->MyAction_Access_Require($action);

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
        //Test Module access
         $res=$this->MyApp_Module_Access_Has($this->ModuleName);

        if (!$res) { return FALSE; }
        
        //Load module
        $this->MyApp_Module_Load($this->ModuleName);

        //Handle module
        $this->ExecMTime=time();
        if ($this->Module)
        {
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
            
            $res=$this->Module->MyAction_Allowed($action);

            //var_dump($res);
            if (!$res) { return FALSE; }
        
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