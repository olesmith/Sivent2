<?php


include_once("MyActions/Error.php");
include_once("MyActions/Defaults.php");
include_once("MyActions/Files.php");
include_once("MyActions/Read.php");
include_once("MyActions/Add.php");
include_once("MyActions/Access.php");
include_once("MyActions/Entry.php");
include_once("MyActions/Permissions.php");
include_once("MyActions/Info.php");

trait MyActions
{
    use
        MyActions_Error,
        MyActions_Defaults,
        MyActions_Files,
        MyActions_Read,
        MyActions_Add,
        MyActions_Entry,
        MyActions_Permissions,
        MyActions_Access,
        MyActions_Info;


    //*
    //* function MyActions_Init, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyActions_Init()
    {
        $this->Actions();
    }

    //*
    //* function MyActions_GetSave, Parameter list: $action
    //*
    //* Returns fffirst action that is permitted.
    //*

    function MyActions_GetSave($action)
    {
        if (!$this->Actions) { return ""; }

        if (isset($this->Actions[ $action ][ "AltAction" ]))
        {
             $raction=$this->Actions[ $action ][ "AltAction" ];
        }
        else
        {
            $raction=$this->DefaultAction;
        }
        
        if ($raction=="" || (!$this->MyAction_Allowed($raction)) )
        {
            foreach ($this->Actions as $taction => $actiondef)
            {
                if ($this->MyAction_Allowed($taction))
                {
                    $raction=$action;
                }
            }
        }

        if ($raction=="")
        {
            $this->DoDie("Actions exhausted...",$action);
        }

        //$this->Actions[ $action ][ "Name" ]=$this->Actions[ $raction ][ "Name" ];

        return $raction;
    }

    //*
    //* function MyActions_Detect, Parameter list: $action,$withid=FALSE
    //*
    //* Detects current Action, which should be readable from the POST Action.
    //*

    function MyActions_Detect()
    {
        $args=$this->CGI_URI2Hash();

        if ($this->NextAction!="")
        {
            $raction=$this->NextAction;
        }
        else
        {
            $raction=$this->CGI_GETOrPOST("Action");
        }

        if ($raction=="") { $raction=$this->DefaultAction; }
        if ($raction=="")
        {
            $raction=$args[ "Action" ];
        }

        $res=$this->MyAction_Allowed($raction);
 
        if (!$res)
        {
           $raction=$this->MyActions_GetSave($raction);
        }
        $this->Action=$raction;

        //Only update singular/plural settings, if we are primary module.
        if ($this->CGI_GET("ModuleName")==$this->ModuleName)
        {
            $this->Singular=FALSE;
            if ($this->Actions)
            {
                if (
                     isset($this->Actions[ $raction ][ "Singular" ])
                     &&
                     $this->Actions[ $raction ][ "Singular" ]==1
                   )
                {
                    $this->Singular=TRUE;
                }
                else
                {
                    $this->Singular=FALSE;
                }
            }
        }

        return $raction;
    }
}

?>