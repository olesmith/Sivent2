<?php


trait MyApp_Setup_Data
{
    //*
    //* Returns name of file containing setup data
    //*

    function MyApp_Setup_DataFileName($fid,$module="")
    {
        if (empty($module)) { $module=$this->ModuleName; }

        $file="";
        if (!empty($this->SetupFileDefs[ $fid ][ "File" ]))
        {
            $file=$this->SetupFileDefs[ $fid ][ "File" ];
        }

        if (empty($file) || !is_file($file))
        {
            $file=$this->MyApp_Setup_DataDef_FileName($fid);
            $file=preg_replace('/\.php$/',".Data.php",$file);
            $file=preg_replace
            (
               '/^'.$this->SetupPath.'/',
               $this->SetupPath."/Defs",
               $file
            );
        }

        if (empty($file) || !is_file($file))
        {
            $file=$this->SetupPath."/".$module."/Vars.php";
        }

        if (empty($file) || !is_file($file))
        {
            if (!empty($this->Module))
            {
                $file=$this->Module->SetupDataPath()."/Vars.php";
            }
        }


        if (empty($file) || !is_file($file))
        {
            if (!empty($module))
            {
                $file=
                    $this->SetupPath.
                    "/".
                    preg_replace
                    (
                       '/\.php/',
                       "/Vars.php",
                       $this->SubModulesVars[ $module ][ "SqlFile" ]
                    );
            }
        }

        if (empty($file) || !is_file($file))
        {
            if (!empty($module))
            {
                $file=$this->ModuleSetupPath($module)."Vars.php";
            }
        }

        if (is_file($file))
        {
            $this->SetupFileDefs[ $fid ][ "File" ]=$file;
        }

        return $file;
    }
}

?>