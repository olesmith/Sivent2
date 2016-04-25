<?php
include_once("SubModules/Structure.php");

trait MyMod_SubModules
{
    use MyMod_SubModules_Structure;

    var $MyMod_SubModules_Loaded=array();

    //*
    //* function MyMod_SubModule_Load, Parameter list: $submodule,$initstructure=FALSE
    //*
    //* Lods $submodule.
    //*

    function MyMod_SubModule_Load($submodule,$initstructure=FALSE,$readitemdata=FALSE,$readitemgroupdata=FALSE,$readactions=FALSE)
    {
        $file=$this->SubModulesVars[ $submodule ][ "SqlFile" ];
        $class=$this->SubModulesVars[ $submodule ][ "SqlClass" ];
        $object=$this->SubModulesVars[ $submodule ][ "SqlObject" ];
        $table=$this->SubModulesVars[ $submodule ][ "SqlTable" ];

        if (!empty($this->MyMod_SubModules_Loaded[ $submodule ]))
        {
            return $object;
        }

        $this->MyMod_SubModules_Loaded[ $submodule ]=1;

        //Already loaded, just return, unless data  structure init force
        if (!isset($this->$object))
        {
            include_once($file);
            $this->$object=new $class
            (
               array
               (
                  "ApplicationObj" => $this,
                  "ModuleObj"      => $this->Module,
                  "DBHash"         => $this->DBHash,
                  "LoginType"      => $this->LoginType,
                  "LoginData"      => $this->LoginData,
                  "AuthHash"       => $this->AuthHash,
                  "ModuleName"     => $class,
                  "SqlTable"       => $table,
                  "SqlTableVars"   => $this->SqlTableVars,
                  "DefaultAction"  => "Search",
                  "Profile"        => $this->Profile,
                  "ModuleLevel"    => 2,
                )
            );

            $this->$object->MyHash_Args2Object($this->SubModulesVars[ $submodule ]);

            if ($this->Module)
            {
                $this->Module->$object=$this->$object;
            }

            $this->Modules[ $object ]=$this->$object;

            $this->$object->MyMod_Init();

            $this->MyMod_SubModule_ReadSetup($this->$object);

            $this->SetModulePermsSqlWhere($class,$this->$object);

            //$this->$object->MyMod_Init();
            $this->$object->SqlTable=$table;
            $this->$object->ApplicationObj=$this;

            foreach ($this->SqlTableVars as $id => $var)
            {
                if (isset($this->$var))
                {
                    $this->$object->$var=$this->$var;
                }
            }

            $this->$object->MyMod_Profiles_Init();
        }

        if ($readitemdata)
        {
            $this->$object->MyMod_Data_Init($initstructure,$readitemgroupdata);
        }

        return $object;
    }

    //*
    //* function MyMod_SubModule_ReadSetup, Parameter list: $obj
    //*
    //* Reads submodule specific setup.
    //*

    function MyMod_SubModule_ReadSetup($obj)
    {
        $object=$this->SubModulesVars[ $obj->ModuleName ][ "SqlObject" ];
        $class=$this->SubModulesVars[ $obj->ModuleName ][ "SqlClass" ];

        foreach ($this->SubModulesVars[ $class ] as $key => $value)
        {
            $this->$object->$key=$value;
        }
    }

}

?>