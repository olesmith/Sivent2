<?php

trait Events_Config_Group_Data
{

    function Event_Config_Group_Datas($group)
    {
        return $this->Event_Config_Group_Defs_Get($group,"Datas");
    }
    
    function Event_Config_Group_Data_Groups_Show($group)
    {
        $res=False;
        if
            (
                $this->Event_Config_Group_CGI_Value()==$group
                &&
                $this->Event_Config_Group_Active_Is($group)
            )
        {
            $res=True;
        }

        return $res;
    }
    
    function Event_Config_Group_Data_Groups_Rows($group)
    {
        if ($this->Event_Config_Group_Data_Groups_Show($group))
        {
            return
                array
                (
                    array
                    (
                         $this->Event_Config_Group_Data_Html($group),
                    )
                );
        }
        else
        {
            return $this->Event_Config_Group_Data_Group_Inactive_Rows($group);
        }
    }
    
    function Event_Config_Group_Data_Html($group)
    {
        return
            $this->Htmls_Frame
            (
                $this->MyMod_Item_Group_Tables
                (
                    1,
                    $this->Event_Config_Group_Groups($group),
                    $this->Event(),
                    $this->Buttons()
                )
            );
      }
    

    function Event_Config_Group_Data_Group_Inactive_Rows($group)
    {
        return
            array
            (
                $this->Htmls_Div
                (
                    $this->Htmls_Frame
                    (
                        array
                        (
                            $this->Htmls_H
                            (
                                4,
                                $this->MyLanguage_GetMessage("Activate").
                                ": ".
                                $this->Event_Config_Group_Title($group)
                            ),
                            $this->Htmls_Table
                            (
                                "",
                                $this->Event_Config_Group_Datas_Table_Rows($group)
                            )
                        )
                    ),
                    array
                    (
                        "CLASS" => 'config config_event_table',
                    )
                )
            );
    }
    
    function Event_Config_Group_Datas_Rows($group)
    {
        $datas=$this->Event_Config_Group_Datas($group);
        
        if (empty($datas))
        {
            return $this->Event_Config_Group_Datas_Empty_Rows($group);
        }

        return
            array_merge
            (
                $this->Event_Config_Group_Datas_Title_Rows($group),
                $this->Event_Config_Group_Data_Groups_Rows($group)
            );
    }
    
    function Event_Config_Group_Datas_Table_Rows($group)
    {
        return
            array_merge
            (
                $this->MyMod_Item_Table
                (
                    1,
                    $this->Event(),
                    $this->Event_Config_Group_Datas($group)
                ),
                $this->Event_Config_Group_Datas_Table_Details($group),
                array($this->Buttons())
            );
    }
    function Event_Config_Group_Datas_Groups_Rows($group)
    {
        return
            array_merge
            (
                $this->MyMod_Item_Table
                (
                    1,
                    $this->Event(),
                    $this->Event_Config_Group_Datas($group)
                ),
                $this->Event_Config_Group_Datas_Table_Details($group),
                array($this->Buttons())
            );
    }
        
    function Event_Config_Group_Datas_Title_Rows($group)
    {
        return 
            $this->Event_Config_Cell_Rows
            (
                $group,
                $this->Event_Config("Config_Group_Datas_Title"),
                'config_datas_text'
            );
    }
    
    function Event_Config_Group_Datas_Table_Details($group)
    {
        $groups=$this->Event_Config_Group_Groups($group);
        if
            (
                empty($groups)
                ||
                !$this->Event_Config_Group_Active_Is($group)
            )
        { return array(); }

        return
            array
            (
                array
                (
                    $this->B
                    (
                        $this->GetRealNameKey
                        (
                            $this->Event_Config("Config_Details_Title")
                        )
                    ),
                    $this->Href
                    (
                        "?".$this->CGI_Hash2Query($args)."#".$group,
                        $this->GetRealNameKey
                        (
                            $this->Event_Config("Config_Details_Action_Title")
                        )
                    ),
                ),
            );
    }
        
    function Event_Config_Group_Datas_Empty_Rows($group)
    {
        return
            $this->Event_Config_Cell_Rows
            (
                $group,
                $this->Event_Config("Config_Group_Datas_Empty"),
                'config_datas_text'
            );
    }
}

?>