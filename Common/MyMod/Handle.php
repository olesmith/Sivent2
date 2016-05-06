<?php

include_once("Handle/Help.php");
include_once("Handle/Show.php");
include_once("Handle/Edit.php");

trait MyMod_Handle
{
    use MyMod_Handle_Help,
        MyMod_Handle_Show,
        MyMod_Handle_Edit;
    
    //*
    //* function MyMod_Handle, Parameter list:$args=array()
    //*
    //* The main handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyMod_Handle($args=array())
    {
        $this->Actions();

        $action=$this->CGI_Get("Action");
        if ($action=="") { $action=$this->DefaultAction; }
        $this->ModuleName=$this->CGI_Get("ModuleName");

        //Load actions if necessary
        $this->Actions();

        if (!empty($this->Actions[ $action ]))
        {
            if ($this->MyAction_Allowed($action))
            {
                $this->ApplicationObj()->LogMessage($action,"Handle");

                $this->Handle();
            }
            else
            {
                $this->DoDie("Action not allowed",$this->ModuleName,$action,$this->Actions[ $action ]);
            }
        }
        else
        {
            $this->DoDie("Action inexistent",$this->ModuleName,$action,$this->Actions);
        }
    }


    //*
    //* function Handle, Parameter list:$args=array()
    //*
    //* ModuleHandler
    //*

    function Handle()
    {
        if ($this->NoHandle!=0) { return; }

        $this->ItemData();
        $this->Actions();
        $this->ItemDataGroups();

        //Do we need to read an item?
        $id=0;
        if ($this->IDGETVar)
        {
            $id=$this->GetGETOrPOST($this->IDGETVar);
        }

        if (empty($id))
        {
            $id=$this->GetGETOrPOST("ID");
        }

        if (!empty($id))
        {
            if (count($this->ItemHash)==0)
            {
                $this->ReadItem($id);
            }

            if (empty($this->ItemHash))
            {
                $this->DoDie
                (
                   "Table::Handle ".$this->ModuleName.
                   ": Not found or not allowed... (".$id.") - bye-bye.."
                );
            }
        }

        
        $item=$this->ItemHash;

        //Do we have a suitable action?
        $action=$this->MyActions_Detect();
        if (empty($action))
        {
            $this->DoDie
            (
               "Table::Handle ".
                $this->ModuleName.
                ": Undefined action '$action' - redirect\n"
             );

            $this->Redirect();
            $this->DoExit();
        }

        $res=$this->MyAction_Allowed($action);
        if (!$res)
        {
            $this->Redirect();
            $this->DoExit();
        }

        $handler=$this->Actions[ $action ][ "Handler" ];
        if ($handler=="")
        {
            $handler="Handle".$action;
        }

        if (!empty($this->Actions[ $action ][ "Singular" ])) { $this->Singular=TRUE; }

        if (!method_exists($this,$handler))
        {
            echo 
                $this->ModuleName.
                ": Undefined handler, action $action (".
                $this->Actions[ $action ][ "Handler" ].
                "), $handler\n";

            $this->Redirect();
            $this->DoExit();
        }

        $this->SavePrintDocHeads();

        $this->ItemHash=$item;
        if (method_exists($this,"PreHandle"))
        {
            $this->PreHandle();
        }

        //this->ApplicationObj->PrintHelpLink();
        $this->$handler();

        
        if (method_exists($this,"PostHandle"))
        {
            $this->PostHandle();
        }
    }
}

?>