<?php

trait Events_Config_Modules
{
    function Event_Config_Modules_Rows($group)
    {
        $modules=$this->Event_Config_Group_Modules($group);
        
        if (empty($modules))
        {
            return $this->Event_Config_Modules_Empty_Rows($group);
        }

        $table=$this->Event_Config_Modules_Table_Title_Rows($group);
        $odd=False;
        foreach ($modules as $module => $moduledef)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Event_Config_Module_Rows($group,$module,$odd)
                );

            $odd=!$odd;
        }
        
        return
            array_merge
            (
                $this->Event_Config_Modules_Title_Rows($group),
                array
                (
                    $this->Html_Table("",$table,array(),array(),array(),True,True),
                )
            );    
    }
    
    function Event_Config_Modules_Title_Rows($group)
    {
        return
            $this->Event_Config_Cell_Rows
            (
                $group,
                $this->Event_Config("Config_Group_Modules_Title"),
                'config_modules_text'
            );
    }
    
    function Event_Config_Modules_Table_Title_Rows($group)
    {
        $titles=
            $this->Html_Table_Head_Row
            (
                $this->GetRealNameKey
                (
                    $this->Event_Config("Config_Group_Table_Titles")
                )
            );

        return array($titles);
    }
    
    function Event_Config_Modules_Text_Rows($group)
    {
        return
            $this->Event_Config_Cell_Rows
            (
                $group,
                $this->Event_Config_Group_Key($group,"Text"),
                'config_modules_text'
            );

    }
    
    function Event_Config_Modules_Empty_Rows($group)
    {
        return
            $this->Event_Config_Cell_Rows
            (
                $group,
                $this->Event_Config("Config_Group_Modules_Empty"),
                'config_modules_text'
            );
    }
}
