<?php

trait MyActions_Defaults
{
    //*
    //* function MyActions_DefaultActionDefs, Parameter list: 
    //*
    //* Returns actions default definitions.
    //*

    function MyActions_DefaultActionDefs()
    {
        return array
        (
            "Href"          => "",
            "HrefArgs"      => "",
            "Title"         => "",
            "Title_UK"      => "",
            "Name"          => "",
            "Name_UK"       => "",
            "Icon"          => "",
            "Public"        => FALSE,
            "Person"        => FALSE,
            "Admin"         => FALSE,
            "AccessMethod"  => "",
            "NameMethod"    => "",
            "TitleMethod"   => "",
            "Edits"         => FALSE,
            "Handler"       => "",
            "Singular"      => FALSE,
            "NoHeads"       => FALSE,
            "AddIDArg"      => FALSE,
            "Target"        => FALSE,
            "GenMethod"     => FALSE,
            "NonPostVars"   => array(),
            "NonGetVars"    => array(),
            "Anchor"        => "HorMenu",
            "AltAction"     => FALSE, //alternator to inlcude in menues, when action is current
        );

    }

    //*
    //* function MyActions_AddDefaultKeys, Parameter list: &$actions
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyActions_AddDefaultKeys(&$actions)
    {
        $defaults=$this->MyActions_DefaultActionDefs();

        foreach (array_keys($actions) as $action)
        {
            $this->MyAction_AddDefaultKeys($actions[ $action ],$defaults);
        }
    }

    //*
    //* function MyAction_AddDefaultKeys, Parameter list: &$action,$defaults=array()
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyAction_AddDefaultKeys(&$action,$defaults=array())
    {
        if (empty($defaults))
        {
            $defaults=$this->MyActions_DefaultActionDefs();
        }

        $this->MyHash_AddDefaultKeys($action,$defaults);

        $this->MyMod_Profiles_AddDefaultKeys($action);
    }
}

?>