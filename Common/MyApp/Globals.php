<?php



trait MyApp_Globals
{
    //*
    //* function MyApp_Globals_Upload_Paths, Parameter list: 
    //*
    //* Returns list of upload paths for system. Should consider current profile.
    //*

    function MyApp_Globals_Upload_Paths($module="")
    {
        if (empty($module))
        {
            $module=$this->CGI_GET("ModuleName");
        }
        
        $paths=array();
        if (!empty($module))
        {
            $module.="Obj";
            $paths=array($this->$module()->MyMod_Data_Upload_Path());
        }

        return $paths;
    }
    
    //*
    //* function ActiveModule, Parameter list: 
    //*
    //* Returns (name of) active module.
    //*

    function ActiveModule()
    {
        if (!empty($this->Module))
        {
            return $this->Module->ModuleName;
        }

        return "";
    }
}

?>