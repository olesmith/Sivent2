<?php

include_once("Handle/Module.php");
include_once("Handle/Action.php");
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
        MyApp_Handle_Module,
        MyApp_Handle_Action,
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
 
        $this->ModuleName=$this->CGI_GET("ModuleName");

        if (method_exists($this,"ApplicationCheckAccess"))
        {
            $this->ApplicationCheckAccess();
        }

        //First, try to handle module $action if given
        $action=$this->MyApp_Handle_Module_Action_Allowed();
        
        $res=False;
        if ($action)
        {
            $res=$this->MyApp_Handle_Module_Try($action);     
        }
        else
        {
            //If unhandled, try to access application $action
            $this->MyApp_Handle_Action_Try();
        }
    }
}

?>