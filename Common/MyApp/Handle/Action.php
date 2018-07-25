<?php

trait MyApp_Handle_Action
{
    //*
    //* function MyApp_Handle_Action_CGI, Parameter list:
    //*
    //* Detects action from CGI - or returns App default action.
    //*

    function MyApp_Handle_Action_CGI()
    {
        $action=$this->CGI_GET("Action");
        if (empty($action)) { $action=$this->DefaultAction; }

        return $action;
    }
    

    //*
    //* function MyAp_Handle_Action_Allowed, Parameter list: 
    //*
    //* Attempts to find suitable and allowed app action action.
    //*

    function MyApp_Handle_Action_Allowed($action)
    {        
        $res=$this->MyAction_Access_Has($action);
        if (!$res)
        {
            $action=$this->DefaultAction;
            $res=$this->MyAction_Access_Require($action);
        }

        if ($res) { return $action; }
        
        return False;
    }
    
    //*
    //* function MyApp_Action_Try, Parameter list:$args=array()
    //*
    //* The main handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyApp_Handle_Action_Try()
    {
        $action=$this->MyApp_Handle_Action_CGI();
        $action=$this->MyApp_Handle_Action_Allowed($action);
        if ($action)
        {
            $res=$this->MyApp_Handle_Action_Exec($action);
        }

        return $res;
    }



    //*
    //* function MyApp_Handle_Action, Parameter list:$action
    //*
    //* Executes Application specific $action.
    //*

    function MyApp_Handle_Action_Exec($action)
    {
        $handler=$this->Actions[ $action ][ "Handler" ];
        if (method_exists($this,$handler))
        {
            $this->MyApp_Handler=$handler;
            $res=$this->$handler();   

            return $res;
        }
        else { $this->DoDie("No handler '".$handler."', action",$action); }
    }
}

?>