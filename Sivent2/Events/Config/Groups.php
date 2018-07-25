<?php

trait Events_Config_Groups
{
    //*
    //* Returns config groups.
    //*
    
    function Event_Config_Groups_Get($group="")
    {
        return $this->Event_Config($this->Event_Config_Groups_Key);
    }
    
    //*
    //* Generates one configuration Groups rows.
    //*
    
    function Event_Config_Groups_Rows()
    {
        $currentgroup=$this->Event_Config_Group_CGI_Value();

        $table=array();
        foreach ($this->Event_Config_Groups_Get() as $group => $groupdefs)
        {
            if ($currentgroup==$group)
            {
                $table=
                    array_merge
                    (
                        $table,
                        array
                        (
                            $this->FrameIt
                            (
                                array
                                (
                                    array($this->Event_Config_Menu()),
                                    array($this->Event_Config_Group_Rows($group)),
                                ),
                                array("WIDTH" => '100%')
                            )
                        )
                    );
            }
        }

        return $table;
    }
    
    function Event_Config_Groups_Title_Rows()
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
                            $this->Event_Config("Config_Groups_Text")
                        ),
                        array
                        (
                            "CLASS" => 'config config_groups_title',
                            "ID" => 'GROUP'
                        )
                    ),
                )
            );
    }
}
