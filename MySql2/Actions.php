<?php

class Actions extends Profile
{
    //General menus
    var $Plural=TRUE;
    var $Singular=FALSE;
    var $ReadOnly=FALSE;
    var $ActionsSingular=array("Show","Edit","Copy","Delete");
    var $ActionsSingularPlural=array("Add","Search","EditList");
    var $ActionsPlural=array("Add","Search","EditList","Export","Zip");
    var $NonPostVars=array();
    var $NonGetVars=array();


    var $NextAction="";
    var $DefaultAction="Search";
    var $MySqlActions=TRUE;


    var $ActionNameKey="Name";
    var $ActionTitleKey="Title";

    //Vars to filter (from $this->varname) in ActionEntry.
    var $ActionArgVars=array();

    //*
    //* function InitActions, Parameter list:
    //*
    //* Initilizes Actions class, ie:
    //* Reads actions from independent file: Actions/Actions.php.
    //* Uses SearchForFile (include_path) to locate this file,
    //* phisically located in subdir below Actions.php (this file).
    //*
    //* Also adds module specific action; in $this->ModuleName."/Actions.php".
    //*

    function InitActions()
    {
        $this->MyActions_Init();
    }


    //*
    //* function ActionName, Parameter list: $action
    //*
    //* Returns the name ("Name" key) of action $action.
    //*

    function ActionName($action,$key="Name")
    {
        if (!empty($this->Actions[ $action ][ $key ]))
        {
            $action=$this->Actions[ $action ][ $key ];
        }

        return $action;
    }

    //*
    //* function GetActionNames, Parameter list: $actions
    //*
    //* Returns the names ("Name" key) of action $actions.
    //*

    function GetActionNames($actions)
    {
        $names=array();
        foreach ($actions as $action)
        {
            array_push($names,$this->ActionName($action));
        }

        return $names;
    }


    //*
    //* function UnSUAccess, Parameter list: 
    //*
    //* Does what's necessary to allow action UnSU.
    //*

    function UnSUAccess()
    {
         if (
              isset($this->SessionData[ "SULoginID" ])
              &&
              $this->SessionData[ "SULoginID" ]>0
           )
        {
            return TRUE;
        }

        return FALSE;
    }
}
?>