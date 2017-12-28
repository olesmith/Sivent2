<?php

trait MyApp_Handle_ModuleSetup
{
    //*
    //* function MyApp_Handle_ModuleSetup, Parameter list:
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_ModuleSetup()
    {
        $this->MyApp_Interface_Head();

        $formtable="";
        if (isset($this->DBHash[ "Mod" ]) && $this->DBHash[ "Mod" ])
        {
            $formtable=
                $this->StartForm().
                $this->H
                (
                   5,
                   "Transferir Módulos: ".
                   $this->MakeCheckBox("TransferModule").
                   $this->Button("submit","Transferir")
                ).
                $this->EndForm();
            $formtable.=
                $this->StartForm().
                $this->H
                (
                   5,
                   "Transferir Sistema: ".
                   $this->MakeCheckBox("Transfer").
                   $this->Button("submit","Transferir")
                ).
                $this->EndForm();
        }
        
        if ($this->GetPOST("TransferModule")=='on')
        {
            $this->TransferModuleProfiles();
        }

        if ($this->GetPOST("Transfer")=='on')
        {
            $this->TransferProfiles();
        }

        echo
            $this->H(2,"Permissions and Profiles").
            $this->HtmlTable
            (
               "",
               array
               (
                  array($formtable)
               )
            );
    }

    //*
    //* function TransferModuleProfiles, Parameter list:
    //*
    //* Transfers profiles for all handlers.
    //*

    function TransferModuleProfiles()
    {
        foreach (array_keys($this->ModuleDependencies) as $module)
        {
            $class=$this->ApplicationClass;

            $mhash=array
            (
                  "ReadOnly"        => $this->ReadOnly,
                  "DBHash"          => $this->DBHash,
                  "LoginType"       => $this->LoginType,
                  "LoginData"       => $this->LoginData,
                  "LoginID"         => $this->LoginID,
                  "AuthHash"        => $this->AuthHash,
                  "ModuleName"      => $module,
                  "SqlTable"        => $this->SqlTable,
                  "SqlTableVars"    => $this->SqlTableVars,
                  "DefaultAction"   => $this->DefaultAction,
                  "DefaultProfile"  => $this->DefaultProfile,
                  "Profile"         => $this->Profile,
                  "ModuleLevel"     => 1,
                  "CompanyHash"     => $this->CompanyHash,
                  "MailInfo"        => $this->ApplicationObj()->MyApp_Mail_Info_Get(),
                  "URL_CommonArgs"  => $this->URL_CommonArgs,
                  "MySqlActions"    => $this->MySqlActions,
                  "Handle"          => FALSE,
            );

            if (isset($this->Period))
            {
                $mhash[ "Period" ]=$this->Period;
            }

            $object=new $class ($mhash);
            $object->InitModule($module,array(),FALSE);

            $object->Module->TransferProfiles();
        }
    }

    //*
    //* function TransferProfiles, Parameter list:
    //*
    //* Transfers profiles for all handlers.
    //*

    function TransferProfiles()
    {
        $moduleaccesses=array();
        foreach (array_keys($this->ModuleDependencies) as $module)
        {
            $access=$this->ReadPHPArray($this->MyMod_Setup_ProfilesDataFile($module));

            $access=$access[ "Access" ];

            $moduleaccesses[ $module ]=array();
            foreach ($this->GetListOfProfiles() as $profile)
            {
                $moduleaccesses[ $module ][ $profile ]=$access[ $profile ];
            }
        }

        if (isset($this->DBHash[ "Mod" ]) && $this->DBHash[ "Mod" ])
        {
            $file=$this->MyMod_Setup_ProfilesDataFile();
            $this->WritePHPArray($file,$moduleaccesses);

            print $this->H(4,"System Accesses written to ".$file);
        }
    }


}

?>