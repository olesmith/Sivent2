<?php

//include_once("Handle/Start.php");

trait MyMod_Setup
{
    var $SetupFileDefs=array();
    //use MyApp_Handle_Start;

    var $MyMod_Setup_ItemData_File="Data.php";
    var $MyMod_Setup_Latex_File="Latex.Data.php";
    var $MyMod_Setup_Actions_File="Actions.php";
    var $MyMod_Setup_Profiles_File="Profiles.php";
    var $MyMod_Setup_LeftMenu_File="LeftMenu.php";

    //*
    //* function MyMod_Setup_Path, Parameter list: 
    //*
    //* Returns SetupDataPath.
    //*

    function MyMod_Setup_Path()
    {
        $path=$this->ApplicationObj()->MyApp_Setup_Path();

        if (
              !empty($this->ModuleName)
              &&
              !empty($this->ApplicationObj()->SubModulesVars[ $this->ModuleName ])
           )
        {
            $path.= 
                "/".
                preg_replace
                (
                   '/\.php$/',
                   "",
                   $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ 'SqlFile' ]
                );
        }

        return $path;
    }

    //*
    //* function MyMod_Setup_Parse, Parameter list: $files
    //*
    //* Parses out #Module and #System in $files.
    //*

    function MyMod_Setup_Parse($files)
    {
        $hash=array
        (
           "System" => $this->ApplicationObj()->MyApp_Setup_Path(),
        );

        if (!empty($this->ApplicationObj()->SubModulesVars[ $this->ModuleName ]))
        {
            $hash[ "Module" ]=preg_replace
            (
               '/\.php$/',
               "",
               $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ 'SqlFile' ]
             );
        }

        foreach (array_keys($files) as $fid)
        {
            $files[ $fid ]=$this->Filter($files[ $fid ],$hash);
        }

        return $files;
    }

    //*
    //* function MyMod_Setup_File, Parameter list: $file
    //*
    //* Returns SetupDataPath.
    //*

    function MyMod_Setup_File($file)
    {
        return $this->MyMod_Setup_Path()."/".$file;
    }

    //*
    //* function MyMod_Setup_ItemDataFile, Parameter list: 
    //*
    //* Returns SetupDataPath.
    //*

    function MyMod_Setup_ItemDataFile()
    {
        return $this->MyMod_Setup_File($this->MyMod_Setup_ItemData_File);
    }

    //*
    //* function MyMod_Setup_LatexDataFile, Parameter list:
    //*
    //* Returns name of LatexData file specific to $this->ModuleName
    //*

    function MyMod_Setup_LatexDataFile()
    {
        return $this->MyMod_Setup_File($this->MyMod_Setup_Latex_File);
    }

    //*
    //* function MyMod_Setup_ActionsDataFile, Parameter list: 
    //*
    //* Returns name of Actions file specific to $this->ModuleName
    //*

    function MyMod_Setup_ActionsDataFile()
    {
        return $this->MyMod_Setup_File($this->MyMod_Setup_Actions_File);
    }

    //*
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules. 
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return $this->MyMod_Setup_File($this->MyMod_Setup_Profiles_File);
    }

    //*
    //* function MyMod_Setup_LeftMenuDataFile, Parameter list:
    //*
    //* Returns name of file with Left Menu. 
    //*

    function MyMod_Setup_LeftMenuDataFile()
    {
        return $this->MyMod_Setup_File($this->MyMod_Setup_LeftMenu_File);
    }


}

?>