<?php

include_once("Group/Data.php");

trait Events_Config_Group
{
    use
        Events_Config_Group_Data;
    //*
    //* Returns config group.
    //*
    
    function Event_Config_Group_Defs_Get($group,$key="")
    {
        return $this->Event_Config($this->Event_Config_Groups_Key,$group,$key);
    }

    //*
    //* Returns config group title.
    //*
    
    function Event_Config_Group_Title($group)
    {
        return
            $this->GetRealNameKey
            (
                $this->Event_Config_Group_Defs_Get($group,"Title"),
                "Name"
            );
    }

    //*
    //* Generates one configuration Groups rows.
    //*
    
    function Event_Config_Group_CGI_Value()
    {
        $group=$this->CGI_GET($this->Event_Config_Group_CGI_Key);

        $rgroup=$this->Event_Config_Group;
        if (!empty($group))
        {
            if (!empty($this->Event_Config[ $this->Event_Config_Groups_Key  ][ $group ]))
            {
                $rgroup=$group;
            }
        }

        return $rgroup;
    }
    
    function Event_Config_Group_Modules($group)
    {
        return $this->Event_Config_Group_Defs_Get($group,"Modules");
    }
    function Event_Config_Group_Groups($group)
    {
        return $this->Event_Config_Group_Defs_Get($group,"Groups");
    }
    
    function Event_Config_Group_Key($group,$key)
    {
        return $this->Event_Config_Group_Defs_Get($group,$key);
    }
   
    function Event_Config_Group_Rows($group)
    {
        return array_merge
        (
            $this->Event_Config_Group_Title_Rows($group),
            $this->Event_Config_Group_Text_Rows($group),
            $this->Event_Config_Group_Datas_Rows($group),
            $this->Event_Config_Modules_Rows($group)
        );
    }
    
    function Event_Config_Group_Active_Is($group)
    {
        $defs=$this->Event_Config_Group_Defs_Get($group);
        if (!empty($defs[ "Active_Var" ]) && !empty($defs[ "Active_Value" ]))
        {
            $var=$defs[ "Active_Var" ];
            $value=$defs[ "Active_Value" ];
            if ($this->Event($var)!=$value)
            {
                return False;
            }
        }

        return True;
    }
    
    
    function Event_Config_Group_Title_Rows($group)
    {
        return
            array
            (
                array
                (
                    $this->Htmls_DIV
                    (
                        $this->GetRealNameKey
                        (
                            $this->Event_Config("Config_Subsystem_Title")
                        ).
                        $this->GetRealNameKey
                        (
                            $this->Event_Config_Group_Key($group,"Title")
                        ),
                        array
                        (
                            "CLASS" => 'config config_group_title',
                            "ID" => $group,
                        )
                    ),
                    $this->BR(),
                ),
            );
    }
    
    function Event_Config_Group_Text_Rows($group)
    {
        return
            array
            (
                array(),
                array
                (
                    "","","","",
                    $this->Htmls_DIV
                    (
                        $this->GetRealNameKey
                        (
                            $this->Event_Config_Group_Key($group,"Text")
                        ),
                        array("CLASS" => 'config config_group_text')
                    )
                ),
                $this->BR(),
            );
    }    
}

?>