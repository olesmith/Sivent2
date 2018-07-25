<?php

trait MyApp_Module_Load
{
    //*
    //* function MyApp_Module_Load, Parameter list: $module
    //*
    //* Loads App module.
    //*

    function MyApp_Module_Load($module,$args=array(),$initdbtable=TRUE,$initactions=TRUE)
    {
        $file=$this->SubModulesVars[ $module ][ "SqlFile" ];

        //Load module file
        include_once("./".$file);

         //We must have access to this table/module
        $this->MyApp_Module_Access_Require($module);

        $mhash=array
        (
           "ApplicationObj"  => $this,
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
         );

        if (isset($this->Period))
        {
            $mhash[ "Period" ]=$this->Period;
        }

        foreach ($args as $key => $value)
        {
            $mhash[ $key ]=$value;
        }

        //Create MySql2 object!!
        $this->Module=new $module ($mhash);

        $this->Module->MyHash_Args2Object($this->SubModulesVars[ $module ]);


        $object=$this->SubModulesVars[ $module ][ "SqlObject" ];
        $this->$object=$this->Module;

        $this->Modules[ $module ]=$this->Module;

        $this->Module->MyMod_Init();
        foreach ($this->SqlTableVars as $id => $var)
        {
            if (isset($this->$var))
            {
                $this->Module->$var=$this->$var;
            }
        }

        $this->Module->MyMod_Profiles_Init();
        
        if (file_exists($this->Module->MyMod_Setup_Item_Data_File($module)))
        {
            $this->Module->MyMod_Data_Init($initdbtable,TRUE); //TRUE to update DB cols
        }

        if ($initactions)
        {
            $this->Module->MyActions_Init();
        }

        if (file_exists($this->MyMod_Setup_Latex_File()))
        {
            $this->Module->InitLatexData();
        }

        $this->SetModulePermsSqlWhere($module,$this->Module);


        $this->MyApp_Module_Init();


        return $this->Module;
    }
}

?>