<?php


trait MyActions_Permissions
{
    //*
    //* function MyActions_SetPermissions, Parameter list: 
    //*
    //* Adds actions
    //*

    function MyActions_SetPermissions()
    {
        if (!$this->IsMain())
        {
            $actions=$this->ModuleProfiles("Actions");
            if (!empty($actions))
            {
                foreach (array_keys($actions) as $action)
                {
                    $this->MyAction_SetPermissions($action);
                }
            }
       }
    }

    //*
    //* function MyAction_SetPermissions, Parameter list: $action
    //*
    //* Take $action permissions.
    //*

    function MyAction_SetPermissions($action)
    {
        if (!isset($this->Actions[ $action ]))
        {
            $this->Actions[ $action ]=array();
        }

        
        foreach ($this->ModuleProfiles[ "Actions" ][ $action ] as $key => $value)
        {
            $this->Actions[ $action ][ $key ]=$value;

        }
   }


}

?>