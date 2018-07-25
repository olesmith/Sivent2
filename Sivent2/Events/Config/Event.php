<?php

trait Events_Config_Event
{
    function Event_Config_Event_Form($edit=0,$event=array())
    {
        return
            $this->Htmls_Form
            (
                $edit,
                "Config",
                $action="",
                $this->Event_Config_Event_Html($edit,$event),
                $args=array
                (
                    "Save_CGI_Key" => "Save",
                    "Uploads" => True,
                ),
                $options=array()
            );
    }
    
    function Event_Config_Event_Html($edit=0,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        if ($edit==1)
        {
            if ($this->CGI_POSTint("Save")==1)
            {
                $event=$this->MyMod_Item_Update_CGI($event);
                $this->ApplicationObj()->Event=$event;
            }
        }

        return
            $this->Htmls_Table
            (
                "",
                array_merge
                (
                    $this->Event_Config_Event_Title_Rows($edit,$event),
                    $this->Event_Config_Event_Data_Rows($edit),
                    $this->Event_Config_Groups_Title_Rows(),
                    $this->Event_Config_Groups_Rows()
                )
            );
    }
    
    function Event_Config_Event_Data_Html($edit=0,$event=array())
    {
        return
            $this->Htmls_Frame
            (
                $this->MyMod_Item_Group_Table_HTML
                (
                    $edit,
                    $this->Event_Config_SGroup,
                    $event,
                    $plural=FALSE,$precgikey="",
                    $options=array(),$title="",
                    array(),
                    array($this->Buttons())
                )
            );
    }
        
    function Event_Config_Event_Data_Rows($edit=0,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        return
            array
            (
                array
                (
                    $this->Event_Config_Event_Data_Html($edit,$event)
                ),
            );
    }

    
    function Event_Config_Event_Title_Rows($edit=0,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        return
            array
            (
                array
                (
                    $this->Event_Config_Title($edit,$event),
                ),
                array
                (
                    $this->Event_Config_Event_Title($edit,$event),
                ),
            );

    }
    
    function Event_Config_Title($edit=0,$event=array())
    {
        return
            $this->Htmls_DIV
            (
                $this->GetRealNameKey
                (
                    $this->Event_Config("Config_Title")
                ),
                array("CLASS" => 'config config_title')
            );
    }
    
    function Event_Config_Event_Title($edit=0,$event=array())
    {
        return
            $this->Htmls_DIV
            (
                $this->GetRealNameKey
                (
                    $event,
                    "Title"
                ),
                array("CLASS" => 'config config_event_title')
            );
    }
}

?>
